<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Nim;
use App\Models\Program;
use App\Models\Result;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportController extends Controller
{
    public function showImportForm()
    {
        return view('admin.transcripts.import');
    }

    public function importStudents(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rowLimit = $sheet->getHighestDataRow();
        $columnLimit = $sheet->getHighestDataColumn();

        DB::beginTransaction();
        try {
            for ($row = 2; $row <= $rowLimit; $row++) {
                $nim = $sheet->getCell('A' . $row)->getValue();
                $name = $sheet->getCell('B' . $row)->getValue();
                $programTitle = $sheet->getCell('C' . $row)->getValue();
                $mustawa = $sheet->getCell('D' . $row)->getValue();
                $batch = $sheet->getCell('E' . $row)->getValue();
                $nilai_comphre = $sheet->getCell('F' . $row)->getValue();

                // dd($nilai_comphre);

                $user = User::firstOrCreate(['name' => $name]);
                // $program = Program::firstOrCreate(['title' => $programTitle, 'batch' => $batch]);

                Student::updateOrCreate(
                    ['nim' => $nim],
                    ['user_id' => $user->id, 'mustawa' => $mustawa, 'nilai_comphre' => $nilai_comphre]
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transcripts.index')->with('danger', 'Failed to import data: ' . $e->getMessage());
        }

        return redirect()->route('transcripts.index')->with('success', 'Data imported successfully!');
    }

    public function importDataStudents(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rowLimit = $sheet->getHighestDataRow();

        DB::beginTransaction();
        try {
            for ($row = 2; $row <= $rowLimit; $row++) {
                $nim = $sheet->getCell('A' . $row)->getValue();
                $name = $sheet->getCell('B' . $row)->getValue();
                $programTitle = $sheet->getCell('C' . $row)->getValue();
                $mustawa = $sheet->getCell('D' . $row)->getValue();
                $angkatan = $sheet->getCell('E' . $row)->getValue();
                $nilai_comphre = $sheet->getCell('F' . $row)->getValue();

                // Find or create the user
                $user = User::where('name', $name)->first();

                if (!$user) {
                    Log::error("User not found for name: {$name} (NIM: {$nim}). Skipping row.");
                    continue; // Skip to the next row if user is not found
                }

                // Find the kelas_id based on the user_id
                $kelas = Kelas::where('user_id', $user->id)->first();
                $kelas_id = $kelas ? $kelas->id : null;

                if (!$kelas_id) {
                    // Log a message indicating that kelas_id is missing
                    Log::warning("Kelas ID is missing for user_id: {$user->id}, NIM: {$nim}. Skipping student creation for this entry.");
                    continue; // Skip to the next row if kelas_id is not found
                }

                // Prepare the data for the student creation
                $studentData = [
                    'user_id' => $user->id,
                    'program_id' => 17,
                    'kelas_id' => $kelas_id,
                    'nim' => $nim,
                    'mustawa' => $mustawa,
                    'nilai_comphre' => $nilai_comphre,
                ];

                // Create the student record
                Student::create($studentData);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transcripts.index')->with('danger', 'Failed to import data: ' . $e->getMessage());
        }

        return redirect()->route('transcripts.index')->with('success', 'Data imported successfully!');
    }



    public function synchronizeStudents()
    {
        $students = Student::whereNotNull('mustawa')->get();

        DB::beginTransaction();
        try {
            foreach ($students as $student) {
                $student->assignCourses();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transcripts.index')->with('danger', 'Failed to synchronize data: ' . $e->getMessage());
        }

        return redirect()->route('transcripts.index')->with('success', 'Courses synchronized successfully!');
    }


    public function importExcel(Request $request)
    {
        $file = $request->file('excel_file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach ($data as $rowIndex => $row) {
            // dd($row);
            if ($rowIndex === 0) continue; // Skip header

            // Assuming the first column is ID
            $kelas = Kelas::find($row[0]);
            if ($kelas) {
                // dd($row[12]);
                // Update Kelas fields, ignore user-related fields
                // $kelas->class = $row[4] ?? $kelas->class; // Assuming 'E' column is 'Tipe Kelas'
                $kelas->batch = $row[5] ?? $kelas->batch;
                $kelas->level = $row[6] ?? $kelas->level;
                $kelas->next = $row[7] ?? $kelas->next;
                $kelas->session = $row[8] ?? $kelas->session;
                $kelas->class = $row[9] ?? $kelas->class;
                $kelas->room = $row[10] ?? $kelas->room;
                $kelas->score = $row[11] ?? $kelas->score;
                $kelas->lecturer = $row[12] ?? $kelas->lecturer;
                $kelas->status = $row[14] ?? $kelas->status;
                $kelas->link_whatsapp = $row[16] ?? $kelas->link_whatsapp; // Assuming 'N' column is 'Link WhatsApp'

                $kelas->save();
            }
        }

        return back()->with('success', 'Data telah berhasil diperbaharui.');
    }

    public function importResult(Request $request)
    {
        $file = $request->file('excel_file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $data = $spreadsheet->getActiveSheet()->toArray();


        // dd($data);

        foreach ($data as $rowIndex => $row) {
            if ($rowIndex === 0) continue;
            $result = new Result();

            $result->name = $row[1] ?? null;
            $result->nik = $row[2] ?? null;
            $result->email = $row[3] ?? null;
            $result->password = $row[4] ?? null;
            $result->gender = $row[5] ?? null;
            $result->phone = $row[6] ?? null;
            $result->program = $row[7] ?? null;
            $result->batch = $row[8] ?? null;
            $result->level = $row[9] ?? null;
            $result->session = $row[10] ?? null;
            $result->class = $row[11] ?? null;
            $result->score = $row[12] ?? null;
            $result->next = $row[13] ?? null;
            $result->lecturer = $row[14] ?? null;
            $result->save();
        }

        return back()->with('success', 'Data telah berhasil diupload.');
    }

    public function uploadNims(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('excel_file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach ($data as $rowIndex => $row) {
            if ($rowIndex === 0) continue; // Skip header

            Nim::updateOrCreate(
                ['nim' => $row[0]],
                [
                    'name' => $row[1],
                    'is_registered' => isset($row[2]) ? (bool)$row[2] : false,
                ]
            );
        }

        return back()->with('success', 'NIMs uploaded successfully.');
    }

    public function dataNims()
    {
        return response()->json(Nim::all());
    }

    public function resetNims()
    {
        Nim::truncate();
        return response()->json(['message' => 'All data deleted successfully.']);
    }
}
