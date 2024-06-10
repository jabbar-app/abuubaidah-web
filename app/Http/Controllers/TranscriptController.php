<?php

namespace App\Http\Controllers;

use App\Models\Transcript;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class TranscriptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.transcripts.index', [
            'students' => Student::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        $courses = Course::all();
        return view('admin.transcripts.create', compact('students', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'grade' => 'required'
        ]);

        Transcript::create($request->all());
        return redirect()->route('transcripts.index')->with('success', 'Transcript added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transcript $transcript)
    {
        return 'hai';
        return view('admin.transcripts.show', [
            'transcripts' => Transcript::where('user_id', $transcript->user_id)->get(),
            'transcript' => $transcript,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transcript $transcript)
    {
        $students = Student::all();
        $courses = Course::all();
        return view('admin.transcripts.edit', compact('transcript', 'students', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transcript $transcript)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'grade' => 'required'
        ]);

        $transcript->update($request->all());
        return redirect()->route('transcripts.index')->with('success', 'Transcript updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transcript $transcript)
    {
        $transcript->delete();
        return redirect()->route('transcripts.index')->with('success', 'Transcript deleted successfully.');
    }

    public function showGradesForm($studentId)
    {
        $student = Student::with(['courses'])->findOrFail($studentId);
        $transcripts = Transcript::where('student_id', $studentId)->get()->keyBy('course_id');
        return view('admin.transcripts.grades', compact('student', 'transcripts'));
    }

    public function storeGrades(Request $request, $studentId)
    {
        $grades = $request->grades; // grades is an associative array course_id => grade

        foreach ($grades as $courseId => $grade) {
            Transcript::updateOrCreate(
                ['student_id' => $studentId, 'course_id' => $courseId],
                ['grade' => $grade]
            );
        }

        return redirect()->route('students.show', $studentId)->with('success', 'Grades updated successfully.');
    }
}
