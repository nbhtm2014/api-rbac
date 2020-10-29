<?php
/**
 * Creator htm
 * Created by 2020/10/28 11:28
 **/

namespace Szkj\Rbac\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Szkj\Rbac\Controllers\MenusController;
use Szkj\Rbac\Controllers\RolesController;
use Szkj\Rbac\Controllers\RoutesCatalogsController;
use Szkj\Rbac\Controllers\RoutesController;

class RbacServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->registerMigrations();
        $this->registerRoutes();
    }

    /**
     * 资源发布
     */
    public function registerPublishing()
    {

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
        /* @var Router $router */
        $router = $this->app['router'];
        $router->apiResource('menus', MenusController::class)->middleware(['auth.api']);
        $router->apiResource('roles', RolesController::class)->middleware(['auth.api']);
        $router->apiResource('routes', RoutesController::class)->middleware(['auth.api']);
        $router->apiResource('routes_catalogs', RoutesCatalogsController::class)->middleware(['auth.api']);

    }
}