<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Kiba;
use App\Models\Nim;
use App\Models\Payment;
use App\Models\Result;
use App\Models\Tahsin;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\XenditSdkException;

class KelasController extends Controller
{
    protected $invoiceApi;

    public function __construct(InvoiceApi $invoiceApi)
    {
        // Configuration::setXenditKey(config('xendit.secret_key'));
        Configuration::setXenditKey(config('xendit.test_key'));

        // Instansiasi InvoiceApi
        $this->invoiceApi = $invoiceApi;
    }

    public function adminIndex()
    {
        $programs = Program::all()->unique('programmable.title');

        return view('admin.kelas.index', [
            'kelas' => Kelas::with('payments')->get(),
            'programs' => $programs,
            'program_id' => 0,
        ]);
    }



    public function kelasFilter(Request $request)
    {
        $kelas = Kelas::where('program_id', $request->program_id);
        if (!empty($request->batch)) {
            $kelas->where('batch', $request->batch);
        }
        if (!empty($request->gelombang)) {
            $kelas->where('gelombang', $request->gelombang);
        }
        $kelas = $kelas->get();

        return view('admin.kelas.index', [
            'kelas' => $kelas,
            'new' => Kelas::where('program_id', $request->program_id)->where('is_new', 1)->count(),
            'renewed' => Kelas::where('program_id', $request->program_id)->where('is_new', 0)->count(),
            'programs' => Program::all(),
            'program' => Program::where('id', $request->program_id)->first(),
            'program_id' => $request->program_id,
            'batch' => $request->batch,
            'gelombang' => $request->gelombang,
        ]);
    }


    public function index()
    {
        $kelas = Kelas::where('user_id', auth()->user()->id)->get();

        return view("student.kelas", compact("kelas"));
    }

    public function create()
    {
        return view('admin.kelas.create', [
            'users' => User::where('nik', '>', 100)->get(),
            'programs' => Program::where('status', 1)->get(),
            'allOptions' => Sesi::pluck('jadwal')->toArray(),
        ]);
    }

    public function register($id)
    {
        $program = Program::where("id", $id)->first();

        if (!$program) {
            return redirect()->back()->with('error', 'Program not found.');
        }

        $kelas = Kelas::where('user_id', auth()->user()->id)->where('program_id', $program->id)->first();

        if (!empty($kelas) && $kelas->status == 'Menunggu Update') {
            return redirect()->route('dashboard');
        }

        if ($program->programmable_type === 'App\Models\Tahsin') {
            return $this->tahsin($program);
        } else if ($program->programmable_type === 'App\Models\Tahfiz') {
            return $this->tahfiz($program);
        } else if ($program->programmable_type === 'App\Models\Kiba') {
            return $this->kiba($program);
        } else if ($program->programmable_type === 'App\Models\Bilhaq') {
            return $this->bilhaq($program);
        } else if ($program->programmable_type === 'App\Models\Lughoh') {
            return $this->lughoh($program);
        } else if ($program->programmable_type === 'App\Models\Fai') {
            return $this->fai($program);
        } else if ($program->programmable_type === 'App\Models\Stebis') {
            return $this->stebis($program);
        } else {
            return redirect()->back();
        }
    }

    public function tahsin(Program $program)
    {
        $tahsins = Program::where('programmable_type', 'App\Models\Tahsin')->get();
        $kelasAll = Kelas::where('user_id', Auth::user()->id)->get();
        $isAlumni = false;
        $level = '-';

        foreach ($tahsins as $tahsin) {
            foreach ($kelasAll as $kelas) {
                if ($tahsin->id == $kelas->program_id && $kelas->status == 'Selesai') {
                    $isAlumni = true;
                    $level = $kelas->next;
                    break;
                }
            }
        }

        $alumni = $isAlumni ? 'Alumni' : 'Peserta Baru';
        $price = $isAlumni ? $program->programmable->price_alumni : $program->programmable->price_normal;

        return view('student.kelas.tahsin', compact('program', 'alumni', 'price', 'level'));
    }

