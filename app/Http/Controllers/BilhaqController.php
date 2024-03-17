<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use App\Models\Bilhaq;
use Illuminate\Http\Request;

class BilhaqController extends Controller
{
    public function index()
    {
        $bilhaqs = Bilhaq::all();
        return view('admin.bilhaqs.index', compact('bilhaqs'));
    }

    public function create()
    {
        return view('admin.bilhaqs.create');
    }

    public function store(Request $request)
    {
        $request['option'] = json_encode($request['option']);

        Bilhaq::create($request->all());
        return redirect()->route('bilhaqs.index')->with('success', 'Bilhaq created successfully.');
    }

    // Display the specified resource.
    public function show(Bilhaq $bilhaq)
    {
        return view('admin.bilhaqs.show', compact('bilhaq'));
    }

    // Show the form for editing the specified resource.
    public function edit(Bilhaq $bilhaq)
    {
        $allOptions = Sesi::pluck('jadwal')->toArray();

        return view('admin.bilhaqs.edit', compact('bilhaq', 'allOptions'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, Bilhaq $bilhaq)
    {
        $request['option'] = json_encode($request['option']);

        $bilhaq->update($request->all());
        return redirect()->route('bilhaqs.index')->with('success', 'Bilhaq updated successfully.');
    }

    public function destroy(Bilhaq $bilhaq)
    {
        $bilhaq->delete();
        return redirect()->route('bilhaqs.index')->with('success', 'Bilhaq deleted successfully.');
    }
}
