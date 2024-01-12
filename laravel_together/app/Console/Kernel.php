<?php

namespace App\Console;

use App\Events\SpecificDateReached;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // 특정 일자에 도달했을 때 이벤트 발생
        $schedule->call(function () {
            $SpecificDateReached = new SpecificDateReached;
            $SpecificDateReached->TaskDateCheck();
            $SpecificDateReached->ProjectDateCheck();
        // })->daily(); // 매일 실행
        })->everyMinute();

        $schedule->command('user:check-activity')->everyMinute(); // 유저 온라인 체크
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
