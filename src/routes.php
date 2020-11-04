<?php
/**
 * Creator htm
 * Created by 2020/10/30 10:16
 **/

use Szkj\Rbac\Controllers\MenusController;
use Szkj\Rbac\Controllers\RolesController;
use Szkj\Rbac\Controllers\RoutesCatalogsController;
use Szkj\Rbac\Controllers\RoutesController;

$api = app('Dingo\Api\Routing\Router');
$api->version(config('api.version'), ['middleware' => ['auth:api', 'szkj.rbac']], function ($api) {

    $api->group(['prefix' => 'rbac'], function ($api) {
        /**
         * 菜单
         */
        $api->resource('menus', MenusController::class);
        /**
         * 角色
         */
        $api->resource('roles', RolesController::class);
        $api->post('distribution-menus', RolesController::class . '@distributionMenus');
        $api->post('distribution-routes', RolesController::class . '@distributionRoutes');
        $api->post('copy', RolesController::class . '@copy');
        $api->post('routes', RolesController::class . '@getRoutes');
        $api->post('menus', RolesController::class . '@getMenus');
        /**
         * 路由
         */
        $api->resource('routes', RoutesController::class);
        $api->post('renovateRoute', RoutesController::class . '@renovateRoute');
        $api->post('list', RoutesController::class . '@list');
        /**
         * 路由组
         */
        $api->resource('routes_catalogs', RoutesCatalogsController::class);
        $api->post('distribution-routes', RoutesCatalogsController::class . '@distributionRoutes');
        $api->post('remove', RoutesCatalogsController::class . '@remove');
    });
});
