<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Information;
use Illuminate\Http\Request;
use App\myInformation;
use Illuminate\Support\Facades\Validator;
Use Image;;
use Illuminate\Support\Facades\File;

class InformationController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         checkPermission('is_information');
    //         return $next($request);
    //     });
    // }

    public function edit()
    {
        checkGate('can_edit');

        $information = Information::first();

        return view('admin.information.edit', compact('information'));
    }

    public function update(Request $request)
    {
        $information = Information::first();
        if($information){
            // dd($request->all());
            $information->update($request->all());
        }else{
            Information::create($request->all());
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $information = myInformation::find($id);

        $information->delete();

        return response()->json(['success' => 'Deleted Successfully']);
    }

    public function blockinformation(Request $request)
    {
        $id = $request->id;
        $message = $request->status == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $information = myInformation::find($id);
        $information->status = $request->status;
        $information->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }

    public function backgroundinformation(Request $request)
    {
        $id = $request->id;
        $message = $request->background == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $information = myInformation::find($id);
        $information->background = $request->background;
        $information->save();

        $arr = array('background' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
