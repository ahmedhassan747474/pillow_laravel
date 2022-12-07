<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Chat;
use App\ChatMessage;
use App\Events\SendMessage;

class ChatController extends Controller
{
    public function __constract()
    {
    	$this->middleware('auth');
    }

    public function index()
    {
    	return view('chats');
    }

    public function fetchMessages()
    {
        // return Chat::with('messages')->get();
        return ChatMessage::with('user')->get();
    }

    public function sendMessage(Request $request)
    {
        $sendChat = Chat::updateOrCreate([
            'sender'    => auth()->user()->id,
            'receiver'  => 6,//$request->receiver,
            'for_whom'  => 'ride'
        ]);

        $sendMessage = ChatMessage::create([
            'message'   => $request->message,
            'type'      => 'text',
            'chat_id'   => $sendChat->id,
            'user_id'   => auth()->user()->id
        ]);

        broadcast(new SendMessage($sendMessage->load('user')))->toOthers();

        return ['status' => 'success'];
    }
}
