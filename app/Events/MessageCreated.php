<?php

namespace App\Events;

use App\Chat;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageCreated implements ShouldBroadcast
{
    public $message;
    public $user;

    public function __construct(Chat $message, User $user)
    {
        $this->message = $message;
        $this->user = $user; 
    }

    public function broadcastOn()
    {
        return new PrivateChannel("room.1");
    }
}
