<?php

namespace App\Http\Middleware\Security;

use Closure;
use Illuminate\Http\Request;

class XSSProtection
{
    protected array $except = [
        'blog/posts/add',
        'blog/posts/edit/{any}',
    ];

    protected array $exceptRoutes = [
        'admin::blog:posts.edit',
        'admin::blog:posts.add',
        'livewire.update',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->getRequestUri(),$this->except))
        {
            return $next($request);
        }
        if (in_array($request->route()->getName(),$this->exceptRoutes))
        {
            return $next($request);
        }
        $userInput = $request->all();
        array_walk_recursive($userInput, function (&$userInput) {
            $userInput = strip_tags($userInput);
        });
        $request->merge($userInput);
        return $next($request);
    }
}
