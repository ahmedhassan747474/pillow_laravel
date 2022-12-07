<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\BaseController;
use App\Transformers\Api\V1\UserTransformer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use App\User;
use App\OtpCode;
use App\Setting;
use App\Ride;
use JWTAuth;
use Hash;
use Auth;
use Mail;
Use Image;
use Str;
use App;
use Illuminate\Support\Facades\File;

class UserController extends BaseController
{
    function __construct(UserTransformer $user_transformer)
    {
        config(['auth.defaults.guard' => 'api']);
        $this->user_transformer = $user_transformer;
        App::setLocale(request()->header('Accept-Language'));
    }

    public function registration(Request $request)
    {
        // $request['phone_code'] = convert($request->phone_code);
        $request['phone_code'] = convert(+20);
        $request['phone_number'] = convert($request->phone_number);

        $messages = [
            'phone_number.regex'    => trans('common.phone must contain only numbers'),
            'email.regex'           => trans('common.enter your email like example@gmail.xyz'),
            'email.unique'          => trans('common.email_already_exist'),
        ];

        $validator = Validator::make($request->all(), [
            'name'              => 'required|max:50',
            'country_id'              => 'required|numeric',
            'city_id'              => 'required|numeric',
            'email'             => 'required|email|max:120|unique:users,email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'phone_code'        => 'required',
            'phone_number'      => 'required|unique:users,phone_number|regex:/[0-9]/u',
            'password'          => 'required|confirmed',
            'user_type'         => 'required|in:1,2'
        ], $messages);

        if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

        $code = 4444;

        $type = '2';

        $request['password'] = bcrypt($request->password);
        $request['status'] = '1';

        $user = User::create($request->all());

        if($user)
        {
            $rideSource = Ride::create([
                'name'                  =>  $request->name,
                'phone_code'            =>  $request->phone_code,
                'phone_number'          =>  $request->phone_number,
                'user_id'               =>  $user->id
            ]);

            $sent_code = $this->otpCode($user, $type, $code);
            $token = auth()->login($user);
            return $this->respond([
                'message'       =>  trans('common.success_registeration'),
                'data'          =>  $this->user_transformer->transform($user),
                'token'         =>  $token,
                'status_code'   =>  200
            ], 200);
        }
        else
        {
            return response()->json(['message' => trans('common.not_saved'), 'status_code' => 400], 400);
        }
    }

    public function login(Request $request)
    {
        // $request['phone_code'] = convert($request->phone_code);
        // $request['phone_number'] = convert($request->phone_number);

        $messages = [
            'email.regex'           => trans('common.enter your email like example@gmail.xyz'),
            'phone_number.regex'    => trans('common.phone must contain only numbers'),
        ];

        $validator = Validator::make($request->all(), [
            'email'         => 'required|email|max:120|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            // 'phone_code'        => 'required',
            // 'phone_number'      => 'required|regex:/[0-9]/u',
            'password'          => 'required',
            'token'             => 'nullable',
            // 'user_type'         => 'required|in:1,2'
        ], $messages);

        if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

        // $credentials = $request->only('email', 'password','user_type');
        $credentials = $request->only('email', 'password');

        if ($token = auth('api')->attempt($credentials))
        {
            $user_data = auth('api')->user();

            if($user_data->status == '0')
            {
                return response()->json(['message' => trans('common.suspend_account'), 'status_code' => 400], 400);
            }

            // if($user_data->phone_verified == '0')
            // {
            //     $code = 4444;

            //     $type = '1';

            //     $sent_code = $this->otpCode($user_data, $type, $code);

            //     return response()->json([
            //         'message'       => trans('common.you_number_phone_is_not_verified'),
            //         'is_verified'   => 0,
            //         'type'          => 1,
            //         'token'         => $token,
            //         'status_code'   => 400
            //     ], 400);
            // }

            $user_data->token = $request->token;
            $user_data->save();

            return response()->json([
                'token'         => $token,
                'data'          => $this->user_transformer->transform($user_data),
                'status_code'   => 200
            ], 200);
        }
        else
        {
            return response()->json(['message' => trans('common.invalid_credentials'), 'status_code' => 400], 400);
        }
    }

