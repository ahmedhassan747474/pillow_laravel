<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reason;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class ReasonController extends Controller
{
    function __construct() 
    {
        $this->middleware(function ($request, $next) {
            checkPermission('is_reason');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $reason = Reason::whereStatus('1')->orderBy('id', 'desc');
        if (App::isLocale('ar')) {
            $reason->select('id', 'name_ar as name', 'status');
        } else {
            $reason->select('id', 'name_en as name', 'status');
        }
        $reasons = $reason->paginate(20);

        return view('admin.reason.index', compact('reasons'));
    }

    public function create()
    {
        checkGate('can_create');
        
        return view('admin.reason.create');
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
                        
        $reason = Reason::create([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
          	'status'			=> '1'
        ]);
        
        $success = trans('common.created Successfully');
        return redirect()->route('show_reason', $reason->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $data = Reason::whereId($id);
        if (App::isLocale('ar')) {
            $data->select('id', 'name_ar as name', 'status');
        } else {
            $data->select('id', 'name_en as name', 'status');
        }
        $reason = $data->first();

        return view('admin.reason.show', compact('reason'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $reason = Reason::find($id);
        
        return view('admin.reason.edit', compact('reason'));
    }

    public function update(Request $request, $id)
    {
        $reason = Reason::find($id);

        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $reason->update([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar
        ]);
        
        $success = trans('common.Updated Successfully');

        return redirect()->route('reasons')->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $reason = Reason::find($id);

        $reason->delete();

        return response()->json(['success' => 'Deleted Successfully']);
    }
    
    public function blockReason(Request $request)
    {
        $id = $request->id;
        $message = $request->status == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $reason = Reason::find($id);
        $reason->status = $request->status;
        $reason->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
