<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Through;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class ThroughController extends BaseController
{
    function __construct() 
    {
        $this->middleware(function ($request, $next) {
            checkPermission('is_through');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $through = Through::whereStatus('1')->orderBy('id', 'desc');
        if (App::isLocale('ar')) {
            $through->select('id', 'name_ar as name', 'type', 'status');
        } else {
            $through->select('id', 'name_en as name', 'type', 'status');
        }
        $throughs = $through->paginate(20);

        return view('admin.through.index', compact('throughs'));
    }

    public function create()
    {
        checkGate('can_create');
        
        return view('admin.through.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string',
            'type'              => 'required|in:1,2'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }
                        
        $through = Through::create([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'type'              => $request->type,
          	'status'			=> '1'
        ]);
        
        $success = trans('common.created Successfully');
        return redirect()->route('show_through', $through->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $data = Through::whereId($id);
        if (App::isLocale('ar')) {
            $data->select('id', 'name_ar as name', 'type', 'status');
        } else {
            $data->select('id', 'name_en as name', 'type', 'status');
        }
        $through = $data->first();

        return view('admin.through.show', compact('through'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $through = Through::find($id);
        
        return view('admin.through.edit', compact('through'));
    }

    public function update(Request $request, $id)
    {
        $through = Through::find($id);

        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string',
            'type'              => 'required|in:1,2'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $through->update([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'type'              => $request->type
        ]);
        
        $success = trans('common.Updated Successfully');

        return redirect()->route('throughs')->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $through = Through::find($id);

        $through->delete();

        return response()->json(['success' => 'Deleted Successfully']);
    }
    
    public function blockThrough(Request $request)
    {
        $id = $request->id;
        //$message = $request->type == 'block' ? 'تم الغاء التفعيل المستخدم بنجاح' : 'تم تفعيل المستخدم بنجاح';
        $message = $request->status == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $through = Through::find($id);
        $through->status = $request->status;
        $through->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
