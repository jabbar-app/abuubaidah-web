<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use App\Models\Student;

class ShareData
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
        // Ambil user yang sedang login
        $user = $request->user();

        // Ambil data students berdasarkan user_id
        if ($user) {
            $students = Student::where('user_id', $user->id)->get();
            // Bagikan data students ke semua view
            View::share('students', $students);
        }

        return $next($request);
    }
}
