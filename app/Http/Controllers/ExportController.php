<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Kelas; // Use your model
use App\Models\Payment;
use App\Models\User;
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
        $sheet->setCellValue('K1', 'Status Peserta');
        $sheet->setCellValue('L1', 'Status Pembayaran');
        $sheet->setCellValue('M1', 'Status Kelas');
        $sheet->setCellValue('N1', 'Link WhatsApp');
        // Add more headers as needed

        $kelasData = Kelas::where('program_id', $id)->get();
        $row = 2; // Start from the second row
        foreach ($kelasData as $kelas) {
            foreach ($kelas->payments as $payment) {
                $statusPayment = $payment->status;
            }
            $statusPeserta = $kelas->is_new ? 'Peserta Baru' : 'Daftar Ulang';

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
            $sheet->setCellValue('K' . $row, $statusPeserta);
            $sheet->setCellValue('L' . $row, $statusPayment);
            $sheet->setCellValue('M' . $row, $kelas->status ?? '');
            $sheet->setCellValue('N' . $row, $kelas->link_whatsapp ?? '');
            // Fill in more data as needed
            $row++;
        }

        // Write file to a temporary file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Kelas - Mahad Abu Ubaidah.xlsx';
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
        $sheet->setCellValue('E1', 'Status Peserta');
        $sheet->setCellValue('F1', 'Status Pembayaran');
        $sheet->setCellValue('G1', 'Status Kelas');

        $kelasData = Kelas::where('program_id', $id)->get();
        $row = 2;
        $statusPeserta = '';
        foreach ($kelasData as $kelas) {
            foreach ($kelas->payments as $payment) {
                $statusPayment = $payment->status;
            }
            if ($kelas->is_new) {
                $statusPeserta = 'Peserta Baru';
            } else {
                $statusPeserta = 'Daftar Ulang';
            }
            $sheet->setCellValue('A' . $row, $kelas->id);
            $sheet->setCellValue('B' . $row, $kelas->user->name ?? '');
            $sheet->setCellValue('C' . $row, $kelas->user->phone ?? '');
            $sheet->setCellValue('D' . $row, $kelas->user->gender ?? '');
            $sheet->setCellValue('E' . $row, $statusPeserta);
            $sheet->setCellValue('F' . $row, $statusPayment);
            $sheet->setCellValue('G' . $row, $kelas->status ?? '');
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'kelas_lughoh.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        return response()->download($temp_file, $fileName, ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])->deleteFileAfterSend(true);
    }

    public function exportKelasAll(): BinaryFileResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // dd($id, $batch, $gelombang);

        // Define the headers for the spreadsheet
        $headers = [
            'A' => 'NIK', 'B' => 'Nama', 'C' => 'Email', 'D' => 'WhatsApp',
            'E' => 'Program', 'F' => 'Angkatan', 'G' => 'Gelombang',
            'H' => 'Tipe Kelas', 'I' => 'Status Peserta', 'J' => 'Status Pembayaran', 'K' => 'Status Kelas',
        ];

        // Set the headers in the first row of the sheet
        foreach ($headers as $column => $header) {
            $sheet->setCellValue($column . '1', $header);
        }

        // Retrieve all users (assumption: User model includes necessary relationships)
        $kelasData = Kelas::all();

        $row = 2;
        foreach ($kelasData as $kelas) {
            foreach ($kelas->payments as $payment) {
                $statusPayment = $payment->status;
            }
            if ($kelas->is_new) {
                $statusPeserta = 'Peserta Baru';
            } else {
                $statusPeserta = 'Daftar Ulang';
            }
            // dd($kelas->user->nik);
            // Populate the row with kelas data
            $sheet->setCellValue('A' . $row, $kelas->user->nik ?? '');
            $sheet->setCellValue('B' . $row, $kelas->user->name ?? '');
            $sheet->setCellValue('C' . $row, $kelas->user->email ?? '');
            $sheet->setCellValue('D' . $row, $kelas->user->phone ?? '');
            $sheet->setCellValue('E' . $row, $kelas->program);
            $sheet->setCellValue('F' . $row, $kelas->batch);
            $sheet->setCellValue('G' . $row, $kelas->gelombang);
            $sheet->setCellValue('H' . $row, $kelas->class);
            $sheet->setCellValue('I' . $row, $statusPeserta);
            $sheet->setCellValue('J' . $row, $statusPayment);
            $sheet->setCellValue('K' . $row, $kelas->status);
            $row++;
        }

        // Write the file to a temporary location
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Kelas - Mahad Abu Ubaidah.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        // Return the file as a download response
        return response()->download($temp_file, $fileName, ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])->deleteFileAfterSend(true);
    }

    public function exportKelas($id, $batch, $gelombang): BinaryFileResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // dd($id, $batch, $gelombang);

        // Define the headers for the spreadsheet
        $headers = [
            'A' => 'NIK', 'B' => 'Nama', 'C' => 'Email', 'D' => 'WhatsApp',
            'E' => 'Program', 'F' => 'Angkatan', 'G' => 'Gelombang',
            'H' => 'Tipe Kelas', 'I' => 'Status Peserta', 'J' => 'Status Pembayaran', 'K' => 'Status Kelas',
        ];

        // Set the headers in the first row of the sheet
        foreach ($headers as $column => $header) {
            $sheet->setCellValue($column . '1', $header);
        }

        // Retrieve all users (assumption: User model includes necessary relationships)
        if (empty($gelombang)) {
            $kelasData = Kelas::where('program_id', $id)->where('batch', $batch)->get();
        } else {
            $kelasData = Kelas::where('program_id', $id)->where('batch', $batch)->where('gelombang', $gelombang)->get();
        }


        $row = 2;
        foreach ($kelasData as $kelas) {
            foreach ($kelas->payments as $payment) {
                $statusPayment = $payment->status;
            }
            if ($kelas->is_new) {
                $statusPeserta = 'Peserta Baru';
            } else {
                $statusPeserta = 'Daftar Ulang';
            }
            // dd($kelas->user->nik);
            // Populate the row with kelas data
            $sheet->setCellValue('A' . $row, $kelas->user->nik ?? '');
            $sheet->setCellValue('B' . $row, $kelas->user->name ?? '');
            $sheet->setCellValue('C' . $row, $kelas->user->email ?? '');
            $sheet->setCellValue('D' . $row, $kelas->user->phone ?? '');
            $sheet->setCellValue('E' . $row, $kelas->program);
            $sheet->setCellValue('F' . $row, $kelas->batch);
            $sheet->setCellValue('G' . $row, $kelas->gelombang);
            $sheet->setCellValue('H' . $row, $kelas->class);
            $sheet->setCellValue('I' . $row, $statusPeserta);
            $sheet->setCellValue('J' . $row, $statusPayment);
            $sheet->setCellValue('K' . $row, $kelas->status);
            $row++;
        }

        // Write the file to a temporary location
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Kelas - Mahad Abu Ubaidah.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        // Return the file as a download response
        return response()->download($temp_file, $fileName, ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])->deleteFileAfterSend(true);
    }

    public function exportUser(): BinaryFileResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Define the headers for the spreadsheet
        $headers = [
            'A' => 'NIK', 'B' => 'Nama', 'C' => 'Email', 'D' => 'WhatsApp',
            'E' => 'Gender', 'F' => 'Tempat Lahir', 'G' => 'Tanggal Lahir',
            'H' => 'Berat Badan', 'I' => 'Tinggi Badan', 'J' => 'Status Pernikahan',
            'K' => 'Agama', 'L' => 'Suku', 'M' => 'Alamat',
            'N' => 'Ukuran Almamater', 'O' => 'Nama SD', 'P' => 'Lulus SD',
            'Q' => 'Nama SMP', 'R' => 'Lulus SMP', 'S' => 'Nama SMA',
            'T' => 'Lulus SMA', 'U' => 'Perguruan Tinggi', 'V' => 'Nama Ayah',
            'W' => 'Status Ayah', 'X' => 'Pekerjaan Ayah', 'Y' => 'Penghasilan Ayah',
            'Z' => 'Telepon Ayah', 'AA' => 'Nama Ibu', 'AB' => 'Status Ibu',
            'AC' => 'Pekerjaan Ibu', 'AD' => 'Penghasilan Ibu', 'AE' => 'Telepon Ibu'
        ];

        // Set the headers in the first row of the sheet
        foreach ($headers as $column => $header) {
            $sheet->setCellValue($column . '1', $header);
        }

        // Retrieve all users (assumption: User model includes necessary relationships)
        $userData = User::all();
        $row = 2;
        foreach ($userData as $user) {
            // Populate the row with user data
            $sheet->setCellValue('A' . $row, $user->nik);
            $sheet->setCellValue('B' . $row, $user->name);
            $sheet->setCellValue('C' . $row, $user->email);
            $sheet->setCellValue('D' . $row, $user->phone);
            $sheet->setCellValue('E' . $row, $user->gender);
            $sheet->setCellValue('F' . $row, $user->tempat_lahir);
            $sheet->setCellValue('G' . $row, $user->tanggal_lahir);
            $sheet->setCellValue('H' . $row, $user->berat_badan);
            $sheet->setCellValue('I' . $row, $user->tinggi_badan);
            $sheet->setCellValue('J' . $row, $user->status_perkawinan);
            $sheet->setCellValue('K' . $row, $user->agama);
            $sheet->setCellValue('L' . $row, $user->suku);
            $sheet->setCellValue('M' . $row, $user->address);
            $sheet->setCellValue('N' . $row, $user->ukuran_almamater);
            $sheet->setCellValue('O' . $row, $user->nama_sd);
            $sheet->setCellValue('P' . $row, $user->lulus_sd);
            $sheet->setCellValue('Q' . $row, $user->nama_smp);
            $sheet->setCellValue('R' . $row, $user->lulus_smp);
            $sheet->setCellValue('S' . $row, $user->nama_sma);
            $sheet->setCellValue('T' . $row, $user->lulus_sma);
            $sheet->setCellValue('U' . $row, $user->perguruan_tinggi);
            $sheet->setCellValue('V' . $row, $user->nama_ayah);
            $sheet->setCellValue('W' . $row, $user->status_ayah);
            $sheet->setCellValue('X' . $row, $user->pekerjaan_ayah);
            $sheet->setCellValue('Y' . $row, $user->penghasilan_ayah);
            $sheet->setCellValue('Z' . $row, $user->telp_ayah);
            $sheet->setCellValue('AA' . $row, $user->nama_ibu);
            $sheet->setCellValue('AB' . $row, $user->status_ibu);
            $sheet->setCellValue('AC' . $row, $user->pekerjaan_ibu);
            $sheet->setCellValue('AD' . $row, $user->penghasilan_ibu);
            $sheet->setCellValue('AE' . $row, $user->telp_ibu);

            $row++;
        }

        // Write the file to a temporary location
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data User - Mahad Abu Ubaidah.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        // Return the file as a download response
        return response()->download($temp_file, $fileName, ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])->deleteFileAfterSend(true);
    }

    public function exportPayment(): BinaryFileResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Define the headers for the spreadsheet
        $headers = [
            'A' => 'No. Invoice',
            'B' => 'Nama user',
            'C' => 'Email',
            'D' => 'WhatsApp',
            'E' => 'Jumlah',
            'F' => 'Deskripsi',
            'G' => 'Metode',
            'H' => 'Status',
            'I' => 'Catatan',
        ];

        // Set the headers in the first row of the sheet
        foreach ($headers as $column => $header) {
            $sheet->setCellValue($column . '1', $header);
        }

        // Retrieve all users (assumption: User model includes necessary relationships)
        $paymentData = Payment::all();
        $row = 2;
        foreach ($paymentData as $payment) {
            // Populate the row with payment data
            $sheet->setCellValue('A' . $row, $payment->external_id);
            $sheet->setCellValue('B' . $row, $payment->payer_name);
            $sheet->setCellValue('C' . $row, $payment->payer_email);
            $sheet->setCellValue('D' . $row, $payment->user->phone ?? '');
            $sheet->setCellValue('E' . $row, $payment->amount);
            $sheet->setCellValue('F' . $row, $payment->description);
            $sheet->setCellValue('G' . $row, $payment->method);
            $sheet->setCellValue('H' . $row, $payment->status);
            $sheet->setCellValue('I' . $row, $payment->note);

            $row++;
        }

        // Write the file to a temporary location
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Transaksi - Mahad Abu Ubaidah.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        // Return the file as a download response
        return response()->download($temp_file, $fileName, ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])->deleteFileAfterSend(true);
    }

    public function exportPaymentData($id, $batch, $gelombang): BinaryFileResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Define the headers for the spreadsheet
        $headers = [
            'A' => 'No. Invoice',
            'B' => 'Nama user',
            'C' => 'Email',
            'D' => 'WhatsApp',
            'E' => 'Jumlah',
            'F' => 'Deskripsi',
            'G' => 'Metode',
            'H' => 'Status',
            'I' => 'Catatan',
        ];

        // Set the headers in the first row of the sheet
        foreach ($headers as $column => $header) {
            $sheet->setCellValue($column . '1', $header);
        }

        // Retrieve payment data based on the given parameters
        $paymentQuery = Payment::query();

        if (!empty($id)) {
            $paymentQuery->where('program_id', $id);
        }

        if (!empty($batch)) {
            $paymentQuery->where('batch', $batch);
        }

        if (!empty($gelombang)) {
            $paymentQuery->where('gelombang', $gelombang);
        }

        $paymentData = $paymentQuery->get();

        $row = 2;
        foreach ($paymentData as $payment) {
            // Populate the row with payment data
            $sheet->setCellValue('A' . $row, $payment->external_id);
            $sheet->setCellValue('B' . $row, $payment->payer_name);
            $sheet->setCellValue('C' . $row, $payment->payer_email);
            $sheet->setCellValue('D' . $row, $payment->user->phone ?? '');
            $sheet->setCellValue('E' . $row, $payment->amount);
            $sheet->setCellValue('F' . $row, $payment->description);
            $sheet->setCellValue('G' . $row, $payment->method);
            $sheet->setCellValue('H' . $row, $payment->status);
            $sheet->setCellValue('I' . $row, $payment->note);

            $row++;
        }

        // Write the file to a temporary location
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Transaksi - Mahad Abu Ubaidah.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        // Return the file as a download response
        return response()->download($temp_file, $fileName, ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])->deleteFileAfterSend(true);
    }
}
