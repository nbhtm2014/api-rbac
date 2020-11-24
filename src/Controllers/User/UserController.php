<?php
/**
 * Creator htm
 * Created by 2020/11/23 10:53
 **/

namespace Szkj\Rbac\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Szkj\Rbac\Controllers\BaseController;
use Szkj\Rbac\Models\User;
use Szkj\Rbac\Requests\Users\UserStoreRequests;

class UserController extends BaseController
{

    public function index(Request $request){

    }

    /**
     * @param UserStoreRequests $request
     * @return mixed
     */
    public function store(UserStoreRequests $request)
    {

        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $user = User::query()->create($data);

        return $this->success('创建成功', $user);
    }
}