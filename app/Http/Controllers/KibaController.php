<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use App\Models\Kiba;
use Illuminate\Http\Request;

class KibaController extends Controller
{
    public function index()
    {
        $kibas = Kiba::all();
        return view('admin.kibas.index', compact('kibas'));
    }

    public function create()
    {
        return view('admin.kibas.create');
    }

    public function store(Request $request)
    {
        $request['option'] = json_encode($request['option']);

        Kiba::create($request->all());
        return redirect()->route('kibas.index')->with('success', 'Kiba created successfully.');
    }

    // Display the specified resource.
    public function show(Kiba $kiba)
    {
        return view('admin.kibas.show', compact('kiba'));
    }

    // Show the form for editing the specified resource.
    public function edit(Kiba $kiba)
    {
        $allOptions = Sesi::pluck('jadwal')->toArray();

        return view('admin.kibas.edit', compact('kiba', 'allOptions'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, Kiba $kiba)
    {
        $request['option'] = json_encode($request['option']);

        $kiba->update($request->all());
        return redirect()->route('kibas.index')->with('success', 'Kiba updated successfully.');
    }

    public function destroy(Kiba $kiba)
    {
        $kiba->delete();
        return redirect()->route('kibas.index')->with('success', 'Kiba deleted successfully.');
    }
}
