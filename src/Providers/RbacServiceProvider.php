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
    protected $middlewareGroups = ['auth:api'];
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->registerMigrations();
        $this->registerRoutes();
        $this->registerMiddleware('rbac',ControlOfAuthority::class);
    }

    /**
     * 资源发布
     */
    public function registerPublishing()
    {

    }

    public function registerMiddleware($name,$class){

        $router = $this->app['router'];

        $router->aliasMiddleware($name, $class);

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
        /**
         * 菜单
         */
        $router->apiResource('menus', MenusController::class)->middleware($this->middlewareGroups);
        /**
         * 角色
         */
        $router->apiResource('roles', RolesController::class)->middleware($this->middlewareGroups);
        $router->post('distribution-menus', RolesController::class . '@distributionMenus')->middleware($this->middlewareGroups);
        $router->post('distribution-routes', RolesController::class . '@distributionRoutes')->middleware($this->middlewareGroups);
        $router->post('copy', RolesController::class . '@copy')->name('复制角色')->middleware($this->middlewareGroups);
        $router->post('routes', RolesController::class . '@getRoutes')->middleware($this->middlewareGroups);
        $router->post('menus', RolesController::class . '@getMenus')->middleware($this->middlewareGroups);
        /**
         * 路由
         */
        $router->apiResource('routes', RoutesController::class)->middleware($this->middlewareGroups);
        $router->post('renovateRoute', RoutesController::class . '@renovateRoute')->middleware($this->middlewareGroups);
        $router->post('list', RoutesController::class . '@list')->middleware($this->middlewareGroups);
        /**
         * 路由组
         */
        $router->apiResource('routes_catalogs', RoutesCatalogsController::class)->middleware($this->middlewareGroups);
        $router->post('distribution-routes',RoutesCatalogsController::class .'@distributionRoutes')->middleware($this->middlewareGroups);
        $router->post('remove',RoutesCatalogsController::class .'@remove')->middleware($this->middlewareGroups);

    }
}