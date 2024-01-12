<?php

namespace App\Console\Commands;

use App\Events\OnOffline;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckUserActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $threshold = now()->subMinutes(15); // 15분 동안 활동이 없으면 오프라인으로 표시

        $offlineUser = User::where('last_activity', '<', $threshold)->get();
        Log::debug($offlineUser);
        foreach ($offlineUser as $key => $value) {
            Log::debug($value);
            // $OnOffline = new OnOffline(auth()->user());
            // $OnOffline->whoOnline();  
        }
    }
}
