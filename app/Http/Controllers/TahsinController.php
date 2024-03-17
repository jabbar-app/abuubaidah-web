<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use App\Models\Tahsin;
use Illuminate\Http\Request;

class TahsinController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $tahsins = Tahsin::all();
        return view('admin.tahsins.index', compact('tahsins'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('admin.tahsins.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // dd($request->all());
        // $validated = $request->validate([
        //     'batch' => 'required|string',
        //     'title' => 'required|string',
        //     'description' => 'required|string',
        //     'price' => 'required|string',
        //     'price_alumni' => 'required|string',
        //     'status' => 'required|boolean',
        // ]);

        $request['option'] = json_encode($request['option']);

        Tahsin::create($request->all());
        return redirect()->route('tahsins.index')->with('success', 'Tahsin created successfully.');
    }

    // Display the specified resource.
    public function show(Tahsin $tahsin)
    {
        return view('admin.tahsins.show', compact('tahsin'));
    }

    // Show the form for editing the specified resource.
    public function edit(Tahsin $tahsin)
    {
        $allOptions = Sesi::pluck('jadwal')->toArray();

        return view('admin.tahsins.edit', compact('tahsin', 'allOptions'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, Tahsin $tahsin)
    {
        // $request->validate([
        //     'batch' => 'required|string',
        //     'title' => 'required|string',
        //     'option' => 'required|string',
        //     'description' => 'required|string',
        //     'price_normal' => 'required|string',
        //     'price_alumni' => 'required|string',
        //     'status' => 'required|boolean',
        // ]);

        $request['option'] = json_encode($request['option']);

        $tahsin->update($request->all());
        return redirect()->route('tahsins.index')->with('success', 'Tahsin updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy(Tahsin $tahsin)
    {
        $tahsin->delete();
        return redirect()->route('tahsins.index')->with('success', 'Tahsin deleted successfully.');
    }
}
