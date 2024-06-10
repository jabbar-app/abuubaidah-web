<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lecturers = Lecturer::all();
        return view('admin.lecturers.index', compact('lecturers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.lecturers.create', [
            'users' => User::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $lecturer = new Lecturer();
        $lecturer->user_id = $request->user_id;
        $lecturer->save();

        return redirect()->route('lecturers.index')->with('success', 'Lecturer has been added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lecturer $lecturer)
    {
        return view('admin.lecturers.show', compact('lecturer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lecturer $lecturer)
    {
        return view('admin.lecturers.edit', compact('lecturer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lecturer $lecturer)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $lecturer->update([
            'user_id' => $request->user_id
        ]);

        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecturer $lecturer)
    {
        $lecturer->delete();
        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer has been deleted successfully.');
    }
}