    public function loginWithSocial(Request $request)
    {
        $messages = [
            'email.regex'           => trans('common.enter your email like example@gmail.xyz'),
        ];

        $validator = validator()->make($request->all(), [
            'name'          => 'required|max:50|string',
            'email'         => 'required|max:120|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'image'         => 'required',
            'provider_id'   => 'required',
            'provider_type' => 'required|in:facebook,google,twitter',
            'token'         => 'nullable'
        ], $messages);

        if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

        $checkAccount = User::where('provider_facebook_id', '=', $request->provider_id)
            ->orWhere('provider_google_id', '=', $request->provider_id)
            ->orWhere('provider_twitter_id', '=', $request->provider_id)
            ->count();

        if ($checkAccount == 0) {

            $checkEmail = User::where('email', '=', $request->email)->count();

            if($checkEmail == 0) {

                $newData = file_get_contents($request->image);
                $dir = "images/users";
                $uploadfile = $dir . "/pic_" .time() . uniqid() .".jpg";
                file_put_contents(public_path() . '/' . $uploadfile, $newData);
                $profile_photo = $uploadfile;

                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->image = $profile_photo;
                $user->token = $request->token;

                if ($request->provider_type == 'facebook') {
                    $user->provider_facebook_id = $request->provider_id;
                } elseif($request->provider_type == 'google') {
                    $user->provider_google_id = $request->provider_id;
                } else {
                    $user->provider_twitter_id = $request->provider_id;
                }

                $user->save();

                $token = JWTAuth::fromUser($user);

                return $this->respond([
                    'message'       => trans('common.success_registeration'),
                    'data'          => $this->user_transformer->transform($user),
                    'token'         =>  $token,
                    'status_code'   => 200
                ], 200);

            } else {

                if ($request->provider_type == 'facebook') {
                    User::where('email', '=', $request->email)
                        ->update([
                            'token'                 => $request->token,
                            'provider_facebook_id'  => $request->provider_id,
                        ]);
                } elseif ($request->provider_type == 'google') {
                    User::where('email', '=', $request->email)
                        ->update([
                            'token'                 => $request->token,
                            'provider_google_id'    => $request->provider_id,
                        ]);
                } else {
                    User::where('email', '=', $request->email)
                        ->update([
                            'token'                 => $request->token,
                            'provider_twitter_id'   => $request->provider_id,
                        ]);
                }

                $user = User::where('email', '=', $request->email)->first();

                $token = JWTAuth::fromUser($user);

                return $this->respond([
                    'message'       => trans('common.success_registeration'),
                    'data'          => $this->user_transformer->transform($user),
                    'token'         =>  $token,
                    'status_code'   => 200
                ], 200);
            }

        } else {

            if ($request->provider_type == 'facebook') {
                User::where('provider_facebook_id', '=', $request->provider_id)->update(['token' => $request->token]);
            } elseif ($request->provider_type == 'google') {
                User::where('provider_google_id', '=', $request->provider_id)->update(['token' => $request->token]);
            } else {
                User::where('provider_twitter_id', '=', $request->provider_id)->update(['token' => $request->token]);
            }

            $user = User::where('email', '=', $request->email)->first();

            $token = JWTAuth::fromUser($user);

            return $this->respond([
                'message'       => trans('common.success_registeration'),
                'data'          => $this->user_transformer->transform($user),
                'token'         =>  $token,
                'status_code'   => 200
            ], 200);

        }
        return response()->json($response);
    }

    public function forgetPassword(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if($user)                //$request->header('Authorization')=== Already login user
        {
            $token = Password::getRepository()->create($user);

            Mail::send(['html' => 'email.forget_password'], ['token' => $token, 'email' => $user->email], function (Message $message) use ($user) {
                $message->subject(config('app.name') . ' Password Reset Link');
                $message->to($user->email);
            });

            return response()->json(['message' => trans('common.mail_is_sent'), 'status_code' => 200], 200);


        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }

    }

