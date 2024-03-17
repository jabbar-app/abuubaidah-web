<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use App\Models\Fai;
use Illuminate\Http\Request;

class FaiController extends Controller
{
    public function index()
    {
        $fais = Fai::all();
        return view('admin.fais.index', compact('fais'));
    }

    public function create()
    {
        return view('admin.fais.create');
    }

    public function store(Request $request)
    {
        $request['option'] = json_encode($request['option']);

        Fai::create($request->all());
        return redirect()->route('fais.index')->with('success', 'Fai created successfully.');
    }

    // Display the specified resource.
    public function show(Fai $fai)
    {
        return view('admin.fais.show', compact('fai'));
    }

    // Show the form for editing the specified resource.
    public function edit(Fai $fai)
    {
        $allOptions = Sesi::pluck('jadwal')->toArray();

        return view('admin.fais.edit', compact('fai', 'allOptions'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, Fai $fai)
    {
        $request['option'] = json_encode($request['option']);

        $fai->update($request->all());
        return redirect()->route('fais.index')->with('success', 'Fai updated successfully.');
    }

    public function destroy(Fai $fai)
    {
        $fai->delete();
        return redirect()->route('fais.index')->with('success', 'Fai deleted successfully.');
    }
}
