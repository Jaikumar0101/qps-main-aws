<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $layout = $request->segment(1) === 'admin' ? 'layouts.admin.app' : 'layouts.app';

        config()->set('excel.header_style', (new \OpenSpout\Common\Entity\Style\Style())->setFontBold());
        config()->set('livewire.layout', $layout);

        return $next($request);
    }
}
