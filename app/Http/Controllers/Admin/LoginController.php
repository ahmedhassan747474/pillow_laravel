<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use App\Admin;
use Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\AdminLoginRequest;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Hash;
use Mail;
use DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Image;

class LoginController extends BaseController
{
    function __construct(Admin $model)
    {
        $this->model = $model;
        config(['auth.defaults.guard' => 'admin']);
    }

    public function login()
    {
        if (Auth::guard('admin')->check()){
            return redirect()->route('dashboard');
        } else {
            return view('admin.auth.login');
        }
    }

    public function checkLogin(AdminLoginRequest $request)
    {
        $credentials = array('email' => $request->email, 'password' => $request->password);

        $remember_me = $request->has('remember') ? true : false;

        if (Auth::guard('admin')->attempt($credentials, $remember_me)) {
            return redirect()->route('dashboard');
        } else {
            return view('admin.auth.login');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('admin_login');
    }

    public function forgetPassword()
    {
        return view('admin.auth.forget_password');
    }

    public function forgetPasswordCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' =>'required|email|exists:admins,email',
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            $arr = array('status' => 'fail', 'data' => $error);
            return response()->json($arr);
        }

        $user = Admin::whereEmail($request->email)->first();
        $generateToken = bcrypt(Str::random(32));
        $now = Carbon::now()->toDateTimeString();
        $token = DB::table('password_resets_admin')
        ->updateOrInsert(
            ['email' => $user->email],
            ['token' => $generateToken, 'created_at' => $now]
        );

        $name = isset($user->name) ? $user->name : '';
        $from = 'info@zawidha.com';
        $subject = config('app.name') . ' Password Reset Link';
        $to_email = strtolower($user->email);
        $data = array('token' => $generateToken, 'email' => $user->email, 'id' => md5($user->id), 'name' => $name);

        Mail::send('email.admin_forget_password', $data, function($message) use ($to_email, $subject, $from) {
            $message->to($to_email)->subject($subject);
            $message->from($from, config('app.name'));
        });

        $arr = array('status' => 'success', 'data' => $user, 'link' => route('dashboard'));
        return response()->json($arr);
    }

    public function resetPassword()
    {
        $email = request()->get('email');
        $uid = request()->get('uid');
        $token = request()->get('token');
        // dd($email, $uid, $token);
        $message = 'انتهت صلاحية الرابط';

        $existing_email = DB::table('password_resets_admin')->where('email', $email)->first();

        if($existing_email)
        {
            $created_at  = new Carbon($existing_email->created_at);
            $current    = Carbon::now();
            $diff_hours = $created_at->diff($current)->format('%H');
            // dd($token == $existing_email->token);
            if((int)$diff_hours < 1)
            {
                if($token == $existing_email->token)
                {
                    return view('admin.auth.reset_password', compact('email', 'uid'));
                }
                else
                {
                    return view('admin.auth.link_expired', compact('message'));
                }
            }
            else
            {
                DB::table('password_resets_admin')->where('email', $email)->delete();
                return view('admin.auth.link_expired', compact('message'));
            }
        }
        else
        {
            return view('admin.auth.link_expired', compact('message'));
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8'
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            $arr = array('status' => 'fail', 'data' => $error);
            return response()->json($arr);
        }

        $existing_email = DB::table('password_resets_admin')->where('email', $request->email)->first();

        if($existing_email)
        {
            $user = Admin::where('email', $request->email)->whereRaw('md5(id) = "'.$request->uid.'"')->first();
            $user->password = bcrypt($request->password);
            $user->save();

            DB::table('password_resets_admin')->where('email', $request->email)->delete();
            $message = 'لقد تم التعديل بنجاح ويمكنك الان الدخول بالكلمه المرور الجديده';

            $arr = array('status' => 'success', 'data' => [], 'link' => route('dashboard'));
            return response()->json($arr);
        }
        else
        {
            $message = 'انتهت صلاحية الرابط';
            return view('admin.auth.link_expired', compact('message'));
        }
    }

    //Edit Profile

    public function edit()
    {
        $admin = Auth::guard('admin')->user();

        return view('admin.auth.profile', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $validator = Validator::make($request->all(), [
            'name'              => 'required|string',
            'image'             => 'nullable|image',
            'email'             => 'required|email|unique:admins,email,'. $admin->id,
            'current_password'  => 'required_with:password',
            'password'          => 'required_with:current_password|confirmed'
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

        $admin->update(['name' => $request->name, 'email' => $request->email]);

        if ($request->password) {
            if(Hash::check($request->current_password, $admin->password)){
                $admin->update(['password' => bcrypt($request->password)]);
            } else {
                $error = 'كلمة المرور الحالية غير صحيحة';
                return redirect()->back()->withInput($request->all())->with('error', $error);
            }
        }

        $message = 'تم التعديل بنجاح';

        return redirect()->route('edit_admin_profile')->with('message', $message);
    }
}
