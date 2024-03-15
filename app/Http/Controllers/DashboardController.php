<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Program;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $programs = Program::all()->sortByDesc('status');
        $statusKelas = Kelas::where('user_id' , auth()->user()->id)->get();

        return view('student.dashboard', compact('programs', 'statusKelas'));
    }
}
