<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use App\Models\Stebis;
use Illuminate\Http\Request;

class StebisController extends Controller
{
    public function index()
    {
        $stebis = Stebis::all();
        return view('admin.stebis.index', compact('stebis'));
    }

    public function create()
    {
        return view('admin.stebis.create');
    }

    public function store(Request $request)
    {
        $request['option'] = json_encode($request['option']);

        Stebis::create($request->all());
        return redirect()->route('stebis.index')->with('success', 'Stebis created successfully.');
    }

    // Display the specified resource.
    public function show(Stebis $stebis)
    {
        return view('admin.stebis.show', compact('stebis'));
    }

    // Show the form for editing the specified resource.
    public function edit(Stebis $stebis)
    {
        $allOptions = Sesi::pluck('jadwal')->toArray();

        return view('admin.stebis.edit', compact('stebis', 'allOptions'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, Stebis $stebis)
    {
        $request['option'] = json_encode($request['option']);

        $stebis->update($request->all());
        return redirect()->route('stebis.index')->with('success', 'Stebis updated successfully.');
    }

    public function destroy(Stebis $stebis)
    {
        $stebis->delete();
        return redirect()->route('stebis.index')->with('success', 'Stebis deleted successfully.');
    }
}
