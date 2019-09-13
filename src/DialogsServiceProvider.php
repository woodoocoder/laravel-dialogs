<?php

namespace Woodoocoder\LaravelDialogs;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

class DialogsServiceProvider extends ServiceProvider {

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $useDefaultRounes = config('woodoocoder.dialogs.use_default_routes');

        Route::prefix('api/dialogs')
            ->middleware('api')
            ->namespace('Woodoocoder\LaravelDialogs')
            ->group(__DIR__ . '/routes/api.php');

        $this->commands([
            \Woodoocoder\LaravelDialogs\Console\InitCommand::class,
        ]);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        $this->mergeConfigFrom(__DIR__ .'/config/config.php', 'woodoocoder.dialogs');
        $this->publishes([__DIR__ .'/config/config.php' => config_path('woodoocoder/dialogs.php')], 'dialogs-config');
        
        $this->loadMigrationsFrom(__DIR__.'/database/migrations/');
    }
}
