<?php

namespace Elnooronline\Notifications\Providers;

use Elnooronline\Notifications\Console\DeleteExpiredFcmTokensCommand;
use Illuminate\Support\ServiceProvider;

class NotificationsServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();

        $this->registerMigrations();

        $this->registerConsoleCommands();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../config/elnooronline-notifications.php' => config_path('elnooronline-notifications.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../config/elnooronline-notifications.php',
            'elnooronline-notifications'
        );
    }

    /**
     * Register migrations.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        $this->publishes([
            __DIR__ . '/../Database/Migrations' => database_path('/migrations'),
        ], 'migrations');
    }

    /**
     * Register console commands.
     *
     * @return void
     */
    protected function registerConsoleCommands()
    {
        $this->commands([
            DeleteExpiredFcmTokensCommand::class,
        ]);
    }
}
