<?php

namespace Szkj\Rbac\Controllers\Rbac;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Szkj\Rbac\Controllers\BaseController;
use Szkj\Rbac\Models\Route;
use Szkj\Rbac\Models\RouteCatalog;
use Szkj\Rbac\Requests\Route\RouteListRequest;
use Szkj\Rbac\Requests\Route\RouteStoreRequest;
use Szkj\Rbac\Requests\Route\RouteUpdateRequest;
use Szkj\Rbac\Transformers\BaseTransformer;

class RoutesController extends BaseController
{
    /**
     * 刷新路由.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function renovateRoute()
    {
        set_time_limit(0);
        $routes = app()->routes->getRoutes();
        foreach ($routes as $key => $route) {
            $this->hasRoute($route);
        }
        Log::info('刷新路由');

        return $this->success();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $data = Route::query()
            ->when($name = $request->name, function ($query) use ($name) {
                $query->where('path', 'like', '%' . $name . '%')->orWhere('name', 'like', '%' . $name . '%');
            })
            ->where('pid', 0)
            ->paginate(15);

        return $this->response->paginator($data, new BaseTransformer());
    }

    /**
     * @param RouteListRequest $request
     * @return mixed
     */
    public function list(RouteListRequest $request)
    {
        $data = $request->validated();
        $route = Route::query()
            ->when(isset($data['name']), function ($query) use ($data) {
                $query->where('path', 'like', '%' . $data['name'] . '%')->orWhere('name', 'like', '%' . $data['name'] . '%');
            })
            ->where('pid', $data['pid'])
            ->get()
            ->toArray();

        return $this->success($route);
    }

    /**
     * @param RouteStoreRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(RouteStoreRequest $request)
    {
        $data = $request->validated();

        Route::query()->create($data);

        Log::info('添加路由');

        return $this->success();
    }

    /**
     * @param RouteUpdateRequest $request
     * @param $id
     *
     * @return \Dingo\Api\Http\Response
     */
    public function update(RouteUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $route = Route::query()->find($id);
        unset($route['id']);
        foreach ($data as $k => $v) {
            $route->$k = $v;
        }
        $route->save();
        Log::info('修改了 ' . $route->name . ' 路由');

        return $this->success();
    }

    /**
     * @param $id
     *
     * @return \Dingo\Api\Http\Response
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        if ($routes = Route::query()->find($id)) {
            //同步删除 角色路由表里的 对应该路由的所有数据
            $routes->hasManyRoleRoutes()->delete();

            Log::info('删除了 ' . $routes->path . $routes->name . ' 路由');

            $routes->delete();

            return $this->success();
        }

        return $this->error(422, '该路由不存在');
    }

    /**
     * @param $route
     */
    protected function hasRoute($route)
    {
        if ($route->uri != '/') {
            $uri = $this->createRoute($route);
            $this->createRouteCatalog($route->uri, $uri);
        }
    }

    /**
     * @param $route
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    protected function createRoute($route)
    {
        if ($uri = Route::query()->where('path', $route->uri)->first()) {
            $uri->uses = $route->action['uses'];
            if (!$uri->name && empty($uri->name)) {
                $uri->name = $route->action['as'] ?? '';
            }
            $uri->save();
        } else {
            $uri = Route::query()->updateOrCreate(
                ['path' => $route->uri],
                [
                    'uses' =>$route->action['uses'],
                    'path'    => $route->uri,
                    'methods' => implode(',', $route->methods),
                    'name'    => $route->action['as'] ?? '',
                ]
            );
        }

        return $uri;
    }

    /**
     * @param $path
     * @param $route
     */
    protected function createRouteCatalog($path, $route): void
    {
        $path = trim($path, '/');
        if ($path) {
            $path = explode('/', $path);
            $name = isset($path[config('szkj.route.route_level')]) ? $path[config('szkj.route.route_level')] : $path[array_key_last($path)];
            if ($route_catalog = RouteCatalog::query()->where('name', $name)->first()) {
                $route->pid = $route_catalog->id;
                $route->save();
            } else {
                $route_catalog = RouteCatalog::query()->create(['name' => $name]);
                $route->pid = $route_catalog->id;
                $route->save();
            }
        }
    }
}
