<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Result;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportController extends Controller
{
    public function importExcel(Request $request)
    {
        $file = $request->file('excel_file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach ($data as $rowIndex => $row) {
            if ($rowIndex === 0) continue; // Skip header

            // Assuming the first column is ID
            $kelas = Kelas::find($row[0]);
            if ($kelas) {
                // Update Kelas fields, ignore user-related fields
                // Example: Update 'class', 'session', 'level', 'room', 'status' of Kelas
                // Ensure these fields are fillable in your Kelas model

                $kelas->class = $row[4] ?? $kelas->class; // Assuming 'E' column is 'Tipe Kelas'
                $kelas->session = $row[5] ?? $kelas->session; // Assuming 'F' column is 'Sesi'
                $kelas->level = $row[6] ?? $kelas->level; // Assuming 'G' column is 'Level'
                $kelas->room = $row[7] ?? $kelas->room; // Assuming 'H' column is 'Ruang Kelas'
                $kelas->score = $row[8] ?? $kelas->score;
                $kelas->lecturer = $row[9] ?? $kelas->lecturer;
                $kelas->status = $row[10] ?? $kelas->status; // Assuming 'I' column is 'Status'

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
}
