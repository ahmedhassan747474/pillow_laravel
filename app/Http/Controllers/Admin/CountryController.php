<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class CountryController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            checkPermission('is_country');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $country = Country::whereStatus('1')->orderBy('id', 'desc');
        if (App::isLocale('ar')) {
            $country->select('id', 'name_ar as name', 'flag', 'code', 'status');
        } else {
            $country->select('id', 'name_en as name', 'flag', 'code', 'status');
        }
        $countries = $country->paginate(20);

        return view('admin.country.index', compact('countries'));
    }

    public function create()
    {
        checkGate('can_create');

        return view('admin.country.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string',
            'flag'         		=> 'required|image',
            'code'         		=> 'required'
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        if($request->has('flag')){
    		$image 			= $request->flag;
    		$extension      = $image->getClientOriginalExtension();
            $imageRename    = time(). uniqid() . '.'.$extension;

            $path           = public_path("images\countries");

            if(!File::exists($path)) File::makeDirectory($path, 775, true);

            $img = Image::make($image)->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save('images/countries/'.$imageRename);
        }

        $country = Country::create([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
          	'flag'				=> $imageRename,
          	'code'       		=> $request->code,
          	'status'			=> '1'
        ]);

        $success = trans('common.created Successfully');
        return redirect()->route('show_country', $country->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $data = Country::whereId($id);
        if (App::isLocale('ar')) {
            $data->select('id', 'name_ar as name', 'flag', 'code');
        } else {
            $data->select('id', 'name_en as name', 'flag', 'code');
        }
        $country = $data->first();

        return view('admin.country.show', compact('country'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $country = Country::find($id);

        return view('admin.country.edit', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $country = Country::find($id);

        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string',
            'flag'         		=> 'nullable|image',
            'code'         		=> 'required'
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        if($request->has('flag')){
            $curentPhoto    = $country->flag;
            $image          = $request->flag;
            $extension      = $image->getClientOriginalExtension();
            $imageRename    = time(). uniqid() . '.'.$extension;

            $path           = public_path("images\countries");

            if(!File::exists($path)) File::makeDirectory($path, 775, true);

            $img = Image::make($image)->resize(null, 700, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save('images/countries/'.$imageRename);

            $upload_image   = Country::where('id', $country->id)->update(['flag' => $imageRename]);

            $userPhoto      = public_path('images/countries/').$curentPhoto;
        }

        $country->update([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'code'    			=> $request->code
        ]);

        $success = trans('common.Updated Successfully');

        return redirect()->route('countries')->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $country = Country::find($id);

        $country->delete();

        return response()->json(['success' => 'Deleted Successfully']);
    }

    public function blockCountry(Request $request)
    {
        $id = $request->id;
        $message = $request->status == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $country = Country::find($id);
        $country->status = $request->status;
        $country->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
