<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use App\Models\Lughoh;
use Illuminate\Http\Request;

class LughohController extends Controller
{
    public function index()
    {
        $lughohs = Lughoh::all();
        return view('admin.lughohs.index', compact('lughohs'));
    }

    public function create()
    {
        return view('admin.lughohs.create');
    }

    public function store(Request $request)
    {
        $request['option'] = json_encode($request['option']);

        Lughoh::create($request->all());
        return redirect()->route('lughohs.index')->with('success', 'Lughoh created successfully.');
    }

    // Display the specified resource.
    public function show(Lughoh $lughoh)
    {
        return view('admin.lughohs.show', compact('lughoh'));
    }

    // Show the form for editing the specified resource.
    public function edit(Lughoh $lughoh)
    {
        $allOptions = Sesi::pluck('jadwal')->toArray();

        return view('admin.lughohs.edit', compact('lughoh', 'allOptions'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, Lughoh $lughoh)
    {
        $request['option'] = json_encode($request['option']);

        $lughoh->update($request->all());
        return redirect()->route('lughohs.index')->with('success', 'Lughoh updated successfully.');
    }

    public function destroy(Lughoh $lughoh)
    {
        $lughoh->delete();
        return redirect()->route('lughohs.index')->with('success', 'Lughoh deleted successfully.');
    }
}
