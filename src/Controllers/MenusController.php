<?php

namespace Szkj\Rbac\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Szkj\Rbac\Models\Menu;
use Szkj\Rbac\Requests\Menus\MenuStoreRequest;

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
     * @return \Illuminate\Http\JsonResponse
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

}
