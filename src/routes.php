<?php
/**
 * Creator htm
 * Created by 2020/10/30 10:16.
 **/
$api = app('Dingo\Api\Routing\Router');

$api->version(config('api.version'), function ($api) {
    $api->group(['namespace' => config('szkj.route.namespace.rbac') . '\\Auth'], function ($api) {
        $api->post('login', 'AuthController@login');

        $api->group(['middleware' => config('szkj.route.middleware')], function ($api) {
            $api->post('logout', 'AuthController@logout');
            $api->post('rest_password', 'AuthController@restPassword');
        });

    });

    $api->group(['middleware' => config('szkj.route.middleware')], function ($api) {


        $api->group(['prefix' => 'rbac', 'namespace' => config('szkj.route.namespace.rbac') . '\\Rbac'], function ($api) {
            /*
             * 菜单.
             */
            $api->resource('menus', 'MenusController');
            /*
             * 角色.
             */
            $api->resource('roles', 'RolesController');
            $api->group(['prefix' => 'roles'], function ($api) {
                $api->post('distribution-menus', 'RolesController@distributionMenus');
                $api->post('distribution-routes', 'RolesController@distributionRoutes');
                $api->post('copy', 'RolesController@copy');
                $api->post('routes', 'RolesController@getRoutes');
                $api->post('menus', 'RolesController@getMenus');
            });

            /*
             * 路由.
             */
            $api->resource('routes', 'RoutesController');
            $api->group(['prefix' => 'routes'], function ($api) {
                $api->post('renovateRoute', 'RoutesController@renovateRoute');
                $api->post('list', 'RoutesController@list');
            });
            /*
             * 路由组.
             */
            $api->resource('routes_catalogs', 'RoutesCatalogsController');
            $api->group(['prefix' => 'routes_catalogs'], function ($api) {
                $api->post('distribution-routes', 'RoutesCatalogsController@distributionRoutes');
                $api->post('remove', 'RoutesCatalogsController@remove');
            });
        });

        $api->group(['prefix' => 'setting', 'namespace' => config('szkj.route.namespace.rbac') . '\\User'], function ($api) {
            $api->resource('user', 'UserController');
        });
    });

});
