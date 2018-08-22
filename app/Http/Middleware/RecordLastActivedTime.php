<?php

namespace App\Http\Middleware;

use Closure;

class RecordLastActivedTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(\Auth::check()){
            //记录用户最后登陆时间
            \Auth::user()->recordLastActived();
        }
        return $next($request);
    }
}
