<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = Result::all();
        return view('admin.results.index', compact('results'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.results.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Result::create($request->all());
        return redirect()->route('results.index')->with('success', 'Result added successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(Result $result)
    {
        return view('admin.results.show', compact('result'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Result $result)
    {
        return view('admin.results.edit', compact('result'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Result $result)
    {
        $result->update($request->all());
        return redirect()->route('results.index')->with('success', 'Result updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Result $result)
    {
        $result->delete();
        return back()->with('success', 'Result deleted successfully');
    }
}
