<?php

namespace App\Listeners;

use App\Events\MessageSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageSentListener
{
    public $listenTest, $test;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct($a)
    {
        Log::debug('리스너 컨스트럭트');
        $this->test = $a;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        $this->listenTest = Auth::id();
        Log::debug('리스너 핸들러');
    }
}
