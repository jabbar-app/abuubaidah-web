<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MaintenanceModeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (app()->isDownForMaintenance()) {
            // Directly return the maintenance mode view or redirect
            return response()->view('errors.503', [], 503);
            // Or return a redirect response if you prefer
            // return redirect('path/to/your/maintenance/page');
        }

        return $next($request);
    }
}
