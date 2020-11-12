<?php
/**
 * Creator htm
 * Created by 2020/10/30 10:16.
 **/
$api = app('Dingo\Api\Routing\Router');
$api->version(config('api.version'), [
    'middleware' => config('szkj.route.middleware'),
    'namespace'  => config('szkj.route.namespace'),
], function ($api) {
    $api->group(['prefix' => 'rbac'], function ($api) {
        /**
         * 菜单.
         */
        $api->resource('menus', 'MenusController');
        /**
         * 角色.
         */
        $api->resource('roles', 'RolesController');
        $api->post('distribution-menus', 'RolesController@distributionMenus');
        $api->post('distribution-routes', 'RolesController@distributionRoutes');
        $api->post('copy', 'RolesController@copy');
        $api->post('routes', 'RolesController@getRoutes');
        $api->post('menus', 'RolesController@getMenus');
        /**
         * 路由.
         */
        $api->resource('routes', 'RoutesController');
        $api->post('renovateRoute', 'RoutesController@renovateRoute');
        $api->post('list', 'RoutesController@list');
        /**
         * 路由组.
         */
        $api->resource('routes_catalogs', 'RoutesCatalogsController');
        $api->post('distribution-routes', 'RoutesCatalogsController@distributionRoutes');
        $api->post('remove', 'RoutesCatalogsController@remove');
    });
});
