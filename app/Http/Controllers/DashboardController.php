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
        $mahasiswa = User::all()->count() - 9;
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
                'payments' => Payment::with('program')->orderBy('created_at', 'desc')->get(),
                'announcements' => Announcement::with('program')->get(),
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
                'payments' => Payment::with('program')->orderBy('created_at', 'desc')->get(),
            ]);
        } else if ($user->hasRole('Admin Tahsin')) {
            $program_ids = Program::where('programmable_type', '=', 'App\Models\Tahsin')->pluck('id');
            return view('admin-program.dashboard', [
                'mahasiswa' => $mahasiswa,
                'mahasiswa_program' => Kelas::whereIn('program_id', $program_ids)->count(),
                'program' => 'Tahsin Tilawah Al-Qur\'an',
                'kelas' => Kelas::whereIn('program_id', $program_ids)->get(),
            ]);
        } else if ($user->hasRole('Admin Tahfiz')) {
            $program_ids = Program::where('programmable_type', '=', 'App\Models\Tahfiz')->pluck('id');
            return view('admin-program.dashboard', [
                'mahasiswa' => $mahasiswa,
                'mahasiswa_program' => Kelas::whereIn('program_id', $program_ids)->count(),
                'program' => 'Beasiswa Tahfiz Al-Qur\'an',
                'kelas' => Kelas::whereIn('program_id', $program_ids)->get(),
            ]);
        } else if ($user->hasRole('Admin Bilhaq')) {
            $program_ids = Program::where('programmable_type', '=', 'App\Models\Bilhaq')->pluck('id');
            return view('admin-program.dashboard', [
                'mahasiswa' => $mahasiswa,
                'mahasiswa_program' => Kelas::whereIn('program_id', $program_ids)->count(),
                'program' => 'Bimbingan Menghafal Al-Qur\'an',
                'kelas' => Kelas::whereIn('program_id', $program_ids)->get(),
            ]);
        } else if ($user->hasRole('Admin KIBA')) {
            $program_ids = Program::where('programmable_type', '=', 'App\Models\Kiba')->pluck('id');
            return view('admin-program.dashboard', [
                'mahasiswa' => $mahasiswa,
                'mahasiswa_program' => Kelas::whereIn('program_id', $program_ids)->count(),
                'program' => 'Kursus Intensif Bahasa Arab',
                'kelas' => Kelas::whereIn('program_id', $program_ids)->get(),
            ]);
        } else if ($user->hasRole('Admin Lughoh')) {
            $program_ids = Program::where('programmable_type', '=', 'App\Models\Lughoh')->pluck('id');
            return view('admin-program.dashboard', [
                'mahasiswa' => $mahasiswa,
                'mahasiswa_program' => Kelas::whereIn('program_id', $program_ids)->count(),
                'program' => 'Program Bahasa Arab & Studi Islam',
                'kelas' => Kelas::whereIn('program_id', $program_ids)->get(),
            ]);
        } else if ($user->hasRole('Admin Stebis')) {
            $program_ids = Program::where('programmable_type', '=', 'App\Models\Stebis')->pluck('id');
            return view('admin-program.dashboard', [
                'mahasiswa' => $mahasiswa,
                'mahasiswa_program' => Kelas::whereIn('program_id', $program_ids)->count(),
                'program' => 'Integrasi S1 STEBIS AL ULUM Terpadu',
                'kelas' => Kelas::whereIn('program_id', $program_ids)->get(),
            ]);
        } else if ($user->hasRole('Admin FAI')) {
            $program_ids = Program::where('programmable_type', '=', 'App\Models\Fai')->pluck('id');
            return view('admin-program.dashboard', [
                'mahasiswa' => $mahasiswa,
                'mahasiswa_program' => Kelas::whereIn('program_id', $program_ids)->count(),
                'program' => 'Integrasi S1 Ma\'had - FAI UMSU',
                'kelas' => Kelas::whereIn('program_id', $program_ids)->get(),
            ]);
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
