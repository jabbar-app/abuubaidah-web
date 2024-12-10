<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Kelas;
use App\Models\Payment;
use App\Models\Program;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Student;
use App\Models\Transcript;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    public function generatePdf($id)
    {
        $student = Student::findOrFail($id);
        $transcripts = Transcript::where('student_id', $student->id)->get();

        $data = [
            'student' => $student,
            'students' => Student::where('user_id', Auth::user()->id)->get(),
            'transcripts' => $transcripts,
        ];

        $pdf = PDF::loadView('admin.exports.transcript', $data);

        return $pdf->download('Transkrip_Nilai_' . $student->nim . '.pdf');
    }

    public function userPdf($id)
    {
        $user = User::findOrFail($id);
        $province = Province::find($user->province);
        $regency = Regency::find($user->regency);
        $district = District::find($user->district);

        $pdf = PDF::loadView('admin.exports.user', [
            'user' => $user,
            'programs' => Kelas::where('user_id', $user->id)->get(),
            'payments' => Payment::where('user_id', $user->id)->get(),
            'provinceName' => $province->name ?? '-',
            'regencyName' => $regency->name ?? '-',
            'districtName' => $district->name ?? '-',
        ]);

        return $pdf->download('Data User - ' . $user->name . '.pdf');
    }

    public function invoicePdf($externalId)
    {
        $invoice = Payment::where('external_id', $externalId)->first();

        if (!$invoice) {
            return redirect()->back()->with('error', 'Invoice not found.');
        }

        $user = User::where('id', $invoice->user_id)->first();

        $pdf = PDF::loadView('student.invoice', compact('invoice', 'user'));
        return $pdf->download('invoice_' . $invoice->external_id . '.pdf');
    }

    public function certificatePdf($id)
    {
        $kelas = Kelas::where('id', $id)->first();
        $program = Program::where("id", $kelas->program_id)->first();

        $pdf = PDF::loadView('admin.exports.certificate', compact('kelas', 'program'));
        return $pdf->download('Hasil Belajar - ' . $kelas->title . '.pdf');
    }
}
