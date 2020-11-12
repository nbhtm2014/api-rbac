<?php

namespace Szkj\Rbac\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Szkj\Rbac\Models\Menu;
use Szkj\Rbac\Models\Role;
use Szkj\Rbac\Models\RoleMenu;
use Szkj\Rbac\Models\RoleRoute;
use Szkj\Rbac\Models\RouteCatalog;
use Szkj\Rbac\Requests\Roles\CopyRequest;
use Szkj\Rbac\Requests\Roles\DistributionRequest;
use Szkj\Rbac\Requests\Roles\DistributionRoutesRequest;
use Szkj\Rbac\Requests\Roles\GetMenusRequest;
use Szkj\Rbac\Requests\Roles\GetRoutesRequest;
use Szkj\Rbac\Requests\Roles\RoleStoreRequest;
use Szkj\Rbac\Requests\Roles\RoleUpdateRequest;

class RolesController extends BaseController
{
    //
    public function index(Request $request)
    {
        $data = Role::query()->get()->toArray();

        return $this->success($data);
    }

    /**
     * @param RoleStoreRequest $request
     *
     * @return mixed
     */
    public function store(RoleStoreRequest $request)
    {
        $create = $request->validated();

        $role = Role::query()->create($create);

        Log::info('添加角色 : '.$role->name);

        return $this->success($role);
    }

    /**
     * @param $id
     *
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $role = Role::query()->find($id)->with(['hasOneUser', 'hasManyRoutes', 'hasManyMenus']);

        return $this->success($role);
    }

    /**
     * @param RoleUpdateRequest $request
     * @param $id
     *
     * @return \Dingo\Api\Http\Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        $update = $request->validated();

        Role::query()->where('id', $id)->update(['name' => $update['name']]);

        Log::info('修改角色');

        return $this->success();
    }

    /**
     * @param $id
     *
     * @throws \Exception
     *
     * @return \Dingo\Api\Http\Response
     */
    public function destroy($id)
    {
        if ($role = Role::query()->find($id)) {
            $userModel = config('auth.providers.users.model');
            if (!$userModel->where('role_id', $id)->count()) {
                //同步删除该角色下的 对应关系
                $role->hasManyRoutes()->delete();
                $role->hasManyMenus()->delete();

                Log::info('删除了'.$role->name.'角色');
                $role->delete();

                return $this->success();
            }

            return $this->error(422, '该角色存在用户，删除失败');
        }

        return $this->error(422, '未找到该记录');
    }

    /**
     * @param DistributionRequest $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function distributionMenus(DistributionRequest $request)
    {
        $all = $request->validated();
        RoleMenu::query()->where('role_id', $all['id'])->delete();
        if (empty($all['menu_ids'])) {
            return $this->error(422, '未为该角色分配任何菜单');
        }
        $menu_ids = json_decode($all['menu_ids'], true);
        if (is_array($menu_ids)) {
            $create = [];
            foreach ($menu_ids as $k => $v) {
                $create[$k]['role_id'] = $all['id'];
                $create[$k]['menu_id'] = $v;
                $create[$k]['created_at'] = date('Y-m-d H:i:s', time());
                $create[$k]['updated_at'] = date('Y-m-d H:i:s', time());
            }
            RoleMenu::query()->insert($create);
            Log::info('给角色分配菜单');

            return $this->success();
        }

        return $this->error(422, '数据格式出错');
    }

    /**
     * @param DistributionRoutesRequest $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function distributionRoutes(DistributionRoutesRequest $request)
    {
        $all = $request->validated();
        RoleRoute::query()->where('role_id', $all['id'])->delete();
        if (empty($all['route_ids'])) {
            return $this->success();
        }
        $route_ids = json_decode($all['route_ids'], true);
        if (is_array($route_ids)) {
            $create = [];
            foreach ($route_ids as $k => $v) {
                $create[$k]['role_id'] = $all['id'];
                $create[$k]['route_id'] = $v;
                $create[$k]['created_at'] = date('Y-m-d H:i:s', time());
                $create[$k]['updated_at'] = date('Y-m-d H:i:s', time());
            }
            RoleRoute::query()->insert($create);
            Log::info('给角色分配路由');

            return $this->success();
        }

        return $this->error(422, '数据格式错误');
    }

    /**
     * @param CopyRequest $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function copy(CopyRequest $request)
    {
        $data = $request->validated();

        $role = Role::query()->create(['name' => $data['name']]);

        $rules = RoleRoute::query()->select('route_id')->where('role_id', $data['id'])->get()->toArray();

        $create = [];

        foreach ($rules as $k => $v) {
            $create[$k]['route_id'] = $v['route_id'];
            $create[$k]['role_id'] = $role->id;
            $create[$k]['created_at'] = date('Y-m-d H:i:s', time());
            $create[$k]['updated_at'] = date('Y-m-d H:i:s', time());
        }
        if (RoleRoute::query()->insert($create)) {
            Log::info('复制角色成功');

            return $this->success();
        }
        Log::info('复制角色失败了');

        return $this->error(422, '复制角色失败');
    }

    /**
     * @param GetRoutesRequest $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function getRoutes(GetRoutesRequest $request)
    {
        $data = $request->validated();

        $role_routes = RouteCatalog::query()
            ->with(['hasManyRoutes'=> function ($query) use ($data) {
                $query->whereIn('id', function ($db) use ($data) {
                    $db->from('roles_routes')
                        ->select('route_id')
                        ->where('role_id', $data['id']);
                });
            }])
            ->get()
            ->toArray();

        return $this->success($role_routes);
    }

    /**
     * @param GetMenusRequest $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function getMenus(GetMenusRequest $request)
    {
        $data = $request->validated();
        $menu_ids = RoleMenu::query()->where($data)->pluck('menu_id')->toArray();
        $pid = Menu::query()->whereIn('id', $menu_ids)->pluck('pid')->toArray();
        $menus = Menu::query()
            ->whereIn('id', $pid)
            ->with(['children'=> function ($query) use ($menu_ids) {
                $query->whereIn('id', $menu_ids);
            }])
            ->get()
            ->toArray();

        return $this->success($menus);
    }
}
