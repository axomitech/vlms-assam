<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use App\Logging\DatabaseLogger;

class DatabaseLoggingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('dblog', function () {
            return new Logger('dblog', [new DatabaseLogger()]);
        });
    }

    public function boot()
    {
        //
    }
}

