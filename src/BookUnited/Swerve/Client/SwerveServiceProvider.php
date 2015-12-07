<?php

namespace BookUnited\Swerve\Client;

use Illuminate\Support\ServiceProvider;

/**
 * Class SwerveServiceProvider
 * @package BookUnited\Swerve\Client
 */
class SwerveServiceProvider extends ServiceProvider {

    /**
     *
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('swerve.php'),
        ]);
    }

    public function register()
    {
    }

}