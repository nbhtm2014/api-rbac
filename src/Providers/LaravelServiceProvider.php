<?php
/**
 * Creator htm
 * Created by 2020/10/28 11:28.
 **/

namespace Szkj\Rbac\Providers;

use Illuminate\Support\ServiceProvider;
use Szkj\Rbac\Console\Commands\InstallCommand;
use Szkj\Rbac\Middleware\ControlOfAuthority;

class LaravelServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $routeMiddleware = [
        'szkj.rbac' => ControlOfAuthority::class,
    ];

    /**
     * @var array
     */
    protected $middlewareGroups = [
        'szkj' => [
            'szkj.rbac',
        ],
    ];

    /**
     * @var array
     */
    protected $commands = [
        InstallCommand::class,
    ];

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->registerMigrations();

        $this->registerMiddleware();
    }

    public function register()
    {
        $this->registerRoutes();

        $this->commands($this->commands);
    }

    /**
     * 资源发布.
     */
    public function registerPublishing()
    {
    }

    public function registerMiddleware()
    {
        $router = $this->app->make('router');

        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            $router->aliasMiddleware($key, $middleware);
        }

        // register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            $router->middlewareGroup($key, $middleware);
        }
    }

    /**
     * 表迁移.
     */
    public function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }

    /**
     * 注册路由.
     */
    public function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes.php');
    }
}
