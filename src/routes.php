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


Route::prefix('api/rbac')->middleware(['auth:api','szkj.rbac'])->group(function (){
    /**
     * 菜单
     */
    Route::apiResource('menus', MenusController::class);
    /**
     * 角色
     */
    Route::apiResource('roles', RolesController::class);
    Route::post('distribution-menus', RolesController::class . '@distributionMenus');
    Route::post('distribution-routes', RolesController::class . '@distributionRoutes');
    Route::post('copy', RolesController::class . '@copy');
    Route::post('routes', RolesController::class . '@getRoutes');
    Route::post('menus', RolesController::class . '@getMenus');
    /**
     * 路由
     */
    Route::apiResource('routes', RoutesController::class);
    Route::post('renovateRoute', RoutesController::class . '@renovateRoute');
    Route::post('list', RoutesController::class . '@list');
    /**
     * 路由组
     */
    Route::apiResource('routes_catalogs', RoutesCatalogsController::class);
    Route::post('distribution-routes',RoutesCatalogsController::class .'@distributionRoutes');
    Route::post('remove',RoutesCatalogsController::class .'@remove');
});