<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Attribute;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class AttributeController extends BaseController
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            checkPermission('is_attributes');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $attribute = Attribute::whereStatus('1')->orderBy('id', 'desc');
        if (App::isLocale('ar')) {
            $attribute->select('id', 'name_ar as name', 'image', 'status');
        } else {
            $attribute->select('id', 'name_en as name', 'image', 'status');
        }
        $attributes = $attribute->paginate(20);

        return view('admin.attribute.index', compact('attributes'));
    }

    public function create()
    {
        checkGate('can_create');

        return view('admin.attribute.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string',
            // 'value_en'    		=> 'required|string',
            // 'value_ar'    		=> 'required|string',
            // 'image'         	=> 'required'
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        if($request->has('image')){
    		$image 			= $request->image;
    		$extension      = $image->getClientOriginalExtension();
            $imageRename    = time(). uniqid() . '.'.$extension;

            $path           = public_path("images\attributes");

            if(!File::exists($path)) File::makeDirectory($path, 775, true);

            $img = Image::make($image)->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save('images/attributes/'.$imageRename);
        }

        $attribute = Attribute::create([
            // 'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            // 'value_en'    		=> $request->value_en,
            // 'value_ar'    		=> $request->value_ar,
          	// 'image'				=> $imageRename,
          	'status'			=> '1'
        ]);

        $success = trans('common.created Successfully');
        return redirect()->route('show_attribute', $attribute->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $data = Attribute::whereId($id);
        if (App::isLocale('ar')) {
            $data->select('id', 'name_ar as name', 'image');
        } else {
            $data->select('id', 'name_en as name', 'image');
        }
        $attribute = $data->first();

        return view('admin.attribute.show', compact('attribute'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $attribute = Attribute::find($id);

        return view('admin.attribute.edit', compact('attribute'));
    }

    public function update(Request $request, $id)
    {
        $attribute = Attribute::find($id);

        $validator = Validator::make($request->all(), [
            // 'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string',
            // 'value_en'    		=> 'required|string',
            // 'value_ar'    		=> 'required|string',
            'image'         	=> 'nullable'
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        if($request->has('image')){
            $curentPhoto    = $attribute->image;
            $image          = $request->image;
            $extension      = $image->getClientOriginalExtension();
            $imageRename    = time(). uniqid() . '.'.$extension;

            $path           = public_path("images\attributes");

            if(!File::exists($path)) File::makeDirectory($path, 775, true);

            $img = Image::make($image)->resize(null, 700, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save('images/attributes/'.$imageRename);

            $upload_image   = Attribute::where('id', $attribute->id)->update(['image' => $imageRename]);

            $userPhoto      = public_path('images/attributes/').$curentPhoto;
        }

        $attribute->update([
            // 'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            // 'value_en'    		=> $request->value_en,
            // 'value_ar'    		=> $request->value_ar
        ]);

        $success = trans('common.Updated Successfully');

        // return redirect()->route('show_attribute', $attribute->id)->with('success', $success);
        return redirect()->route('attributes')->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $attribute = Attribute::find($id);

        $attribute->delete();

        return response()->json(['success' => 'Deleted Successfully']);
    }

    public function blockAttribute(Request $request)
    {
        $id = $request->id;
        //$message = $request->type == 'block' ? 'تم الغاء التفعيل المستخدم بنجاح' : 'تم تفعيل المستخدم بنجاح';
        $message = $request->status == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $property = Attribute::find($id);
        $property->status = $request->status;
        $property->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
