<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\MessageCreated;
use App\Events\MessageSentEvent;
use App\Http\Requests\ChatRequest;
use App\Jobs\SendEmailJob;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatsController extends Controller
{

    public function fetchMessages(User $receiver){
        return Chat::with('user')->where(['user_id'=> auth()->id(), 'receiver_id'=> $receiver->id])
            ->orWhere(function($query) use($receiver){
                $query->where(['user_id' => $receiver->id, 'receiver_id' => auth()->id()]);
            })->get();
    }

    public function fetchUsers(){
        return User::where('id','!=',auth()->id())->get();
    }

    public function sendMessage(ChatRequest $request, User $receiver){
        $user = auth()->user();
        $filename = null;

        if($request->hasFile('file') && $request->file){
            $filename  = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('public/chat',$filename);
        }

        $message = $user->messages()->create([
            'message' => $request->message,
            'receiver_id'   => $receiver->id,
            'file'  => $filename
        ])->load('user');

        broadcast(new MessageCreated($message, $user))->toOthers();
        dispatch(new SendEmailJob($message->user));

        return [ 'success' => true, 'message' => $message, 'user' => $user, ];
    }
}
