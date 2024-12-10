<?php

namespace App\Http\Controllers;

use App\Models\Transcript;
use App\Models\Student;
use App\Models\Course;
use App\Models\Kelas;
use App\Models\MustawaAwwal;
use App\Models\MustawaRobi;
use App\Models\MustawaTamhidy;
use App\Models\MustawaTsalits;
use App\Models\MustawaTsani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\StudentT;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TranscriptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nim = Kelas::where('user_id', Auth::user()->id)->where('program_id', 13)->first();
        return view('admin.transcripts.index', [
            'students' => Student::all(),
            'nim' => $nim,
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
        return view('admin.transcripts.show', [
            'transcripts' => Transcript::where('user_id', $transcript->user_id)->get(),
            'transcript' => $transcript,
        ]);
    }

    public function mustawa()
    {
        return view('admin.transcripts.mustawa', [
            'tamhidies' => MustawaTamhidy::all(),
            'awwals' => MustawaAwwal::all(),
            'tsanis' => MustawaTsani::all(),
            'tsalits' => MustawaTsalits::all(),
            'robis' => MustawaRobi::all(),
        ]);
    }

    public function exportMustawa($mustawa): BinaryFileResponse
    {
        $transcripts = Transcript::where('mustawa', ucfirst($mustawa))->get();

        // dd($transcripts);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Define the headers
        $headers = [
            'A' => 'No.',
            'B' => 'Nama Mahasiswa',
            'C' => 'NIM',
            'D' => 'Kode',
            'E' => 'Mata Kuliah',
            'F' => 'SKS',
            'G' => 'Nilai',
            'H' => 'Kode UMSU',
            'I' => 'Mata Kuliah UMSU',
            'J' => 'Kode STEBIS',
            'K' => 'Mata Kuliah STEBIS',
        ];

        // Set the headers in the first row
        foreach ($headers as $column => $header) {
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;
        $count = 1;

        $modelClass = $this->getMustawaModel($mustawa);

        foreach ($transcripts as $transcript) {
            $course = $modelClass::where('id', $transcript->course_id)->first();

            $sheet->setCellValue('A' . $row, $count);
            $sheet->setCellValue('B' . $row, $transcript->student->user->name ?? '-');
            $sheet->setCellValue('C' . $row, $transcript->student->nim ?? '-');
            $sheet->setCellValue('D' . $row, $course->kode_mk);
            $sheet->setCellValue('E' . $row, $course->mk);
            $sheet->setCellValue('F' . $row, $course->sks);
            $sheet->setCellValue('G' . $row, $transcript->grade);
            $sheet->setCellValue('H' . $row, $course->umsu_kode);
            $sheet->setCellValue('I' . $row, $course->umsu_mk);
            $sheet->setCellValue('J' . $row, $course->stebis_kode);
            $sheet->setCellValue('K' . $row, $course->stebis_mk);

            $row++;
            $count++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Mustawa_' . ucfirst($mustawa) . '.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        return response()->download($temp_file, $fileName, ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])->deleteFileAfterSend(true);
    }

    public function importMustawa(Request $request, $mustawa)
    {
        $file = $request->file('file');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getPathname());
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $modelClass = $this->getMustawaModel($mustawa);

        foreach ($sheetData as $index => $row) {
            if ($index == 0) {
                continue; // Skip header row
            }

            $student = Student::where('nim', $row[2])->first();
            $course = $modelClass::where('kode_mk', $row[3])->first();

            // Check if student or course is null
            if (!$student) {
                Log::warning("Student not found with NIM: {$row[2]}. Skipping row.");
                continue; // Skip this row if the student is not found
            }

            if (!$course) {
                Log::warning("Course not found with kode_mk: {$row[3]}. Skipping row.");
                continue; // Skip this row if the course is not found
            }

            // Update or create the transcript record
            Transcript::updateOrCreate(
                [
                    'student_id' => $student->id, // Assuming student_id can be derived from NIM
                    'course_id' => $course->id,  // Assuming course_id can be derived from course title
                    'mustawa' => ucfirst($mustawa),
                ],
                [
                    'grade' => $row[6],
                ]
            );
        }

        return redirect()->back()->with('success', 'Data imported successfully');
    }


    protected function getMustawaModel($mustawa)
    {
        $mustawaModelMap = [
            'robi' => MustawaRobi::class,
            'tamhidy' => MustawaTamhidy::class,
            'awwal' => MustawaAwwal::class,
            'tsani' => MustawaTsani::class,
            'tsalits' => MustawaTsalits::class,
        ];

        $modelClass = $mustawaModelMap[strtolower($mustawa)] ?? null;

        if ($modelClass === null) {
            throw new \Exception("Invalid mustawa type");
        }

        return $modelClass;
    }

    public function edit($id)
    {
        $transcript = Transcript::findOrFail($id);
        return view('admin.transcripts.edit', compact('transcript'));
    }

    public function update(Request $request, $id)
    {
        $transcript = Transcript::findOrFail($id);
        $transcript->update($request->only('grade'));

        return redirect()->route('transcripts.index')->with('success', 'Grade updated successfully');
    }

    public function bulkUpdate(Request $request)
    {
        $data = $request->input('transcripts', []);

        foreach ($data as $id => $grade) {
            $transcript = Transcript::find($id);
            if ($transcript) {
                $transcript->update(['grade' => $grade]);
            }
        }

        return redirect()->route('transcripts.index')->with('success', 'Grades updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transcript $transcript)
    {
        $transcript->delete();
        return redirect()->route('transcripts.index')->with('success', 'Transcript deleted successfully.');
    }

    public function showKHS(Student $student)
    {
        $transcripts = Transcript::where('student_id', $student->id)->get();
        $mustawa = $transcripts->first()->mustawa;
        // dd($mustawa);

        $lowGradeCount = 0;
        foreach ($transcripts as $transcript) {
            if ($transcript->grade < 60) {
                $lowGradeCount++;
            }
        }

        $status = '';
        if (!empty($transcripts->first()->grade)) {
            if (($mustawa == 'Robi' && $lowGradeCount > 4) || ($mustawa != 'Robi' && $lowGradeCount > 2)) {
                $status = 'Rosib';
            } else {
                $status = 'Naik Mustawa';
            }
        }

        return view('admin.transcripts.khs', [
            'student' => $student,
            'transcripts' => $transcripts,
            'status' => $status,
        ]);
    }

    public function transcripts(Student $student)
    {
        return view('admin.transcripts.transcript', [
            'student' => $student,
            'students' => Student::where('user_id', Auth::user()->id)->get(),
            'transcripts' => Transcript::where('student_id', $student->id)->get(),
        ]);
    }
}
