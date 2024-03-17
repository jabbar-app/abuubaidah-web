<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Program;
use App\Models\Sesi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
        $program = Program::where("id", "=", "$id")->first();
        $level = '-';
        $alumni = 'Peserta Baru';
        $price = 0;
        if ($alumni == 'Alumni') {
            $price = $program->price_alumni;
        } else {
            $price = $program->price_normal;
        };

        return view('kelas.register', compact('program', 'alumni', 'price', 'level'));
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
}
