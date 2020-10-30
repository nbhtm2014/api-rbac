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

        $this->loadRoutesFrom(__DIR__ . '/../szkj-rbac-route.php');
//        /* @var Router $router */
//        $router = $this->app['router'];
//        /**
//         * 菜单
//         */
//        $router->prefix('api')->apiResource('menus', MenusController::class)->middleware(['auth:api','szkj.rbac']);
//        /**
//         * 角色
//         */
//        $router->prefix('api')->apiResource('roles', RolesController::class)->middleware(['auth:api','szkj.rbac']);
//        $router->prefix('api')->post('distribution-menus', RolesController::class . '@distributionMenus')->middleware(['auth:api','szkj.rbac']);
//        $router->prefix('api')->post('distribution-routes', RolesController::class . '@distributionRoutes')->middleware(['auth:api','szkj.rbac']);
//        $router->prefix('api')->post('copy', RolesController::class . '@copy')->name('复制角色')->middleware(['auth:api','szkj.rbac']);
//        $router->prefix('api')->post('routes', RolesController::class . '@getRoutes')->middleware(['auth:api','szkj.rbac']);
//        $router->prefix('api')->post('menus', RolesController::class . '@getMenus')->middleware(['auth:api','szkj.rbac']);
//        /**
//         * 路由
//         */
//        $router->prefix('api')->apiResource('routes', RoutesController::class)->middleware(['auth:api','szkj.rbac']);
//        $router->prefix('api')->post('renovateRoute', RoutesController::class . '@renovateRoute')->middleware(['auth:api','szkj.rbac']);
//        $router->prefix('api')->post('list', RoutesController::class . '@list')->middleware(['auth:api','szkj.rbac']);
//        /**
//         * 路由组
//         */
//        $router->prefix('api')->apiResource('routes_catalogs', RoutesCatalogsController::class)->middleware(['auth:api','szkj.rbac']);
//        $router->prefix('api')->post('distribution-routes',RoutesCatalogsController::class .'@distributionRoutes')->middleware(['auth:api','szkj.rbac']);
//        $router->prefix('api')->post('remove',RoutesCatalogsController::class .'@remove')->middleware(['auth:api','szkj.rbac']);

    }
}