    public function forgetPassword_old(Request $request)
    {
        if($request->header('Authorization'))   //=== Already login user
        {
            $user = $this->getAuthenticatedUser();

            // $token = $request->bearerToken();

            // $code = rand(1111, 9999);
            $code = 4444;

            if($user)
            {
                if($request->type == 1) {
                    $type = '4';
                    $sent_code = $this->otpCode($user, $type, $code);

                    return response()->json([
                        'message'           => trans('common.success_send_code'),
                        'data'              => ['verification_code' => (int)$sent_code->verification_code, 'code_type' => $sent_code->code_type],
                        'status_code'       => 200
                    ], 200);
                } else {

                    if($user->email == null)
                    {
                        return response()->json(['message' => trans('common.no_email_for_account'), 'status_code' => 400], 400);
                    }
                    elseif($user->email != null && $user->email_activate == '0')
                    {
                        return response()->json(['message' => trans('common.email_not_verified'), 'status_code' => 400], 400);
                    }
                    else
                    {
                        $token = Password::getRepository()->create($user);

                        Mail::send(['html' => 'email.forget_password'], ['token' => $token, 'email' => $user->email], function (Message $message) use ($user) {
                            $message->subject(config('app.name') . ' Password Reset Link');
                            $message->to($user->email);
                        });

                        return response()->json(['message' => trans('common.mail_is_sent'), 'status_code' => 200], 200);

                        // $token = Password::getRepository()->create($user);

                        // $from       = Setting::where('name', 'send_email')->pluck('value')->first();
                        // $subject    = config('app.name') . ' Password Reset Link';
                        // $to_email   = strtolower($user->email);
                        // $data       = array('token' => $token, 'email' => $user->email, 'id' => md5($user->id));

                        // Mail::send('email.forget_password', $data, function($message) use ($to_email, $subject, $from) {
                        //     $message->to($to_email)->subject($subject);
                        //     $message->from($from, config('app.name'));
                        // });

                        // $encrypted_email = $this->hideEmailAddress($user->email);

                        // return response()->json([
                        //     'message'       => trans('common.mail_is_sent_encrypt', ['value' => $encrypted_email]),
                        //     'status_code'   => 200
                        // ], 200);
                    }
                }

            }
            else
            {
                return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
            }
        }
        else
        {
            return response()->json(['message' => trans('common.invalid_data'), 'status_code' => 400], 400);
        }
    }

