<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PropertyList;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class PropertyListController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            checkPermission('is_property');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $property = PropertyList::whereStatus('1')->orderBy('id', 'desc');
        if (App::isLocale('ar')) {
            $property->select('id', 'name_ar as name', 'image', 'status');
        } else {
            $property->select('id', 'name_en as name', 'image', 'status');
        }
        $properties = $property->paginate(20);

        return view('admin.property.index', compact('properties'));
    }

    public function show($id)
    {
        checkGate('can_show');

        $data = PropertyList::whereId($id);
        if (App::isLocale('ar')) {
            $data->select('id', 'name_ar as name', 'image', 'status');
        } else {
            $data->select('id', 'name_en as name', 'image', 'status');
        }
        $property = $data->first();

        return view('admin.property.show', compact('property'));
    }

    public function create()
    {
        checkGate('can_edit');

        return view('admin.property.create');
    }

    public function store(Request $request)
    {
        // $property = PropertyList::find($id);

        $validator = Validator::make($request->all(), [
            // 'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string',
            'image'         	=> 'nullable|image'
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        if($request->has('image')){
            // $curentPhoto    = $property->image;
            $image          = $request->image;
            $extension      = $image->getClientOriginalExtension();
            $imageRename    = time(). uniqid() . '.'.$extension;

            $path           = public_path("images\property_list");

            if(!File::exists($path)) File::makeDirectory($path, 775, true);

            $img = Image::make($image)->resize(null, 700, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save('images/property_list/'.$imageRename);

            // $upload_image   = PropertyList::where('id', $property->id)->update(['image' => $imageRename]);

            // $userPhoto      = public_path('images/property_list/').$curentPhoto;
        }

        PropertyList::create([
            'name_en'       	=> $request->name_en??$request->name_ar,
            'name_ar'       	=> $request->name_ar,
            // 'code'    			=> $request->code,
            'image'    			=> $imageRename??''
        ]);

        $success = trans('common.Created Successfully');

        return redirect()->route('properties')->with('success', $success);
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $property = PropertyList::find($id);

        return view('admin.property.edit', compact('property'));
    }

    public function update(Request $request, $id)
    {
        $property = PropertyList::find($id);

        $validator = Validator::make($request->all(), [
            // 'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string',
            'image'         	=> 'nullable|image'
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        if($request->has('image')){
            $curentPhoto    = $property->image;
            $image          = $request->image;
            $extension      = $image->getClientOriginalExtension();
            $imageRename    = time(). uniqid() . '.'.$extension;

            $path           = public_path("images\property_list");

            if(!File::exists($path)) File::makeDirectory($path, 775, true);

            $img = Image::make($image)->resize(null, 700, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save('images/property_list/'.$imageRename);

            $upload_image   = PropertyList::where('id', $property->id)->update(['image' => $imageRename]);

            $userPhoto      = public_path('images/property_list/').$curentPhoto;
        }

        $property->update([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'code'    			=> $request->code
        ]);

        $success = trans('common.Updated Successfully');

        return redirect()->route('properties')->with('success', $success);
    }

    public function destroy($id)
    {
        $property = PropertyList::find($id);
        $property->delete();
        $success = trans('common.Deleted Successfully');
        return redirect()->route('properties')->with('success', $success);
    }
    public function blockCountry(Request $request)
    {
        $id = $request->id;
        $message = $request->status == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $property = PropertyList::find($id);
        $property->status = $request->status;
        $property->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
