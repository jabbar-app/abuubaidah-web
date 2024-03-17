<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Kelas;
use App\Models\Payment;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $programs = Program::all()->sortByDesc('status');

        if ($programs->isEmpty()) {
            $program = null;
        }

        $statusKelas = Kelas::where('user_id', auth()->user()->id)->get();

        if ($user->hasRole('Super Admin')) {
            return view('admin.dashboard', [
                'total_user' => User::all()->count() - 9, // 9 is admin
                'total_transaksi' => Payment::sum('amount'),
                'total_transaksi_berhasil' => Payment::where('status', 'PAID')->sum('amount'),
                'total_transaksi_pending' => Payment::whereIn('status', ['PENDING', 'EXPIRED'])->sum('amount'),
                'transaksi_berhasil' => Payment::where('status', 'PAID')->count(),
                'transaksi_pending' => Payment::whereIn('status', ['PENDING', 'EXPIRED'])->count(),
                'xendit' => Payment::where('status', 'PAID')->where('method', 'xendit')->sum('amount'),
                'offline' => Payment::where('status', 'PAID')->where('method', 'offline')->sum('amount'),
                'programs' => $programs,
                'statusKelas' => $statusKelas,
            ]);
        } else if ($user->hasRole('Accountant')) {
            return view('accountant.dashboard', [
                'total_user' => User::all()->count() - 9, // 9 is admin
                'total_transaksi' => Payment::sum('amount'),
                'total_transaksi_berhasil' => Payment::where('status', 'PAID')->sum('amount'),
                'total_transaksi_pending' => Payment::whereIn('status', ['PENDING', 'EXPIRED'])->sum('amount'),
                'transaksi_berhasil' => Payment::where('status', 'PAID')->count(),
                'transaksi_pending' => Payment::whereIn('status', ['PENDING', 'EXPIRED'])->count(),
                'programs' => $programs,
                'statusKelas' => $statusKelas,
            ]);
        } else if ($user->hasRole('Admin Program')) {
            return view('admin-program.dashboard', compact('programs', 'statusKelas'));
        } else {
            return view('student.dashboard', [
                'main' => Announcement::where('category', 'main')->first(),
                'programs' => $programs,
                'statusKelas' => $statusKelas,
            ]);
        }
    }

    public function myProgram()
    {
        $kelas = Kelas::where('user_id', auth()->user()->id)->get();

        return view('student.kelas', compact('kelas'));
    }

    public function myTransaction()
    {
        $payment = Payment::where('user_id', auth()->user()->id)->get();

        return view('student.payment', compact('payment'));
    }
}
