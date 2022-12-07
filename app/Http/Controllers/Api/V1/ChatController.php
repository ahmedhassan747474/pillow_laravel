<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Chat;
use App\ChatMessage;
use JWTAuth;
use Auth;
use DB;
use App;
use Str;
use Carbon\Carbon;
use App\Events\SendMessage;

class ChatController extends BaseController
{
    function __construct() 
    {
        App::setLocale(request()->header('Accept-Language'));
        // date_default_timezone_set('Asia/Riyadh');
        ini_set( 'serialize_precision', -1 );
        $this->user = $this->getAuthenticatedUser();
    }

    public function getChatMessages(Request $request)
	{
		$user = $this->getAuthenticatedUser();
		
		if($user) {
            $chats = Chat::where(function($query) use ($request, $user){
            	$query->where('sender', $user->id);
            	$query->orWhere('receiver', $user->id);
            })
        	->where(function($query) use ($request, $user){
            	$query->where('sender', $request->from);
            	$query->orWhere('receiver', $request->from);
            })
        	->where('for_whom', $request->type)
        	->orderBy('id', 'desc')
        	->get();

            // $read = Chat::whereSender($user->id)->orWhere('receiver', $user->id)->update(['is_read' => '1']);
            
            // $messages =  array_reverse(\DB::select("SELECT * , ( r.sender + r.receiver ) 
            // AS dist FROM ( SELECT * FROM chat t WHERE ( t.sender = $user->id OR t.receiver = $user->id) ORDER BY t.id DESC ) r 
            // JOIN (SELECT MAX(id) id, ( sender + receiver ) 
            // AS dist FROM chat WHERE ( sender = $user->id OR receiver = $user->id) 
            // GROUP BY dist ORDER BY id DESC) t2 ON r.id = t2.id  "));
            
            return response()->json(['data' => $chats, 'status_code' => 200], 200);
        } else {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
	}

	public function sendMessage(Request $request)
	{
	    $user = $this->getAuthenticatedUser();
		
		if($user) {
		    $validator = Validator::make($request->all(), [
                'message'   => 'required',
                'type'      => 'required|in:file,text',
                'to'		=> 'required',
                'for_whom'	=> 'required|in:admin,ride'
            ]);
    
            if($validator->fails()) 
            {
                return $this->getErrorMessage($validator);
            }
            
            if($request->type == 'file') {
                $upload_image = uploadImageChat($request->message);
    
                if($upload_image == false)
                {
                    return $this->respond(['message' => trans('common.invalid_image_extension'), 'status_code' => 400], 400);
                }
            }

            $sendChat = Chat::create([
                'sender'        => $user->id,
                'receiver'      => $request->for_whom == 'admin' ? 0 : $request->to,
                // 'message'       => $request->type == 'text' ? $request->message : $upload_image,
                // 'type'          => $request->type,
                'for_whom'		=> $request->for_whom,
                'created_at'    => Carbon::now()
            ]);

            $sendMessage = ChatMessage::create([
                'message'       => $request->type == 'text' ? $request->message : $upload_image,
                'type'          => $request->type,
                'chat_id'       => $sendChat->id,
                'user_id'       => $user->id
            ]);

            if($request->for_whom == 'admin')
            {
                event(new SendMessage($request->message, $user->id));
            }
                        
            return response()->json(['data' => $sendMessage, 'status_code' => 200], 200);
        } else {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
	}
}
