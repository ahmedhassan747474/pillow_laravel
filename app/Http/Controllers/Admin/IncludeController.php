<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\IncludeList;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class IncludeController extends BaseController
{
    function __construct() 
    {
        $this->middleware(function ($request, $next) {
            checkPermission('is_include');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $include = IncludeList::whereStatus('1')->orderBy('id', 'desc');
        if (App::isLocale('ar')) {
            $include->select('id', 'name_ar as name', 'status');
        } else {
            $include->select('id', 'name_en as name', 'status');
        }
        $includes = $include->paginate(20);

        return view('admin.include.index', compact('includes'));
    }

    public function create()
    {
        checkGate('can_create');
        
        return view('admin.include.create');
    }

    public function store(Request $request)
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
                        
        $include = IncludeList::create([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'type'              => '2',
          	'status'			=> '1'
        ]);
        
        $success = trans('common.created Successfully');
        return redirect()->route('show_include', $include->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $data = IncludeList::whereId($id);
        if (App::isLocale('ar')) {
            $data->select('id', 'name_ar as name', 'status');
        } else {
            $data->select('id', 'name_en as name', 'status');
        }
        $include = $data->first();

        return view('admin.include.show', compact('include'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $include = IncludeList::find($id);
        
        return view('admin.include.edit', compact('include'));
    }

    public function update(Request $request, $id)
    {
        $include = IncludeList::find($id);

        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $include->update([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'type'              => '2'
        ]);
        
        $success = trans('common.Updated Successfully');

        return redirect()->route('includes')->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $include = IncludeList::find($id);

        $include->delete();

        return response()->json(['success' => 'Deleted Successfully']);
    }
    
    public function blockInclude(Request $request)
    {
        $id = $request->id;
        //$message = $request->type == 'block' ? 'تم الغاء التفعيل المستخدم بنجاح' : 'تم تفعيل المستخدم بنجاح';
        $message = $request->status == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $include = IncludeList::find($id);
        $include->status = $request->status;
        $include->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
