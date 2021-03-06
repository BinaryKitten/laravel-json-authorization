<?php

namespace Voice\JsonAuthorization;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Voice\JsonAuthorization\App\AuthorizableSetType;
use Voice\JsonAuthorization\App\CachedModels\CachedAuthorizableModel;
use Voice\JsonAuthorization\Authorization\AbsoluteRights;
use Voice\JsonAuthorization\Authorization\EloquentEvents;
use Voice\JsonAuthorization\Authorization\RuleParser;

class JsonAuthorizationServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/asseco-authorization.php', 'asseco-authorization');
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/Routes/api.php');
        $this->registerCachedModels();
        $this->registerAuthorizationClasses();
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/Config/asseco-authorization.php' => config_path('asseco-authorization.php'),]);

        $override = Config::get('asseco-authorization.override_authorization');

        if (!$this->app->runningInConsole() && !$override) {
            /**
             * @var EloquentEvents $eloquentEvents
             */
            $eloquentEvents = $this->app->make(EloquentEvents::class);
            $eloquentEvents->attachEloquentListener();
        }
    }

    protected function registerCachedModels()
    {
        $this->app->singleton(CachedAuthorizableModel::class, function ($app) {
            return new CachedAuthorizableModel();
        });
    }

    protected function registerAuthorizationClasses(): void
    {
        $this->app->singleton('cached-authorizable-set-types', function ($app) {
            return AuthorizableSetType::getCached();
        });

        $this->app->singleton(AbsoluteRights::class, function ($app) {
            return new AbsoluteRights();
        });

        $this->app->singleton(RuleParser::class, function ($app) {
            return new RuleParser($app->make(AbsoluteRights::class));
        });

        $this->app->singleton(EloquentEvents::class, function ($app) {
            return new EloquentEvents();
        });
    }
}
