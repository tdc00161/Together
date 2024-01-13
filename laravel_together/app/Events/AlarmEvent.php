<?php

namespace App\Events;

use App\Models\Alarm;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AlarmEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data, $receiver;

    /**
     * Create a new event instance.
     * ['PI' (같은 코드명), $user_id (받는유저id), $ChatRoom (무슨작업을 했는질 알 수 있는 데이터)]
     * @return void
     */
    public function __construct($content)
    {
        
        $this->data = json_encode($content);
        $this->receiver = $content[1];
        $this->dontBroadcastToCurrentUser();
        Log::debug('알람온다');
        // Log::debug($this->receiver);
        // Log::debug($this->data);
    }

    public function newAlarm()
    {
        $this->dontBroadcastToCurrentUser();
        Log::debug('알람만든다');

        Alarm::create([
            'listener_id' => $this->receiver,
            'content' => $this->data,
        ]);
    }

    public function deleteAlarm()
    {
        $this->dontBroadcastToCurrentUser();
        Log::debug('알람삭제한다');

        Alarm::create([
            'listener_id' => $this->receiver,
            'content' => $this->data,
        ]);
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
