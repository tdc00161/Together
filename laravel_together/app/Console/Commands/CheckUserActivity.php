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
    protected $signature = 'user:check-activity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check user activity and mark as offline if inactive for 15 minutes';

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
            $OnOffline = new OnOffline($value);
            $OnOffline->whoOffline();  
        }
    }
}
