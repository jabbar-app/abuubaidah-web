<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Transcript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Transient;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('admin.transcripts.show', [
            'transcripts' => Transcript::where('student_id', $student->id)->get(),
            'student' => $student,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }

    public function assignCoursesForm($id)
    {
        $student = Student::findOrFail($id);
        $courses = Course::all();
        $assignedCourses = $student->courses->pluck('id')->toArray();
        return view('admin.transcripts.assign', compact('student', 'courses', 'assignedCourses'));
    }

    public function assignCourses(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->courses()->sync($request->courses);
        return redirect()->route('transcripts.index')->with('success', 'Courses assigned successfully.');
    }


    public function generateNIM(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $programId = $request->program_id; // Set the correct program ID

        // Check if the student record already exists
        $existingStudent = Student::where('user_id', $user->id)
            ->where('program_id', $programId)
            ->first();

        if ($existingStudent) {
            return redirect()->route('khs')->withErrors('A student record already exists for this user and program.');
        }

        // If no record exists, create a new one
        $student = new Student();
        $student->user_id = $user->id;
        $student->program_id = $programId;
        $student->kelas_id = $request->kelas_id;
        $student->nim = $student->generateNIM(); // Implement the generateNIM method in Student model
        $student->save();

        return redirect()->route('khs')->with('success', 'NIM generated: ' . $student->nim);
    }

    public function khs()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        return view('student.khs', [
            'student' => $student,
            'transcripts' => Transcript::where('student_id', $student->id)->get(),
        ]);
    }
}
