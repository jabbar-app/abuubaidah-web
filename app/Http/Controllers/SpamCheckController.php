<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class SpamCheckController extends Controller
{
    public function showSpamCheck()
    {
        return view('auth.spam_check');
    }

    public function redirectToDashboard()
    {
        // Clear the login message
        session()->forget('login');

        return redirect()->route('dashboard');
    }
}
