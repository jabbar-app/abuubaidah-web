<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Program; // Make sure to include your Program model at the top
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $announcements = Announcement::with('program')->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        $programs = Program::all(); // Get all programs to select from in the view
        return view('admin.announcements.create', compact('programs'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required',
            'title' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string',
        ]);

        if ($request->category == 'main') {
            $mainAnnouncementExists = Announcement::where('category', 'main')->where('program_id', $request->program_id)->exists();
            if ($mainAnnouncementExists) {
                return back()->withErrors(['category' => 'A main announcement already exists for this program.'])->withInput();
            }
        }

        Announcement::create($request->all());
        return redirect()->route('announcements.index')->with('success', 'Announcement created successfully.');
    }

    // Display the specified resource.
    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }

    // Show the form for editing the specified resource.
    public function edit(Announcement $announcement)
    {
        $programs = Program::all(); // Get all programs to select from in the view
        return view('admin.announcements.edit', compact('announcement', 'programs'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id', // Ensure the program exists
            'title' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string',
        ]);

        if ($request->category == 'main' && $announcement->category != 'main') {
            $mainAnnouncementExists = Announcement::where('category', 'main')->where('program_id', $request->program_id)->where('id', '!=', $announcement->id)->exists();
            if ($mainAnnouncementExists) {
                return back()->withErrors(['category' => 'Another main announcement already exists for this program.'])->withInput();
            }
        }

        $announcement->update($request->all());
        return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'Announcement deleted successfully.');
    }
}
