<?php

namespace Rutatiina\User;

use Illuminate\Support\ServiceProvider;
use \Spatie\Permission\Middlewares\RoleMiddleware;
use \Spatie\Permission\Middlewares\PermissionMiddleware;
use \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware;
use Rutatiina\User\Models\User;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');

        $this->app['config']->set('auth.providers.users.model', User::class); //set the default user model to the one in this package

        //$this->loadViewsFrom(__DIR__.'/resources/views', 'expense');
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');

        //register the Spatie\Permission middlewares
        //https://spatie.be/docs/laravel-permission/v5/basic-usage/middleware
        $this->app['router']->aliasMiddleware('role', RoleMiddleware::class);
        $this->app['router']->aliasMiddleware('permission', PermissionMiddleware::class);
        $this->app['router']->aliasMiddleware('role_or_permission', RoleOrPermissionMiddleware::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Rutatiina\User\Http\Controllers\UserController');
    }
}
