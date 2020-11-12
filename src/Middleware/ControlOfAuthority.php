<?php
/**
 * Creator htm
 * Created by 2020/10/29 15:11.
 **/

namespace Szkj\Rbac\Middleware;

use Closure;
use Szkj\Rbac\Exceptions\RbacBadRequestExceptions;

class ControlOfAuthority
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!config('app.debug')) {
            $user = auth()->user();
            $route = class_exists('App\\Models\\Route') ? new \App\Models\Route() : new \Szkj\Rbac\Models\Route();
            if (!$route->query()->whereHas('hasManyRoleRoutes', function ($query) use ($user) {
                $query->where('role_id', $user->role_id);
            })->where('path', $request->getRequestUri())->count() && !$user->superadmin) {
                throw new RbacBadRequestExceptions(422, '您没有权限');
            }
        }

        return $next($request);
    }
}
