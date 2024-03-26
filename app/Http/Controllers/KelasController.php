<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Result;
use App\Models\Tahsin;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class KelasController extends Controller
{
  public function adminIndex()
  {
    return view('admin.kelas.index', [
      'kelas' => Kelas::all(),
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
    } else {
      return redirect()->back();
    }
  }

  public function tahsin(Program $program)
  {
    // dd($program->programmable->price_alumni);

    $isAlumniResult = Result::where('program', 'TAHSIN')->where('phone', Auth::user()->phone)->first();
    $isAlumni = $isAlumniResult !== null;
    $alumni = $isAlumni ? 'Alumni' : 'Peserta Baru';
    $price = $isAlumni ? $program->programmable->price_alumni : $program->programmable->price_normal;
    $level = $isAlumni ? $isAlumniResult->next : 'TAMHIDY';

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

    Kelas::create([
      'user_id' => $request->user_id,
      'program_id' => $request->program_id,
      'program' => $program->programmable->title,
      'batch' => $program->programmable->batch,
      'level' => '',
      'class' => '',
      'room' => '',
      'score' => '',
      'lecturer' => '',
      'session' => '',
      'status' => 'Menunggu Update',
    ]);

    return redirect()->route('my.program')->with('success', 'Pendaftaran program berhasil!');
  }

  public function kiba(Program $program)
  {
    $isAlumniResult = Result::where('program', 'KIBA')->where('phone', Auth::user()->phone)->first();
    $isAlumni = $isAlumniResult !== null;
    $alumni = $isAlumni ? 'Alumni' : 'Peserta Baru';
    $price = $isAlumni ? $program->programmable->price_alumni : $program->programmable->price_normal;
    $level = $isAlumni ? $isAlumniResult->level : '-';

    return view('student.kelas.kiba', compact('program', 'alumni', 'price', 'level'));
  }

  public function bilhaq(Program $program)
  {
    return view('student.kelas.bilhaq', ['program' => $program]);
  }

  public function lughoh(Program $program)
  {
    $isAlumniResult = Result::where('phone', Auth::user()->phone)->first();
    $isAlumni = $isAlumniResult !== null;
    $alumni = $isAlumni ? 'Alumni' : 'Peserta Baru';
    $price = $isAlumni ? $program->price_alumni : $program->price_normal;
    $level = $isAlumni ? $isAlumniResult->level : 'TAMHIDY';

    return view('student.kelas.lughoh', compact('program', 'alumni', 'price', 'level'));
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
      'programs' => Program::where('status', 1)->get(),
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
    $query = $request->input('phone');
    $results = Result::where('program', $program)->where('phone', $query)->get();

    return view('student.result', [
      'results' => $results,
      'program' => strtolower($program),
    ]);
  }
}
