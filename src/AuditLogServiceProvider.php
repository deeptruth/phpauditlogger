<?php

namespace Deeptruth\PhpAuditLogger;

use Illuminate\Support\ServiceProvider;

class AuditLogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // $this->publishes([
        //     __DIR__.'/Config/auditlog.php' => config_path('auditlog.php'),
        // ], 'config');

        $this->publishes([
            __DIR__.'/Migration/' => database_path('migrations')
        ], 'migrations');
        
        $this->app['auditlog'] = $this->app->share(function($app) {
            return new AuditLog;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        // Config
        // $this->mergeConfigFrom( __DIR__.'/Config/auditlog.php', 'auditlog');

        $this->app['auditlog'] = $this->app->share(function($app) {
            return new AuditLog;
        });
    }
}