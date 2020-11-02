<?php
/**
 * Creator htm
 * Created by 2020/10/28 11:28
 **/

namespace Szkj\Rbac\Providers;

use Illuminate\Support\ServiceProvider;
use Szkj\Rbac\Middleware\ControlOfAuthority;

class RbacServiceProvider extends ServiceProvider
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
     * @return void
     */
    public function boot(): void
    {
        $this->registerMigrations();
        $this->registerRoutes();
        $this->registerMiddleware();
    }

    /**
     * 资源发布
     */
    public function registerPublishing()
    {

    }

    public function registerMiddleware(){

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
     * 表迁移
     */
    public function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    /**
     * 注册路由
     */
    public function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');
    }
}