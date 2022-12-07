<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ResidentialType;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class ResidentialTypeController extends Controller
{
    function __construct() 
    {
        $this->middleware(function ($request, $next) {
            checkPermission('is_residential_type');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $type = ResidentialType::whereStatus('1')->orderBy('id', 'desc');
        if (App::isLocale('ar')) {
            $type->select('id', 'name_ar as name', 'status');
        } else {
            $type->select('id', 'name_en as name', 'status');
        }
        $types = $type->paginate(20);

        return view('admin.type.index', compact('types'));
    }

    public function create()
    {
        checkGate('can_create');
        
        return view('admin.type.create');
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
                        
        $type = ResidentialType::create([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
          	'status'			=> '1'
        ]);
        
        $success = trans('common.created Successfully');
        return redirect()->route('show_residential_type', $type->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $data = ResidentialType::whereId($id);
        if (App::isLocale('ar')) {
            $data->select('id', 'name_ar as name', 'status');
        } else {
            $data->select('id', 'name_en as name', 'status');
        }
        $type = $data->first();

        return view('admin.type.show', compact('type'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $type = ResidentialType::find($id);
        
        return view('admin.type.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $type = ResidentialType::find($id);

        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $type->update([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'type'              => '2'
        ]);
        
        $success = trans('common.Updated Successfully');

        return redirect()->route('residential_type')->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $type = ResidentialType::find($id);

        $type->delete();

        return response()->json(['success' => 'Deleted Successfully']);
    }
    
    public function blockResidentialType(Request $request)
    {
        $id = $request->id;
        $message = $request->status == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $type = ResidentialType::find($id);
        $type->status = $request->status;
        $type->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
