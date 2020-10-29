<?php
/**
 * Creator htm
 * Created by 2020/10/29 15:11
 **/

namespace Szkj\Rbac\Middleware;


use Szkj\Rbac\Exceptions\BadRequestExceptions;
use Szkj\Rbac\Models\Route;
use Closure;

class ControlOfAuthority
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!config('app.debug')) {
            $user = auth()->user();
            if (!Route::query()->whereHas('hasManyRoleRoutes', function ($query) use ($user) {
                    $query->where('role_id', $user->role_id);
                })->where('path', $request->getRequestUri())->count() && !$user->superadmin) {
                throw new BadRequestExceptions(422, "您没有权限");
            }
        }
        return $next($request);
    }
}