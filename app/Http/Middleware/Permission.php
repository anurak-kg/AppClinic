<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth;
use Barryvdh\Debugbar\Middleware\Debugbar;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class Permission
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $permission)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('user/login');
            }
        }
        $user = $this->auth->user();

        if (!$user->can($permission)) {
            abort('403');
            //return response("<strong>Unauthorized. </strong><br>- - ไม่มีสิทธิเข้าใช้งาน  โปรติดต่อ Admin.", 403);
        }
        return $next($request);
    }

}
