<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Program;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::where('user_id', auth()->user()->id)->get();

        return view("student.kelas", compact("kelas"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $program = Program::where("id","=","$id")->first();
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'session' => 'required',
          ]);

          Kelas::create([
            'user_id' => $request->user_id,
            'program_id' => $request->program_id,
            'program' => $request->program,
            'batch' => $request->batch,
            'level' => $request->level,
            'class' => $request->class,
            'session' => json_encode($request->session),
            'status' => 'Menunggu Update',
          ]);

          return redirect()->route('dashboard')->with('success', 'Program berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
