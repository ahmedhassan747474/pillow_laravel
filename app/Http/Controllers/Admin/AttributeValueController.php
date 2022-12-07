<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Attribute;
use App\AttributeValue;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class AttributeValueController extends BaseController
{
    function __construct() 
    {
        $this->middleware(function ($request, $next) {
            checkPermission('is_attributes');
            return $next($request);
        });
    }

    public function index($id)
    {
        checkGate('can_show');

        $attribute = AttributeValue::whereAttributeId($id)->whereStatus('1')->orderBy('id', 'desc');
        if (App::isLocale('ar')) {
            $attribute->select('id', 'name_ar as name', 'status');
        } else {
            $attribute->select('id', 'name_en as name', 'status');
        }
        $attributes = $attribute->paginate(20);

        return view('admin.attribute_value.index', compact('attributes', 'id'));
    }

    public function create($id)
    {
        checkGate('can_create');
        
        return view('admin.attribute_value.create', compact('id'));
    }

    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }
                        
        $attribute = AttributeValue::create([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
          	'attribute_id'		=> $id,
          	'status'			=> '1'
        ]);
        
        $success = trans('common.created Successfully');
        // return redirect()->route('show_attribute_value', $attribute->id)->with('success', $success);
        return redirect()->route('attribute_value', $id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $data = AttributeValue::whereId($id);
        if (App::isLocale('ar')) {
            $data->select('id', 'name_ar as name');
        } else {
            $data->select('id', 'name_en as name');
        }
        $attribute = $data->first();

        return view('admin.attribute_value.show', compact('attribute'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $attribute = AttributeValue::find($id);
        
        return view('admin.attribute_value.edit', compact('attribute'));
    }

    public function update(Request $request, $id)
    {
        $attribute = AttributeValue::find($id);

        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $attribute->update([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar
        ]);
        
        $success = trans('common.Updated Successfully');

        return redirect()->route('attribute_value', $attribute->attribute_id)->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $attribute = AttributeValue::find($id);

        $attribute->delete();

        return response()->json(['success' => 'Deleted Successfully']);
    }
    
    public function blockAttributeValue(Request $request)
    {
        $id = $request->id;
        //$message = $request->type == 'block' ? 'تم الغاء التفعيل المستخدم بنجاح' : 'تم تفعيل المستخدم بنجاح';
        $message = $request->status == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $property = AttributeValue::find($id);
        $property->status = $request->status;
        $property->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
