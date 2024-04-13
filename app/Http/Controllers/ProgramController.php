<?php

namespace App\Http\Controllers;

use App\Models\Bilhaq;
use App\Models\Fai;
use App\Models\Kelas;
use App\Models\Kiba;
use App\Models\Lughoh;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Stebis;
use App\Models\Tahfiz;
use App\Models\Tahsin;
use Exception;
use Illuminate\Support\Facades\Log;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::all();
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.create', [
            'tahsins' => Tahsin::where('status', 1)->get(),
            'tahfizs' => Tahfiz::where('status', 1)->get(),
            'bilhaqs' => Bilhaq::where('status', 1)->get(),
            'kiba' => Kiba::where('status', 1)->get(),
            'lughoh' => Lughoh::where('status', 1)->get(),
            'fai' => Fai::where('status', 1)->get(),
            'stebis' => Stebis::where('status', 1)->get(),
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());

        // $messages = [
        //   'price.required' => 'Wajib diisi',
        // ];

        // $validatedData = $request->validate([
        //   'program_type' => 'required|string',
        //   'programmable_id' => 'required|integer',
        //   'price_pra' => 'numeric',
        //   'price_normal' => 'numeric',
        //   'price_alumni' => 'numeric',
        //   'price_normal' => 'numeric',
        //   'price_mahad' => 'numeric',
        //   'price_s1' => 'numeric',
        //   'deadline' => 'date',
        //   'status' => 'required|boolean',
        // ], $messages);

        try {
            Program::create($request->all());
            return redirect()->route('programs.index')->with('success', 'Program created successfully.');
        } catch (Exception $e) {
            // Log the error
            Log::error('Program creation failed: ' . $e->getMessage());
            // Redirect back with an error message
            return back()->withInput()->withErrors(['msg' => 'Failed to create the program. Please try again.']);
        }
    }



    public function show(Program $program)
    {
        return view('admin.programs.show', compact('program'));
    }

    public function edit(Program $program)
    {
        return view('admin.programs.edit', [
            'program' => $program,
            'tahsins' => Tahsin::where('status', 1)->get(),
            'tahfizs' => Tahfiz::where('status', 1)->get(),
            'bilhaqs' => Bilhaq::where('status', 1)->get(),
            'kiba' => Kiba::where('status', 1)->get(),
            'lughoh' => Lughoh::where('status', 1)->get(),
            'fai' => Fai::where('status', 1)->get(),
            'stebis' => Stebis::where('status', 1)->get(),
        ]);
    }

    public function update(Request $request, Program $program)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'program_type' => 'required|string',
            'programmable_id' => 'required|integer',
            'price_pra' => 'numeric',
            'price_normal' => 'numeric',
            'price_alumni' => 'numeric',
            'price_normal' => 'numeric',
            'price_mahad' => 'numeric',
            'price_s1' => 'numeric',
            'deadline' => 'date',
            'status' => 'required|boolean',
            // Add validation for other fields if necessary
        ]);

        $program->update($validatedData);
        return redirect()->route('programs.index')->with('success', 'Program updated successfully.');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('programs.index')->with('success', 'Program deleted successfully.');
    }

    public function getAngkatan($programId)
    {
        $angkatans = Kelas::where('program_id', $programId)
            ->get()
            ->unique('batch')
            ->values();

        return response()->json($angkatans->map(function ($angkatan) {
            return [
                'id' => $angkatan->id,
                'batchName' => $angkatan->batch
            ];
        }));
    }

    public function getGelombang($batch)
    {
        $gelombang = Kelas::where('batch', $batch)
            ->get()
            ->unique('gelombang')
            ->values();

        // Preparing the data to be sent back to the frontend
        return response()->json($gelombang->map(function ($gelombang) {
            return [
                'gelombang' => $gelombang->gelombang
            ];
        }));
    }
}
