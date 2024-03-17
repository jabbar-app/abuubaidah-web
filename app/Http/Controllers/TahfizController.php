<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use App\Models\Tahfiz;
use Illuminate\Http\Request;

class TahfizController extends Controller
{
    public function index()
    {
        $tahfizs = Tahfiz::all();
        return view('admin.tahfizs.index', compact('tahfizs'));
    }

    public function create()
    {
        return view('admin.tahfizs.create');
    }

    public function store(Request $request)
    {
        $request['option'] = json_encode($request['option']);

        Tahfiz::create($request->all());
        return redirect()->route('tahfizs.index')->with('success', 'Tahfiz created successfully.');
    }

    // Display the specified resource.
    public function show(Tahfiz $tahfiz)
    {
        return view('admin.tahfizs.show', compact('tahfiz'));
    }

    // Show the form for editing the specified resource.
    public function edit(Tahfiz $tahfiz)
    {
        $allOptions = Sesi::pluck('jadwal')->toArray();

        return view('admin.tahfizs.edit', compact('tahfiz', 'allOptions'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, Tahfiz $tahfiz)
    {
        $request['option'] = json_encode($request['option']);

        $tahfiz->update($request->all());
        return redirect()->route('tahfizs.index')->with('success', 'Tahfiz updated successfully.');
    }

    public function destroy(Tahfiz $tahfiz)
    {
        $tahfiz->delete();
        return redirect()->route('tahfizs.index')->with('success', 'Tahfiz deleted successfully.');
    }
}
