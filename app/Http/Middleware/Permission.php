<?php

namespace App\Http\Middleware;
use App\Http\Controllers\Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class Permission
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next,$level)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('user/login');
            }
        }
        $user = $this->auth->user();
        if($user->getAttribute('role') < $this->getLevel($level)  ){
            return response('Unauthorized.', 401);
        }
        return $next($request);
    }

    private function getLevel($level){
        return config('shop.roleCon.'.$level);
    }
}
