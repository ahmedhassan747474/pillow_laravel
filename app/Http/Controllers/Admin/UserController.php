<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Country;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use DB;
use App\Property;
use App\Transformers\Admin\PropertyTransformer;

class UserController extends BaseController
{
    function __construct() 
    {
        $this->middleware(function ($request, $next) {
            checkPermission('is_user');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $users = User::whereUserType('1')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        checkGate('can_create');

        $results = Country::whereStatus('1');
        if (App::isLocale('ar')) {
            $results->select('id', 'name_ar as name', 'flag', 'code', 'latitude', 'longitude');
        } else {
            $results->select('id', 'name_en as name', 'flag', 'code', 'latitude', 'longitude');
        }
        $countries = $results->get();
        
        return view('admin.users.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request['phone_number'] = convert($request->phone_number);

        $validator = Validator::make($request->all(), [
            'name'          => 'required|string',
            'surename'      => 'nullable|string',
            'phone'         => 'required|unique:users,phone_number',
            'country'       => 'required',
            'image'         => 'nullable|image',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|confirmed'            
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }
        
        if($request->has('image')){
            $image          = $request->image;
            $extension      = $image->getClientOriginalExtension();
            $imageRename    = time(). uniqid() . '.'.$extension;

            $path           = public_path("images\users");

            if(!File::exists($path)) File::makeDirectory($path, 775, true);

            $img = Image::make($image)->resize(null, 700, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_path('images/users/').$imageRename);
        } else {
            $imageRename = 'user_default.png';
        }
        
        $request['password'] = bcrypt($request->password);
        
        $user = User::create([
            'name'                  =>  $request->name,
            'surename'              =>  $request->surename,
            'image'                 =>  $imageRename,
            'phone_code'            =>  $request->country,
            'phone_number'          =>  $request->phone,
            'email'                 =>  $request->email,
            'password'              =>  $request->password,
            'user_type'             =>  '1',
            'status'                =>  '1'
        ]);

        $success = trans('common.created Successfully');
        return redirect()->route('show_user', $user->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $user = User::find($id);
        $apartments =   DB::table('properties')->where('owner_id', $id)->get();
        // $apartments =   DB::table('properties')->where('owner_id', $id)::orderBy('id', 'desc');
        // $apartments =  PropertyList::where('owner_id', $id)->get();
        if ($apartments || $apartments != null) {
            // list is empty.
            //  dd($apartments);
        $apartments = Property::orderBy('id', 'desc')->where('owner_id', $id);

            $apartments = $apartments->paginate(20);

            $apartments = (new PropertyTransformer)->transformCollection($apartments->getCollection());
            // dd($apartments);

        }

        return view('admin.users.show', compact('user','apartments'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $user = User::find($id);

        $results = Country::whereStatus('1');
        if (App::isLocale('ar')) {
            $results->select('id', 'name_ar as name', 'flag', 'code', 'latitude', 'longitude');
        } else {
            $results->select('id', 'name_en as name', 'flag', 'code', 'latitude', 'longitude');
        }
        $countries = $results->get();
        
        return view('admin.users.edit', compact('user', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $request['phone_number'] = convert($request->phone_number);

        $validator = Validator::make($request->all(), [
            'name'          => 'required|string',
            'surename'      => 'nullable|string',
            'phone'         => 'required|unique:users,phone_number,'. $id,
            'country'       => 'required',
            'image'         => 'nullable|image',
            'email'         => 'required|email|unique:users,email,'. $id,
            'password'      => 'nullable|confirmed'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        if($request->has('image')){
            $curentPhoto    = $user->image;
            $image          = $request->image;
            $extension      = $image->getClientOriginalExtension();
            $imageRename    = time(). uniqid() . '.'.$extension;

            $path           = public_path("images\users");

            if(!File::exists($path)) File::makeDirectory($path, 775, true);

            $img = Image::make($image)->resize(null, 700, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_path('images/users/').$imageRename);

            $upload_image   = User::where('id', $user->id)->update(['image' => $imageRename]);

            $userPhoto      = public_path('images/users/').$curentPhoto;

            if(file_exists($userPhoto) && $curentPhoto != 'user_default.png'){
                @unlink($userPhoto);
            }
        }

        if($request->filled('password'))
        {
            $password = bcrypt($request->password);
            $updatePassword   = User::where('id', $user->id)->update(['password' => $password]);
        }
        
        $user->update([
            'name'                  =>  $request->name,
            'surename'              =>  $request->surename,
            'phone_code'            =>  $request->country,
            'phone_number'          =>  $request->phone,
            'email'                 =>  $request->email,
        ]);

        $success = trans('common.Updated Successfully');

        return redirect()->route('show_user', $user->id)->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $user = User::findOrFail($id);

        $user->delete();

        // return redirect()->route('users');
        return response()->json(['success' => 'Deleted Successfully']);
    }
    
    public function blockUser(Request $request)
    {
        $id = $request->user_id;
        //$message = $request->type == 'block' ? 'تم الغاء التفعيل المستخدم بنجاح' : 'تم تفعيل المستخدم بنجاح';
        $message = $request->status == '0' ? trans('common.User is Blocked Successfully') : trans('common.User is Activated Successfully');
        $user = User::find($id);
        $user->status = $request->status;
        $user->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
    
    public function filter(Request $request)
    {
        $results = (new User)->newQuery();

        if($request->search_text != null)
        {
            $results->where(function($q) use ($request){
                $q->where('name', 'like', '%'.$request->search_text.'%');
            });
        }
        
        if($request->count != "all")
        {
            if($request->count == '1'){
                $results
                // ->whereHas('campaigns', function($q) {
                //     $q->withCount('id')->;
                // })
                ->withCount('campaigns')
                ->orderBy('campaigns_count', 'desc');
            } else {
                $results
                ->withCount('campaigns')
                ->orderBy('campaigns_count', 'asc');
            }
        }

        if($request->status != "all")
        {
            if($request->status == '1')
            {
                $results->where('is_blocked', '0');
            }
            else if($request->status == '2')
            {
                $results->where('is_blocked', '1');
            }
        }

        if($request->sort != "all")
        {
            if($request->sort == '1'){
                $results->orderBy('id', 'desc');
            } else {
                $results->orderBy('id', 'asc');
            }
        }

        // $users = $results->paginate(8);
        $users = $results->whereUserType('1')->with('userCountry', 'campaigns')->get();
        
        return view('admin.advertiser.index', compact('users'));
    }
}
