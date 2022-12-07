<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coupon;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class CouponController extends Controller
{
    function __construct() 
    {
        $this->middleware(function ($request, $next) {
            checkPermission('is_coupon');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $coupons = Coupon::whereStatus('1')->orderBy('id', 'desc')->select('id', 'name', 'discount', 'type', 'status')->paginate(20);

        return view('admin.coupon.index', compact('coupons'));
    }

    public function create()
    {
        checkGate('can_create');
        
        return view('admin.coupon.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       		=> 'required|string',
            'discount'       	=> 'required|integer',
            'type'         		=> 'required|in:percent,price'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }
                        
        $coupon = Coupon::create([
            'name'       		=> $request->name,
            'discount'       	=> $request->discount,
          	'type'       		=> $request->type,
          	'status'			=> '1'
        ]);
        
        $success = trans('common.created Successfully');
        return redirect()->route('show_coupon', $coupon->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

    	$coupon = Coupon::find($id);

        return view('admin.coupon.show', compact('coupon'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $coupon = Coupon::find($id);
        
        return view('admin.coupon.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);

        $validator = Validator::make($request->all(), [
            'name'       		=> 'required|string',
            'discount'       	=> 'required|integer',
            'type'         		=> 'required|in:percent,price'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $coupon->update([
            'name'       		=> $request->name,
            'discount'       	=> $request->discount,
          	'type'       		=> $request->type,
        ]);
        
        $success = trans('common.Updated Successfully');

        return redirect()->route('coupons')->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $coupon = Coupon::find($id);

        $coupon->delete();

        return response()->json(['success' => 'Deleted Successfully']);
    }
    
    public function blockCity(Request $request)
    {
        $id = $request->id;
        $message = $request->status == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $coupon = Coupon::find($id);
        $coupon->status = $request->status;
        $coupon->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
