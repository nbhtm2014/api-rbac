<?php
/**
 * Creator htm
 * Created by 2020/10/30 10:16
 **/
use Illuminate\Support\Facades\Route;
use Szkj\Rbac\Controllers\MenusController;
use Szkj\Rbac\Controllers\RolesController;
use Szkj\Rbac\Controllers\RoutesCatalogsController;
use Szkj\Rbac\Controllers\RoutesController;


Route::prefix('api')->middleware(['auth:api','szkj.rbac'])->group(function (Route $route){
    $route->apiResource('menus', MenusController::class);
    /**
     * 角色
     */
    $route->apiResource('roles', RolesController::class);
    $route->post('distribution-menus', RolesController::class . '@distributionMenus');
    $route->post('distribution-routes', RolesController::class . '@distributionRoutes');
    $route->post('copy', RolesController::class . '@copy')->name('复制角色');
    $route->post('routes', RolesController::class . '@getRoutes');
    $route->post('menus', RolesController::class . '@getMenus');
    /**
     * 路由
     */
    $route->apiResource('routes', RoutesController::class);
    $route->post('renovateRoute', RoutesController::class . '@renovateRoute');
    $route->post('list', RoutesController::class . '@list');
    /**
     * 路由组
     */
    $route->apiResource('routes_catalogs', RoutesCatalogsController::class);
    $route->post('distribution-routes',RoutesCatalogsController::class .'@distributionRoutes');
    $route->post('remove',RoutesCatalogsController::class .'@remove');
});