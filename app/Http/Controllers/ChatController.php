<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Suppprt\Facades\Auth;

use App\Http\Request\StoreMessageRequest;
use App\Models\Message;
use App\Models\User;

class ChatController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $contacts = User::whereHas('sentMessage', function($q) use ($userId){
            $q->where('receiver_id', $userId);
        })
        ->orWhereHas('receivedMessage', function($q) use ($userId){
            $q->where('sender_id', $userId);
        })->get();

        return view('messages.index', compact('contacts'));
    }

    public function show(User $user)
    {
        $userId = auth()->id();
        $messages = Message::where(function($q) use ($userId, $user) {
            $q->where('sender_id', $user->id)->where('receiver_id', $userId);
        })->orWhere(function($q) use ($user, $userId){
            $q->where('receiver_id', $user->id)->where('sender_id', $userId);
        })
        ->orderBy('created_at', 'asc')->get();

        return view('messages.show', compact('messages', 'user'));
    }


    public function store(StoreMessageRequest $request, User $user)

    {


        $message = Message::create([

            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'content' => $request->content

        ]);

        broadcast(new MessageSent($message))->toOthers();

        return back();

    }

    public function storeLive(StoreMessageRequest $request, $receiver_id)
    {
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiver_id,
            'content' => $request->content
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'message' => $message
        ]);
    }
}