    public function tahfiz(Program $program)
    {
        $status = User::where('id', auth()->user()->id)->first();

        return view('student.kelas.tahfiz', [
            'user' => auth()->user(),
            'program' => $program,
            'status' => $status,
        ]);
    }

    public function daftarTahfiz(Program $program, Request $request)
    {
        $user = auth()->user();
        $program = Program::where('id', $request->program_id)->first();

        if ($request->hasFile('url_bilhaq')) {
            $bilhaq = $request->file('url_bilhaq')->store('upload-image', 'public');
            if ($user->url_bilhaq) {
                Storage::disk('public')->delete($user->url_bilhaq);
            }

            $user->update([
                'url_bilhaq' => $bilhaq,
            ]);
        }

        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => 'INV_' . time(),
            'payer_id' => $user->id,
            'payer_name' => $user->name,
            'payer_email' => $user->email,
            'description' => 'Pembayaran untuk #' . $program->programmable->title,
            'amount' => $request->amount,
            'invoice_duration' => 172800,
            'currency' => 'IDR',
            'reminder_time' => 1,
        ]);

        // dd($create_invoice_request);

        try {
            $result = $this->invoiceApi->createInvoice($create_invoice_request);

            // Create a new instance of Kelas and store the returned instance in a variable
            $kelas = Kelas::create([
                'user_id' => $request->user_id,
                'program_id' => $request->program_id,
                'program' => $program->programmable->title,
                'batch' => $program->programmable->batch,
                'bilhaq' => $request->hasBilhaqCert,
                'status' => 'Menunggu Update',
                'is_new' => $request->is_new,
            ]);

            Payment::create([
                'program_id' => $request->program_id,
                'kelas_id' => $kelas->id,
                'external_id' => $create_invoice_request['external_id'],
                'user_id' => $user->id,
                'payer_name' => $user->name,
                'payer_email' => $user->email,
                'description' => $create_invoice_request['description'],
                'amount' => $create_invoice_request['amount'],
                'payment_type' => $request->type,
                'invoice_url' => $result->getInvoiceUrl(),
                'status' => 'PENDING',
            ]);

            return redirect()->route('my.program')->with('success', 'Pendaftaran program berhasil!');
        } catch (XenditSdkException $e) {
            // Menangani eksepsi dan menampilkan pesan kesalahan
            return response()->json([
                'error' => $e->getMessage(),
                'full_error' => $e->getFullError(),
            ], 500);
        }
    }

    public function daftarBilhaq($program)
    {
        $program = Program::where('programmable_type', $program)->where('status', 1)->first();
        return $this->bilhaq($program);
    }

    public function kiba(Program $program)
    {
        $kibas = Program::where('programmable_type', 'App\Models\Kiba')->get();
        $kelasAll = Kelas::where('user_id', Auth::user()->id)->get();
        $isAlumni = false;
        $level = '-';

        foreach ($kibas as $kiba) {
            foreach ($kelasAll as $kelas) {
                if ($kiba->id == $kelas->program_id) {
                    $isAlumni = true;
                    $level = $kelas->next;
                    break;
                }
            }
        }

        $alumni = $isAlumni ? 'Alumni' : 'Peserta Baru';
        $price = $isAlumni ? $program->programmable->price_alumni : $program->programmable->price_normal;
        return view('student.kelas.kiba', compact('program', 'alumni', 'price', 'level'));
    }

    public function bilhaq(Program $program)
    {
        return view('student.kelas.bilhaq', ['program' => $program]);
    }

    public function lughoh(Program $program)
    {
        return view('student.kelas.lughoh', [
            'program' => $program,
            'step' => Kelas::where('user_id', auth()->user()->id)->where('program_id', $program->id)->first(),
            'status' => User::where('id', auth()->user()->id)->first(),
            'student' => Student::where('user_id', auth()->user()->id)->first(),
            'students' => Student::where('user_id', Auth::user()->id)->get(),
        ]);
    }

    public function fai(Program $program)
    {
        $step = Kelas::where('user_id', auth()->user()->id)->where('program_id', $program->id)->first();
        return view('student.kelas.fai', [
            'program' => $program,
            'step' => $step,
            'status' => User::where('id', auth()->user()->id)->first(),
            'student' => Student::where('user_id', auth()->user()->id)->first(),
            'students' => Student::where('user_id', Auth::user()->id)->get(),
        ]);
    }

    public function stebis(Program $program)
    {
        return view('student.kelas.stebis', [
            'program' => $program,
            'step' => Kelas::where('user_id', auth()->user()->id)->where('program_id', $program->id)->first() ?? '',
            'status' => User::where('id', auth()->user()->id)->first(),
            'student' => Student::where('user_id', auth()->user()->id)->first(),
            'students' => Student::where('user_id', Auth::user()->id)->get(),
        ]);
    }

    public function detailKelas($id)
    {
        $kelas = Kelas::where('id', $id)->first();
        $program = Program::where("id", $kelas->program_id)->first();

        return view('admin-program.detail', [
            'kelas' => $kelas,
            'program' => $program,
        ]);
    }

    public function detail($id)
    {
        $kelas = Kelas::where('id', $id)->first();
        $program = Program::where("id", $kelas->program_id)->first();

        if ($kelas->program->programmable_type == 'App\Models\Fai' || $kelas->program->programmable_type == 'App\Models\Stebis') {
            $lughoh = Program::where('programmable_type', 'App\Models\Lughoh')->where('status', 1)->first();
            $isRegisteredLughoh = Kelas::where('user_id', Auth::user()->id)->where('program_id', $lughoh->id)->first();
            if (empty($isRegisteredLughoh)) {
                $payment = Payment::where('kelas_id', $kelas->id)->first();
                // dd($payment);
                $create_kelas = Kelas::create([
                    'user_id' => Auth::user()->id,
                    'program_id' => $lughoh->id,
                    'title' => $lughoh->programmable->title,
                    'batch' => $lughoh->programmable->batch,
                    'level' => '',
                    'class' => '',
                    'room' => '',
                    'score' => '',
                    'lecturer' => '',
                    'session' => '',
                    'status' => 'Aktif',
                    'is_new' => false,
                ]);

                Payment::create([
                    'program_id' => $lughoh->id,
                    'kelas_id' => $create_kelas->id,
                    'external_id' => $payment->external_id,
                    'user_id' => $payment->user_id,
                    'payer_name' => $payment->payer_name,
                    'payer_email' => $payment->payer_email,
                    'description' => 'Pembayaran untuk #Program Bahasa Arab & Studi Islam, Angkatan #' . $lughoh->programmable->batch . ' Jenis Pembayaran #Daftar Ulang Program Integrasi',
                    'type' => 'Daftar Ulang',
                    'amount' => $payment->amount,
                    'method' => $payment->method,
                    'invoice_url' => $payment->invoice_url,
                    'status' => $payment->status,
                ]);

                return redirect()->route('my.program');
            }
        }

        return view('student.kelas.detail', [
            'kelas' => $kelas,
            'program' => $program,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'session' => 'required',
        ]);

        $level = 'TAMHIDY';

        if ($request->level != '') {
            $level = $request->level;
        }

        Kelas::create([
            'user_id' => $request->user_id,
            'program_id' => $request->program_id,
            'program' => $request->program,
            'batch' => $request->batch,
            'level' => $level,
            'class' => $request->class,
            'session' => json_encode($request->session),
            'status' => 'Menunggu Update',
            'is_new' => $request->is_new,
        ]);

        return redirect()->route('dashboard')->with('success', 'Program berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('admin.kelas.show', compact('kelas'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('admin.kelas.edit', [
            'kelas' => $kelas,
            'users' => User::where('nik', '>', 100)->get(),
            'programs' => Program::all(),
            'allOptions' => Sesi::pluck('jadwal')->toArray(),
        ]);
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $request['session'] = json_encode($request['session']);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Data kelas telah berhasil diperbaharui.');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return Redirect::back()->with('success', 'Data kelas telah dihapus.');
    }

    public function pengumumanIndex()
    {
        return view('student.result', [
            'results' => '',
            'program' => '',
        ]);
    }
    public function pengumuman($program)
    {
        return view('student.result', [
            'results' => '',
            'program' => $program,
        ]);
    }

    public function search(Request $request)
    {
        $program = strtoupper($request->program);
        if (empty($request->phone)) {
            $results = Result::where('program', $program)->where('nim', $request->input('nim'))->get();
        } else {
            $results = Result::where('program', $program)->where('phone', $request->input('phone'))->get();
        }

        // dd($results);


        return view('student.result', [
            'results' => $results,
            'program' => strtolower($program),
        ]);
    }

    public function checkNim(Request $request)
    {
        $nim = $request->input('nim');
        $nimRecord = Nim::where('nim', $nim)->first();

        if ($nimRecord) {
            return response()->json([
                'status' => 'valid',
                'name' => $nimRecord->name,
                'is_registered' => $nimRecord->is_registered
            ]);
        } else {
            return response()->json(['status' => 'invalid']);
        }
    }

    public function tahsinView(Request $request)
    {
        return $this->getKelasByProgram('App\Models\Tahsin', 'admin.kelas.tahsin', $request);
    }

    public function bilhaqView(Request $request)
    {
        return $this->getKelasByProgram('App\Models\Bilhaq', 'admin.kelas.bilhaq', $request);
    }

    public function tahfizView(Request $request)
    {
        return $this->getKelasByProgram('App\Models\Tahfiz', 'admin.kelas.tahfiz', $request);
    }

    public function lughohView(Request $request)
    {
        return $this->getKelasByProgram('App\Models\Lughoh', 'admin.kelas.lughoh', $request);
    }

    public function kibaView(Request $request)
    {
        return $this->getKelasByProgram('App\Models\Kiba', 'admin.kelas.kiba', $request);
    }

    public function faiView(Request $request)
    {
        return $this->getKelasByProgram('App\Models\Fai', 'admin.kelas.fai', $request);
    }

    public function stebisView(Request $request)
    {
        return $this->getKelasByProgram('App\Models\Stebis', 'admin.kelas.stebis', $request);
    }

    private function getKelasByProgram($programmableType, $viewName, Request $request)
    {
        $batch = $request->input('batch');
        $gelombang = $request->input('gelombang');

        // Retrieve the program based on programmable type
        $program = Program::where('programmable_type', $programmableType)->first();
        $programId = $program ? $program->id : null;

        $programsQuery = Program::where('programmable_type', $programmableType)
            ->when($batch, function ($query, $batch) {
                return $query->whereHas('programmable', function ($q) use ($batch) {
                    $q->where('batch', $batch);
                });
            });

        $batches = Program::where('programmable_type', $programmableType)
            ->with('programmable')
            ->get()
            ->pluck('programmable.batch')
            ->unique()
            ->values();

        $programs = $programsQuery->get();
        $allKelas = collect();

        foreach ($programs as $program) {
            $kelasQuery = Kelas::where('program_id', $program->id);

            if (!empty($batch)) {
                $kelasQuery->where('batch', $batch);
            }

            if (!empty($gelombang)) {
                $kelasQuery->where('gelombang', $gelombang);
            }

            $kelas = $kelasQuery->get();
            $allKelas = $allKelas->merge($kelas);
        }

        $newCountQuery = Kelas::where('program_id', $programId)->where('is_new', 1);
        $renewedCountQuery = Kelas::where('program_id', $programId)->where('is_new', 0);

        if (!empty($batch)) {
            $newCountQuery->where('batch', $batch);
            $renewedCountQuery->where('batch', $batch);
        }

        if (!empty($gelombang)) {
            $newCountQuery->where('gelombang', $gelombang);
            $renewedCountQuery->where('gelombang', $gelombang);
        }

        $newCount = $newCountQuery->count();
        $renewedCount = $renewedCountQuery->count();
        $totalCount = Kelas::where('program_id', $programId)->count();
        $programsList = Program::all();

        return view($viewName, [
            'kelas' => $allKelas,
            'new' => $newCount,
            'renewed' => $renewedCount,
            'total' => $totalCount,
            'programs' => $programsList,
            'program' => $program,
            'program_id' => $programId,
            'batches' => $batches,
            'selectedBatch' => $batch,
            'gelombang' => $gelombang,
            'programmableType' => $programmableType,
        ]);
    }
}
