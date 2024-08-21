<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictionIpHelper
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->check())
        {
            if (auth()->user()->ip_check)
            {
                $ips = auth()->user()->ip_allowed;
                $allowed = checkData($ips)?explode(',',$ips):[];

                if(!in_array($request->ip(),$allowed))
                {
                    return abort(530);
                }
            }
        }
        return $next($request);
    }
}
