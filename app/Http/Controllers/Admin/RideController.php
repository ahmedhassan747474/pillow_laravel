<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Ride;
use App\Country;
use App\Property;
use App\PropertyList;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use DB;
use App\Transformers\Admin\PropertyTransformer;
use App\PropertyImage;
use App\PropertyAttribute;
use App\City;
use App\Attribute;

class RideController extends Controller
{
    function __construct(PropertyTransformer $property_transformer) 
    {
        $this->property_transformer = $property_transformer;

        $this->middleware(function ($request, $next) {
            checkPermission('is_ride');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $rides = User::whereUserType('2')->paginate(20);

        return view('admin.ride.index', compact('rides'));
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
        
        return view('admin.ride.create', compact('countries'));
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

            $path           = public_path('images\users');

            if(!File::exists($path)) File::makeDirectory($path, 775, true);

            $img = Image::make($image)->resize(null, 700, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_path('images/users/').$imageRename);
        } else {
            $imageRename = 'user_default.png';
        }
        
        $request['password'] = bcrypt($request->password);
        
        $ride = User::create([
            'name'                  =>  $request->name,
            'image'                 =>  $imageRename,
            'phone_code'            =>  $request->country,
            'phone_number'          =>  $request->phone,
            'email'                 =>  $request->email,
            'password'              =>  $request->password,
            'user_type'             =>  '2',
            'status'                =>  '1'
        ]);

        $rideSource = Ride::create([
            'name'                  =>  $request->name,
            'image'                 =>  $imageRename,
            'phone_code'            =>  $request->country,
            'phone_number'          =>  $request->phone,
            'user_id'               =>  $ride->id
        ]);

        $success = trans('common.created Successfully');
        return redirect()->route('show_ride', $ride->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $ride = User::find($id);
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

        return view('admin.ride.show', compact('ride','apartments'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $ride = User::find($id);

        $results = Country::whereStatus('1');
        if (App::isLocale('ar')) {
            $results->select('id', 'name_ar as name', 'flag', 'code', 'latitude', 'longitude');
        } else {
            $results->select('id', 'name_en as name', 'flag', 'code', 'latitude', 'longitude');
        }
        $countries = $results->get();
        
        return view('admin.ride.edit', compact('ride', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $ride = User::find($id);

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
            $curentPhoto    = $ride->image;
            $image          = $request->image;
            $extension      = $image->getClientOriginalExtension();
            $imageRename    = time(). uniqid() . '.'.$extension;

            $path           = public_path('images\users');

            if(!File::exists($path)) File::makeDirectory($path, 775, true);

            $img = Image::make($image)->resize(null, 700, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_path('images/users/').$imageRename);

            $upload_image   = User::where('id', $ride->id)->update(['image' => $imageRename]);

            $upload_image_source   = Ride::where('user_id', $ride->id)->update(['image' => $imageRename]);

            $userPhoto      = public_path('images/users/').$curentPhoto;

            if(file_exists($userPhoto) && $curentPhoto != 'user_default.png'){
                @unlink($userPhoto);
            }
        }

        if($request->filled('password'))
        {
            $password = bcrypt($request->password);
            $updatePassword   = User::where('id', $ride->id)->update(['password' => $password]);
        }
        
        $ride->update([
            'name'                  =>  $request->name,
            'surename'              =>  $request->surename,
            'phone_code'            =>  $request->country,
            'phone_number'          =>  $request->phone,
            'email'                 =>  $request->email,
        ]);

        $update_ride_source = Ride::where('user_id', $ride->id)->update([
        	'name'                  =>  $request->name,
        	'phone_code'            =>  $request->country,
            'phone_number'          =>  $request->phone
        ]);

        $success = trans('common.Updated Successfully');

        return redirect()->route('show_ride', $ride->id)->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $ride = User::findOrFail($id);

        $ride->delete();

        // return redirect()->route('users');
        return response()->json(['success' => 'Deleted Successfully']);
    }
    
    public function blockRide(Request $request)
    {
        $id = $request->user_id;
        //$message = $request->type == 'block' ? 'تم الغاء التفعيل المستخدم بنجاح' : 'تم تفعيل المستخدم بنجاح';
        $message = $request->status == '0' ? trans('common.User is Blocked Successfully') : trans('common.User is Activated Successfully');
        $ride = User::find($id);
        $ride->status = $request->status;
        $ride->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
