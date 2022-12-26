<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Admin;
use Image;
use Illuminate\Support\Str;
use App\Permission;
use App\AdminPermission;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class AdministrationController extends BaseController
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            checkPermission('is_admin');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $admin = auth()->guard('admin')->user();

        if($admin->type == '1')
        {
            $admins = Admin::where('id', '!=', 1)->with('adminPermission.permission')->paginate(20);
        } else {
            $admins = Admin::where('id', '!=', 1)->whereParentId($admin->id)->with('adminPermission.permission')->paginate(20);
        }

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        checkGate('can_create');

        $permissions = Permission::all();

        return view('admin.admins.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|max:50|string',
            'image'         => 'required|image',
            'email'         => 'required|email|unique:admins,email',
            'password'      => 'nullable|confirmed|min:8',
            'permission'    => 'required'
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $image          = $request->image;
        $extension      = $image->getClientOriginalExtension();
        $imageRename    = time(). uniqid() . '.'.$extension;

        $path           = public_path("images\admins");

        if(!File::exists($path)) File::makeDirectory($path, 775, true);

        $img = Image::make($image)->resize(400, 400, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save('images/admins/'.$imageRename);

        $admin = Admin::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => bcrypt($request->password),
            'image'         => $imageRename,
            'type'          => '2',
            'parent_id'     => auth()->guard('admin')->user()->id
        ]);

        $permission = AdminPermission::create([
            'admin_id'          => $admin->id,
            'permission_id'     => $request->permission,
            'can_create'        => $request->can_create == 'on' ? 1 : 0,
            'can_edit'          => $request->can_edit == 'on' ? 1 : 0,
            'can_show'          => $request->can_show == 'on' ? 1 : 0,
            'can_delete'        => $request->can_delete == 'on' ? 1 : 0
        ]);

        $success = trans('common.created Successfully');
        return redirect()->route('show_admin', $admin->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $admin = Admin::find($id);

        $permission = AdminPermission::where('admin_id', $id)->first();

        return view('admin.admins.show', compact('admin', 'permission'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $admin = Admin::find($id);

        $permissions = Permission::all();

        return view('admin.admins.edit',  compact('admin', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        $validator = Validator::make($request->all(), [
            'name'          => 'required|max:50|string',
            'image'         => 'nullable|image',
            'email'         => 'required|email|unique:admins,email,'.$id.',id',
            'password'      => 'nullable|confirmed|min:8',
            'permission'    => 'required'
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        if($request->has('image')){
            $curentPhoto    = $admin->image;
            $image          = $request->image;
            $extension      = $image->getClientOriginalExtension();
            $imageRename    = time(). uniqid() . '.'.$extension;

            $path           = public_path("images\admins");

            if(!File::exists($path)) File::makeDirectory($path, 775, true);

            $img = Image::make($image)->resize(null, 700, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save('images/admins/'.$imageRename);

            $upload_image   = $admin->update(['image' => $imageRename]);

            $userPhoto      = public_path('images/admins/').$curentPhoto;

            if(file_exists($userPhoto) && $curentPhoto != 'user_default.png'){
                @unlink($userPhoto);
            }
        }

        if ($request->password) {
            $admin->update(['password' => bcrypt($request->password)]);
        }

        $admin = Admin::whereId($id)->update([
            'name'          => $request->name,
            'email'         => $request->email
        ]);

        $permission = AdminPermission::whereAdminId($id)->update([
            'permission_id'     => $request->permission,
            'can_create'        => $request->can_create == 'on' ? 1 : 0,
            'can_edit'          => $request->can_edit == 'on' ? 1 : 0,
            'can_show'          => $request->can_show == 'on' ? 1 : 0,
            'can_delete'        => $request->can_delete == 'on' ? 1 : 0
        ]);

        // return redirect()->route('admins');
        return redirect()->route('show_admin', $id);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $admin = Admin::find($id);

        $admin->delete();

        return response()->json(['success' => 'Deleted Successfully']);
    }

    public function blockAdmin(Request $request)
    {
        $id = $request->admin_id;
        $message = $request->status == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $admin = Admin::find($id);
        $admin->status = $request->status;
        $admin->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