    public function changePassword(Request $request)
    {
        $user = $this->getAuthenticatedUser();

        if($user)
        {
            $request['verification_code'] = convert($request->verification_code);
            $request['old_password'] = convert($request->old_password);
            $request['new_password'] = convert($request->new_password);

            $validator = Validator::make($request->all(), [
                'verification_code'     => 'required_without:old_password',
                'old_password'          => 'required_without:verification_code',
                'new_password'          => 'required|min:8|confirmed',
            ]);

            if($validator->fails())
            {
                return $this->getErrorMessage($validator);
            }

            if($request->filled('verification_code'))
            {
                $existing_code = OtpCode::where([['verification_code', $request->verification_code], ['user_id', $user->id]])->first();

                if($existing_code)
                {
                    $existing_code->status = '1';
                    $existing_code->save();
                }
                else
                {
                    return response()->json(['message' => trans('common.invalid_code'), 'status_code' => 400], 400);
                }
            }
            else if($request->filled('old_password'))
            {
                if(!Hash::check($request->old_password, $user->password))
                {
                    return response()->json(['message' => trans('common.current_password_not_correct'), 'status_code' => 400], 400);
                }
            }

            $user->password = bcrypt($request->new_password);
            $user->save();

            return response()->json(['message' => trans('common.success_update'), 'status_code' => 200], 200);
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = $this->getAuthenticatedUser();

        $token = $request->bearerToken();

        if($user)
        {
            // $request['phone_code'] = convert($request->phone_code);
            $request['phone_number'] = convert($request->phone_number);

            $messages = [
                'phone_number.exists'   => trans('common.phone_not_identical_to_registered'),
                'phone_number.regex'    => trans('common.phone must contain only numbers'),
                'email.regex'           => trans('common.enter your email like example@gmail.xyz'),
                'email.unique'          => trans('common.email_already_exist'),
            ];

            $validator = Validator::make($request->all(), [
                'name'              => 'required|max:50|string',
                'email'             => 'required|email|max:120|unique:users,email,'.$user->id.',id|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                'phone_code'        => 'nullable',
                'phone_number'      => 'nullable|unique:users,phone_number,'.$user->id.',id|regex:/[0-9]/u',
                'surename'          => 'nullable|max:50|string',
                'image'             => 'nullable|image',
                'city'              => 'nullable',
                'password'          => 'required',
                'user_type'         => 'required|in:1,2'
            ], $messages);

            if($validator->fails())
            {
                return $this->getErrorMessage($validator);
            }

            if($request->has('image')){
                $curentPhoto    = $user->image;
                $image          = $request->image;
                $extension      = $image->getClientOriginalExtension();
                $imageRename    = time(). uniqid() . '.'.$extension;

                $path           = public_path("images\users");

                if(!File::exists($path)) File::makeDirectory($path, 775, true);

                $img = Image::make($image)->resize(null, 700, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(public_path('images/users/').$imageRename);

                $upload_image   = User::where('id', $user->id)->update(['image' => $imageRename]);

                $upload_image_source   = Ride::where('user_id', $user->id)->update(['image' => $imageRename]);

                $userPhoto      = public_path('images/users/').$curentPhoto;

                if(file_exists($userPhoto) && $curentPhoto != 'user_default.png'){
                    @unlink($userPhoto);
                }
            }

            if($request->phone != $user->phone) {
                // $user->change_phone_code = $request->phone_code;
                $user->change_phone_number = $request->phone_number;
                $user->save();

                $code = 4444;
                $type = '3';
                $sent_code = $this->otpCode($user, $type, $code);
            }

            $update_data = User::where('id', $user->id)->update([
                'name'      => $request->name,
                'email'     => $request->email,
                'phone_number'     => $request->phone_number,
                'city_id'     => $request->city_id,
                'country_id'     => $request->country_id,
                'user_type'     => $request->user_type,
                'password'     => bcrypt($request->password),
                // 'surename'  => $request->surename
            ]);
            // dd($update_data);
            $user = User::find($user->id);

            if($user)
            {
                $update_ride_source = Ride::where('user_id', $user->id)->update([
                    'name'                  =>  $request->name,
                    // 'phone_code'            =>  $request->phone_code,
                    // 'phone_number'          =>  $request->phone_number
                ]);

                return response()->json([
                    'message'       => trans('common.success_update'),
                    'data'          => $this->user_transformer->transform($user),
                    'token'         => $token,
                    'status_code'   => 200
                ], 200);
            }
            else
            {
                return response()->json(['message' => trans('common.not_saved'), 'status_code' => 400], 400);
            }
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 400], 400);
        }
    }

