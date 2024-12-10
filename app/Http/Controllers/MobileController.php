<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileController extends Controller
{
    public function loginShow()
    {
        return view('mobile.auth.login');
    }
}
