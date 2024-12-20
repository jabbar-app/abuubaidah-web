<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Kelas;
use App\Models\Payment;
use App\Models\Program;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $loginMessage = session('login');

        if ($loginMessage) {
            return redirect()->route('spam.check');
        }

        $user = Auth::user();
        $mahasiswa = User::all()->count() - 9;

        $programs = Program::where('status', 1)->get()->map(function ($program) {
            $program_id = $program->id;

            // Get new classes with payments
            $newClasses = Kelas::where('program_id', $program_id)->where('is_new', 1)->with('payments')->get();

            $program->new_paid = $newClasses->filter(function ($kelas) {
                return $kelas->payments->contains('status', 'PAID');
            })->count();

            $program->new_pending = $newClasses->filter(function ($kelas) {
                return $kelas->payments->contains('status', 'PENDING');
            })->count();

            $program->new_expired = $newClasses->filter(function ($kelas) {
                return $kelas->payments->contains('status', 'EXPIRED');
            })->count();

            $program->new_no_payment = $newClasses->filter(function ($kelas) {
                return $kelas->payments->isEmpty();
            })->count();

            $program->new_total = $program->new_paid + $program->new_pending + $program->new_expired + $program->new_no_payment;

            // Get renew classes with payments
            $renewClasses = Kelas::where('program_id', $program_id)->where('is_new', 0)->with('payments')->get();

            $program->renew_paid = $renewClasses->filter(function ($kelas) {
                return $kelas->payments->contains('status', 'PAID');
            })->count();

            $program->renew_pending = $renewClasses->filter(function ($kelas) {
                return $kelas->payments->contains('status', 'PENDING');
            })->count();

            $program->renew_expired = $renewClasses->filter(function ($kelas) {
                return $kelas->payments->contains('status', 'EXPIRED');
            })->count();

            $program->renew_no_payment = $renewClasses->filter(function ($kelas) {
                return $kelas->payments->isEmpty();
            })->count();

            $program->renew_total = $program->renew_paid + $program->renew_pending + $program->renew_expired + $program->renew_no_payment;

            // Total counts
            $program->total_paid = $program->new_paid + $program->renew_paid;
            $program->total_pending = $program->new_pending + $program->renew_pending;
            $program->total_expired = $program->new_expired + $program->renew_expired;
            $program->total = $program->new_total + $program->renew_total;

            // Debugging log for validation
            Log::info("Program ID: {$program_id}, Total: {$program->total}, Expected Total: " . ($program->new_total + $program->renew_total));
            Log::info("New Total: {$program->new_total}, Renew Total: {$program->renew_total}");
            Log::info("New Paid: {$program->new_paid}, Renew Paid: {$program->renew_paid}");
            Log::info("New Pending: {$program->new_pending}, Renew Pending: {$program->renew_pending}");
            Log::info("New Expired: {$program->new_expired}, Renew Expired: {$program->renew_expired}");
            Log::info("New No Payment: {$program->new_no_payment}, Renew No Payment: {$program->renew_no_payment}");

            return $program;
        });

        $statusKelas = Kelas::where('user_id', auth()->user()->id)->get();

        if ($user->hasRole('Super Admin')) {
            return view('admin.dashboard', [
                'total_user' => User::all()->count() - 9,
                'total_transaksi' => Payment::sum('amount'),
                'total_transaksi_berhasil' => Payment::where('status', 'PAID')->sum('amount'),
                'total_transaksi_pending' => Payment::whereIn('status', ['PENDING', 'EXPIRED'])->sum('amount'),
                'transaksi_berhasil' => Payment::where('status', 'PAID')->count(),
                'transaksi_pending' => Payment::whereIn('status', ['PENDING', 'EXPIRED'])->count(),
                'xendit' => Payment::where('status', 'PAID')->where('method', 'xendit')->sum('amount'),
                'offline' => Payment::where('status', 'PAID')->where('method', 'offline')->sum('amount'),
                'programs' => $programs,
                'activePrograms' => Program::where('status', 1)->count(),
                'nonActivePrograms' => Program::where('status', 0)->count(),
                'totalPrograms' => Program::count(),
                'statusKelas' => $statusKelas,
                'payments' => Payment::with('program')->orderBy('created_at', 'desc')->get(),
                'announcements' => Announcement::with('program')->get(),
            ]);
        } else if ($user->hasRole('Accountant')) {
            return view('accountant.dashboard', [
                'main' => Announcement::where('category', 'main')->first(),
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
                'program_id' => Program::where('programmable_type', '=', 'App\Models\Tahsin')->value('id'),
                'main' => Announcement::where('category', 'main')->first(),
                'mahasiswa' => $mahasiswa,
                'mahasiswa_program' => Kelas::whereIn('program_id', $program_ids)->count(),
                'program' => 'Tahsin Tilawah Al-Qur\'an',
                'kelas' => Kelas::whereIn('program_id', $program_ids)->get(),
            ]);
        } else if ($user->hasRole('Admin Tahfiz')) {
            $program_ids = Program::where('programmable_type', '=', 'App\Models\Tahfiz')->pluck('id');
            return view('admin-program.dashboard', [
                'program_id' => Program::where('programmable_type', '=', 'App\Models\Tahfiz')->value('id'),
                'main' => Announcement::where('category', 'main')->first(),
                'mahasiswa' => $mahasiswa,
                'mahasiswa_program' => Kelas::whereIn('program_id', $program_ids)->count(),
                'program' => 'Beasiswa Tahfiz Al-Qur\'an',
                'kelas' => Kelas::whereIn('program_id', $program_ids)->get(),
            ]);
        } else if ($user->hasRole('Admin Bilhaq')) {
            $program_ids = Program::where('programmable_type', '=', 'App\Models\Bilhaq')->pluck('id');
            return view('admin-program.dashboard', [
                'program_id' => Program::where('programmable_type', '=', 'App\Models\Bilhaq')->value('id'),
                'main' => Announcement::where('category', 'main')->first(),
                'mahasiswa' => $mahasiswa,
                'mahasiswa_program' => Kelas::whereIn('program_id', $program_ids)->count(),
                'program' => 'Bimbingan Menghafal Al-Qur\'an',
                'kelas' => Kelas::whereIn('program_id', $program_ids)->get(),
            ]);
        } else if ($user->hasRole('Admin KIBA')) {
            $program_ids = Program::where('programmable_type', '=', 'App\Models\Kiba')->pluck('id');
            return view('admin-program.dashboard', [
                'program_id' => Program::where('programmable_type', '=', 'App\Models\Kiba')->value('id'),
                'main' => Announcement::where('category', 'main')->first(),
                'mahasiswa' => $mahasiswa,
                'mahasiswa_program' => Kelas::whereIn('program_id', $program_ids)->count(),
                'program' => 'Kursus Intensif Bahasa Arab',
                'kelas' => Kelas::whereIn('program_id', $program_ids)->get(),
            ]);
        } else if ($user->hasRole('Admin Lughoh')) {
            $program_ids = Program::where('programmable_type', '=', 'App\Models\Lughoh')->pluck('id');
            return view('admin-program.dashboard', [
                'program_id' => Program::where('programmable_type', '=', 'App\Models\Lughoh')->value('id'),
                'main' => Announcement::where('category', 'main')->first(),
                'mahasiswa' => $mahasiswa,
                'mahasiswa_program' => Kelas::whereIn('program_id', $program_ids)->count(),
                'program' => 'Program Bahasa Arab & Studi Islam',
                'kelas' => Kelas::whereIn('program_id', $program_ids)->get(),
            ]);
        } else if ($user->hasRole('Admin Stebis')) {
            $program_ids = Program::where('programmable_type', '=', 'App\Models\Stebis')->pluck('id');
            return view('admin-program.dashboard', [
                'program_id' => Program::where('programmable_type', '=', 'App\Models\Stebis')->value('id'),
                'main' => Announcement::where('category', 'main')->first(),
                'program_ids' => $program_ids,
                'mahasiswa' => $mahasiswa,
                'mahasiswa_program' => Kelas::whereIn('program_id', $program_ids)->count(),
                'program' => 'Integrasi S1 STEBIS AL ULUM Terpadu',
                'kelas' => Kelas::whereIn('program_id', $program_ids)->get(),
            ]);
        } else if ($user->hasRole('Admin FAI')) {
            $program_ids = Program::where('programmable_type', '=', 'App\Models\Fai')->pluck('id');
            return view('admin-program.dashboard', [
                'program_id' => Program::where('programmable_type', '=', 'App\Models\Fai')->value('id'),
                'main' => Announcement::where('category', 'main')->first(),
                'mahasiswa' => $mahasiswa,
                'mahasiswa_program' => Kelas::whereIn('program_id', $program_ids)->count(),
                'program' => 'Integrasi S1 Ma\'had - FAI UMSU',
                'kelas' => Kelas::whereIn('program_id', $program_ids)->get(),
            ]);
        } else {
            $payments = Payment::where('user_id', $user->id)
                ->where(function ($query) {
                    $query->where('status', 'PENDING')
                        ->orWhere('status', 'EXPIRED');
                })
                ->get();

            $fields = [
                'nik', 'phone', 'email', 'name', 'tempat_lahir', 'tanggal_lahir',
                'status_perkawinan', 'agama', 'suku', 'address', 'province', 'regency',
                'district', 'ukuran_almamater', 'nama_sd', 'lulus_sd', 'nama_smp',
                'lulus_smp', 'nama_sma', 'lulus_sma', 'perguruan_tinggi', 'status_ayah',
                'nama_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'telp_ayah',
                'status_ibu', 'nama_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'telp_ibu',
            ];

            // Count empty fields
            $emptyFieldsCount = 0;
            foreach ($fields as $field) {
                if (empty($user->$field)) {
                    $emptyFieldsCount++;
                }
            }

            // Calculate profile completeness percentage
            $totalFields = count($fields);
            $filledFieldsCount = $totalFields - $emptyFieldsCount;
            $profileCompletenessPercentage = round(($filledFieldsCount / $totalFields) * 100);

            $students = Student::where('user_id', $user->id)->get();
            // dd($students);

            return view('student.dashboard', [
                'user' => $user,
                'main' => Announcement::where('category', 'main')->first(),
                'announcements' => Announcement::where('category', 'general')->where('program_id', '0')->get(),
                'programs' => $programs,
                'classActive' => Kelas::where('user_id', $user->id)->where('status', 'Aktif')->with('program')->get(),
                'student' => Student::where('user_id', auth()->user()->id)->first(),
                'students' => $students,
                'statusKelas' => $statusKelas,
                'payments' => $payments,
                'activeKelasCount' => Kelas::where('user_id', $user->id)->count(),
                'profileCompletenessPercentage' => $profileCompletenessPercentage,
            ]);
        }
    }

    public function myProgram()
    {
        return view('student.kelas', [
            'kelas' => Kelas::where('user_id', auth()->user()->id)->get(),
            'student' => Student::where('user_id', auth()->user()->id)->first(),
            'students' => Student::where('user_id', Auth::user()->id)->get(),
        ]);
    }

    public function myTransaction()
    {
        return view('student.payment', [
            'payment' => Payment::where('user_id', auth()->user()->id)->orderBy('updated_at', 'DESC')->get(),
            'invoices' => Payment::where('user_id', auth()->user()->id)->where('status', 'PENDING')->get(),
            'student' => Student::where('user_id', auth()->user()->id)->first(),
            'students' => Student::where('user_id', Auth::user()->id)->get(),
        ]);
    }
}
