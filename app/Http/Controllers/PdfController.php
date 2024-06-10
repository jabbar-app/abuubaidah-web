<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PdfController extends Controller
{
    public function generatePdf()
    {
        // Prepare data for the view
        $data = [
            'student' => [
                'user' => ['name' => 'Thomas Shelby'],
                'nim' => '12345678',
                'program' => ['programmable' => ['title' => 'Mathematics']]
            ]
        ];

        // Load the view and pass the data
        $pdf = PDF::loadView('student.khs', $data);

        // Stream the PDF back to the browser
        return $pdf->stream('KHS.pdf');
    }
}