    public function getProfile()
    {
        $user = $this->getAuthenticatedUser();

        if($user)
        {
            return response()->json(['data' => $this->user_transformer->transform($user), 'status_code' => 200], 200);
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

    public function logout()
    {
        $user = $this->getAuthenticatedUser();

        if($user)
        {
            $user->token = null;
            $user->save();

            auth()->logout();
            return response()->json(['message' => trans('common.success_logout'), 'status_code' => 200]);
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

    public function sendActiveEmail(Request $request)
    {
        $user = $this->getAuthenticatedUser();

        if($user)
        {
            if($user->email_activate == '0' && $user->email != null)
            {
                $this->activateEmail($user, 'exist');

                return response()->json(['message' => trans('common.mail_is_sent'), 'status_code' => 200], 200);
            }
            elseif($user->email_activate == '1' && $user->email != null && $user->change_email != null)
            {
                $this->activateEmail($user, 'change');

                return response()->json(['message' => trans('common.mail_is_sent'), 'status_code' => 200], 200);
            }
            else
            {
                return response()->json(['message' => trans('common.enter_your_email'), 'status_code' => 400], 400);
            }
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

    public function verifyPhoneNumber(Request $request)
    {
        $request['verification_code'] = convert($request->verification_code);
        $request['password'] = convert($request->password);

        $validator = Validator::make($request->all(), [
            'verification_code'     => 'required',
            'password'              => 'required_unless:type,==,1',
            'type'                  => 'required|in:1,2'
        ]);

        if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

        $user = $this->getAuthenticatedUser();

        $token = $request->bearerToken();

        if ($user)
        {
            if($request->type == 2) {
                if(!Hash::check($request->password, $user->password)) {
                    return response()->json(['message' => trans('common.password_invalid'), 'status_code' => 400], 400);
                }
            }

            $existing_code = OtpCode::where([['verification_code', $request->verification_code], ['status', '0'], ['user_id', $user->id]])->first();

            if(!$existing_code)
            {
                return response()->json(['message' => trans('common.invalid_code'), 'status_code' => 400], 400);
            }
            else
            {
                $existing_code->status = '1';
                $existing_code->save();

                if($request->type == 2) {
                    if($existing_code->code_type == '3')   //=== change phone number
                    {
                        $user->phone_code = $user->change_phone_code;
                        $user->phone_number = $user->change_phone_number;
                        $user->change_phone_code = null;
                        $user->change_phone_number = null;
                        $user->phone_verified = '1';
                        $user->save();

                        $update_ride_source = Ride::where('user_id', $user->id)->update([
                            'phone_code'            =>  $user->phone_code,
                            'phone_number'          =>  $user->phone_number
                        ]);
                    }
                } else {
                    if($existing_code->code_type == '1' || $existing_code->code_type == '2')   //=== New User Or Exist User
                    {
                        $user->phone_verified = '1';
                        $user->save();
                    }
                }

                $user['token'] = $token;

                return response()->json([
                    'message'               => trans('common.success_active'),
                    'data'                  => $this->user_transformer->transform($user),
                    'token'                 => $token,
                    'status_code'           => 200
                ], 200);
            }
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

    public function resendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code_type' => 'required|in:1,2,3,4'
        ]);

        if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

        $user = $this->getAuthenticatedUser();

        $token = $request->bearerToken();

        if ($user)
        {
            $sent_code = OtpCode::where([['user_id', $user->id], ['status', '0'], ['code_type', $request->code_type]])->first();

            if($sent_code) {
                return response()->json([
                    'message'           => trans('common.success_send_code'),
                    'data'              => ['verification_code' => (int)$sent_code->verification_code, 'code_type' => $sent_code->code_type],
                    'status_code'       => 200
                ], 200);
            } else {
                return response()->json(['message' => trans('common.invalid_data'), 'status_code' => 400], 400);
            }
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

    public function otpCode($user, $type, $code)
    {
        $insertOrUpdateOtpCode = OtpCode::updateOrCreate([
            'user_id'           => $user->id
        ], [
            'code_type'         => $type,
            'verification_code' => $code,
            'status'            => '0'
        ]);

        $insertOrUpdateOtpCode->save();
        // $this->sendSMS($user->phone_number, $code);
        return $insertOrUpdateOtpCode;
    }

    public function activateEmail($user, $type)
    {

        $email = $type == 'exist' ? $user->email : $user->change_email;

        $active_email_token = Str::random(32);
        $user->active_email_token = $active_email_token;
        $user->save();

        $from = Setting::where('name', 'send_email')->pluck('value')->first();
        $subject = config('app.name') . ' Active email';
        $to_email = strtolower($email);
        $data = array('token' => $active_email_token, 'email' => $email, 'uid' => md5($user->id));

        // dd($from, $subject, $to_email, $data);

        Mail::send(['html' => 'email.active_email'], ['token' => $active_email_token, 'email' => $email,'uid' => md5($user->id)], function (Message $message) use ($user) {
            $message->subject(config('app.name') . ' Active Email');
            $message->to($user->email);
        });

        // Mail::send('email.active_email', $data, function($message) use ($to_email, $subject, $from) {
        //     $message->to($to_email)->subject($subject);
        //     $message->from($from, config('app.name'));
        // });
    }
}
