<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Kelas;
use App\Models\Lughoh;
use App\Models\Payment;
use App\Models\Program;
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
        return view('admin.transcripts.edit', compact('student'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        // Validate the incoming request data
        $request->validate([
            'nim' => 'required|integer',
            'mustawa' => 'nullable|string',
            'nilai_comphre' => 'required|numeric',
        ]);

        // Update the student record
        $student->update([
            'nim' => $request->input('nim'),
            'mustawa' => $request->input('mustawa'),
            'nilai_comphre' => $request->input('nilai_comphre'),
        ]);

        // Redirect to a specific route with a success message
        return redirect()->route('transcripts.index')->with('success', 'Student updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        // Delete related transcripts
        $student->transcripts()->delete();

        // Delete the student
        $student->delete();

        return redirect()->route('transcripts.index')->with('success', 'Data Mahasiswa telah berhasil dihapus!');
    }

    public function editGrades($id)
    {
        $student = Student::with('courses')->findOrFail($id);
        return view('admin.transcripts.assign-grades', compact('student'));
    }

    public function updateGrades(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $grades = $request->input('grades');

        foreach ($grades as $courseId => $grade) {
            $student->courses()->updateExistingPivot($courseId, ['grade' => $grade]);
        }

        return redirect()->route('students.show', $student->id)->with('success', 'Grades assigned successfully!');
    }

    public function assignCoursesForm(Student $student)
    {
        // $student = Student::findOrFail($id);
        // $courses = Course::all();
        // $assignedCourses = $student->courses->pluck('id')->toArray();
        // return view('admin.transcripts.assign', compact('student', 'courses', 'assignedCourses'));
        return view('admin.transcripts.assign', compact('student'));
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
        $lughoh = Lughoh::where('id', $request->lughoh_id)->first();

        // dd($lughoh);
        // Check if the student record already exists
        $students = Student::where('user_id', $user->id)->with('program.programmable')->get();

        foreach ($students as $student) {
            if ($student->program && $student->program->programmable) {
                if ($lughoh->description == $student->program->programmable->description) {
                    return redirect()->route('khs')->withErrors('Sudah terdaftar di Program dan Angkatan yang sama.');
                }
            }
        }

        // Mulai dari NIM yang dihasilkan
        $studentNIM = $lughoh->last_nim;

        // Cek apakah NIM sudah ada
        while (Student::where('nim', $studentNIM)->where('user_id', '!=', $user->id)->exists()) {
            $studentNIM++; // Tambah 1 jika sudah ada
        }

        $lughoh->update(['last_nim' => $studentNIM]);

        // Setelah loop selesai, $studentNIM adalah nilai unik
        // dd($lughoh->last_nim);

        $student = new Student();
        $student->user_id = $user->id;
        $student->program_id = $request->program_id;
        $student->kelas_id = $request->kelas_id;
        $student->nim = $studentNIM;
        $student->save();

        return redirect()->route('khs')->with('success', 'NIM generated: ' . $student->nim);
    }

    public function detailTransaction(Payment $payment)
    {
        return view('student.payments.show', compact('payment'));
    }

    public function khs(Request $request)
    {
        $mustawa = ucwords($request->query('mustawa'));

        if (empty($mustawa)) {
            return redirect()->route('dashboard')->with('info', 'Mohon menunggu Admin melakukan update Mata Kuliah!');
        }

        return $this->khsByMustawa($mustawa);
    }

    public function khsByMustawa($mustawa)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->where('mustawa', $mustawa)->first();
        $transcripts = Transcript::where('student_id', $student->id)->where('mustawa', $mustawa)->get();

        $lowGradeCount = 0;
        foreach ($transcripts as $transcript) {
            if ($transcript->grade < 60) {
                $lowGradeCount++;
            }
        }

        $status = '';
        if (!empty($transcripts->first()->grade)) {
            if ($lowGradeCount > 2) {
                $status = 'Rosib';
            } else {
                $status = 'Naik Mustawa';
            }
        }

        return view('student.khs', [
            'student' => $student,
            'students' => Student::where('user_id', $user->id)->get(),
            'transcripts' => $transcripts,
            'status' => $status,
        ]);
    }
}
