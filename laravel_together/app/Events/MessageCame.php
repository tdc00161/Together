<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageCame
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $readCount = 0;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        // $this->senderName = User::find($message->sender_id)->name;
        $this->dontBroadcastToCurrentUser();
        Log::debug('메세지온다');
    }

    // 안읽은 횟수 카운트
    public function readUp($a)
    {
        $this->readCount++;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chats');
    }
}
