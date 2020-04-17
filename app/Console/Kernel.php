<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Components\Trains\FetchTrainsCommand;
use App\Tiles\TeamMember\Commands\FetchTasksCommand;
use App\Tiles\TeamMember\Commands\FetchStatusCommand;
use App\Tiles\Velo\FetchVeloStationsCommand;
use App\Console\Components\Dashboard\SendHeartbeatCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Tiles\Calendar\FetchCalendarEventsCommand;
use App\Tiles\Statistics\Commands\FetchGitHubTotalsCommand;
use App\Console\Components\Dashboard\DetermineAppearanceCommand;
use App\Tiles\TeamMember\Commands\FetchCurrentTracksCommand;
use App\Tiles\Statistics\Commands\FetchPackagistTotalsCommand;
use App\Tiles\Weather\Commands\FetchBuienradarForecastsCommand;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(FetchTrainsCommand::class)->everyMinute();
        $schedule->command(FetchCalendarEventsCommand::class)->everyMinute();
        $schedule->command(FetchCurrentTracksCommand::class)->everyMinute();
        $schedule->command(SendHeartbeatCommand::class)->everyMinute();
        $schedule->command(FetchVeloStationsCommand::class)->everyMinute();
        $schedule->command(DetermineAppearanceCommand::class)->everyMinute();
        $schedule->command(FetchBuienradarForecastsCommand::class)->everyFiveMinutes();
        $schedule->command(FetchTasksCommand::class)->everyFiveMinutes();
        $schedule->command(FetchStatusCommand::class)->everyFiveMinutes();
        $schedule->command(FetchGitHubTotalsCommand::class)->everyThirtyMinutes();
        $schedule->command(FetchPackagistTotalsCommand::class)->hourly();
        $schedule->command('websockets:clean')->daily();
    }

    public function commands()
    {
        $commandDirectories = glob(app_path('Console/Components/*'), GLOB_ONLYDIR);
        $commandDirectories[] = app_path('Console');

        collect($commandDirectories)->each(function (string $commandDirectory) {
            $this->load($commandDirectory);
        });
    }
}
