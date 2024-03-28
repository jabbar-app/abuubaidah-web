<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Kelas; // Use your model
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    public function exportExcel($id): BinaryFileResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Setting headers
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'WhatsApp');
        $sheet->setCellValue('D1', 'Gender');
        $sheet->setCellValue('E1', 'Tipe Kelas');
        $sheet->setCellValue('F1', 'Sesi');
        $sheet->setCellValue('G1', 'Level');
        $sheet->setCellValue('H1', 'Ruang Kelas');
        $sheet->setCellValue('I1', 'Nilai');
        $sheet->setCellValue('J1', 'Ustadz/ah');
        $sheet->setCellValue('K1', 'Status');
        // Add more headers as needed

        $kelasData = Kelas::where('program_id', $id)->get();
        $row = 2; // Start from the second row
        foreach ($kelasData as $kelas) {
            $sheet->setCellValue('A' . $row, $kelas->id);
            $sheet->setCellValue('B' . $row, $kelas->user->name ?? '');
            $sheet->setCellValue('C' . $row, $kelas->user->phone ?? '');
            $sheet->setCellValue('D' . $row, $kelas->user->gender ?? '');
            $sheet->setCellValue('E' . $row, $kelas->class ?? '');
            $sheet->setCellValue('F' . $row, $kelas->session ?? '');
            $sheet->setCellValue('G' . $row, $kelas->level ?? '');
            $sheet->setCellValue('H' . $row, $kelas->room ?? '');
            $sheet->setCellValue('I' . $row, $kelas->score ?? '');
            $sheet->setCellValue('J' . $row, $kelas->lecturer ?? '');
            $sheet->setCellValue('K' . $row, $kelas->status ?? '');
            // Fill in more data as needed
            $row++;
        }

        // Write file to a temporary file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'kelas_data.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        // Return download response
        return response()->download($temp_file, $fileName, ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])->deleteFileAfterSend(true);
    }

    public function exportLughoh($id): BinaryFileResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'WhatsApp');
        $sheet->setCellValue('D1', 'Gender');
        $sheet->setCellValue('E1', 'Status');

        $kelasData = Kelas::where('program_id', $id)->get();
        $row = 2;
        foreach ($kelasData as $kelas) {
            $sheet->setCellValue('A' . $row, $kelas->id);
            $sheet->setCellValue('B' . $row, $kelas->user->name ?? '');
            $sheet->setCellValue('C' . $row, $kelas->user->phone ?? '');
            $sheet->setCellValue('D' . $row, $kelas->user->gender ?? '');
            $sheet->setCellValue('E' . $row, $kelas->status ?? '');
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'kelas_lughoh.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        return response()->download($temp_file, $fileName, ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])->deleteFileAfterSend(true);
    }
}
