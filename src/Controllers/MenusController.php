<?php

namespace Szkj\Rbac\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Szkj\Rbac\Models\Menu;
use Szkj\Rbac\Requests\Menus\MenuStoreRequest;
use Szkj\Rbac\Requests\Menus\MenuUpdateRequest;

class MenusController extends BaseController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $data = Menu::query()
            ->where('pid', 0)
            ->with('children')
            ->get();
        return $this->success($data);
    }

    /**
     * @param MenuStoreRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(MenuStoreRequest $request)
    {
        $create = $request->validated();

        if (Menu::query()->create($create)) {

            Log::info('添加菜单');

            return $this->success();
        } else {
            return $this->error(422, '添加菜单失败');
        }
    }

    /**
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $menu = Menu::query()->find($id);

        return $this->success($menu);
    }

    /**
     * @param MenuUpdateRequest $request
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function update(MenuUpdateRequest $request, $id)
    {
        $update = $request->validated();

        Menu::query()->updateOrCreate(['id' => $id], $update);

        Log::info('修改菜单');

        return $this->success();
    }

    /**
     * @param $id
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        if ($menu = Menu::query()->find($id)) {
            if (!Menu::query()->where('pid', $menu->id)->count()) {
                $menu->hasManyRoleMenus()->delete();
                $menu->delete();
                Log::info('删除菜单');
                return $this->success();
            }
            return $this->error(422, '该菜单下有子菜单，请先删除子菜单');
        }
        return $this->error(422, '未找到该记录');
    }
}
