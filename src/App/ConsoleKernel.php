<?php

namespace App;

use Illuminate\Console\Scheduling\Schedule;

class ConsoleKernel extends \Illuminate\Foundation\Console\Kernel
{
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
