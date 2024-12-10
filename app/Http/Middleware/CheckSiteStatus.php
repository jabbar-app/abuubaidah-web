<?php

namespace App\Http\Middleware;

use App\Models\Azure;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSiteStatus
{
    public function handle($request, Closure $next)
    {
        $isActive = Azure::value('is_active');
        if (!$isActive) {
            return response()->view('inactive');
        }
        return $next($request);
    }
}
