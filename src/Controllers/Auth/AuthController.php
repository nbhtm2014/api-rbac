<?php
/**
 * Creator htm
 * Created by 2020/11/24 9:27
 **/

namespace Szkj\Rbac\Controllers\Auth;


use Illuminate\Support\Facades\Log;
use Szkj\Rbac\Controllers\BaseController;
use Szkj\Rbac\Models\Route;
use Szkj\Rbac\Models\User;
use Szkj\Rbac\Requests\Auths\LoginRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use \Dingo\Api\Http\Response;
class AuthController extends BaseController
{
    /**
     * @param LoginRequest $request
     * @return Response
     */
    public function login(LoginRequest $request): Response
    {
        if ($user = User::query()
            ->where('name', $request->name)
            ->orWhere('phone', $request->name)
            ->first()) {
            if ($token = auth('api')->attempt(['name' => $user->name, 'password' => $request->password])) {
                if (!Route::query()->whereHas('hasManyRoleRoutes', function ($query) use ($user) {
                        $query->where('role_id', $user->role_id);
                    })->where('path', $request->getRequestUri())->count() &&
                    !$user->superadmin) {
                    return $this->error(422, '您没有权限');
                }
                $user->ip = $request->ip();
                $user->save();
                Log::info('用户登入成功');
                return $this->success(['token' => $token, 'user' => $user], '登入成功');
            }
            return $this->error(422, '密码错误');
        }
        return $this->error(422, '用户不存在');
    }

    /**
     * @return Response
     */
    public function logout(): Response
    {
        Log::info('用户登出');
        //token加入黑名单
        auth()->guard('api')->logout();

        JWTAuth::invalidate(JWTAuth::getToken());

        return $this->success();
    }
}