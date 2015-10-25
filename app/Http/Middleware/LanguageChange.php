<?php
/**
 * Created by PhpStorm.
 * User: Anurak
 * Date: 25/10/58
 * Time: 15:34
 */

namespace App\Http\Middleware;

use App;
use App\Http\Controllers\Auth;
use Barryvdh\Debugbar\Middleware\Debugbar;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Session;

class LanguageChange
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if(!Session::has('language'))
        {
            Session::put('language', config("app.fallback_locale"));
            App::setLocale(config("app.fallback_locale"));

        }else{
            App::setLocale(Session::get('language'));
        }
        return $next($request);
    }

}
