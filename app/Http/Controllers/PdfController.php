<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
  public function downloadPDF($id)
  {
      $student = Student::find($id);

      if (!$student) {
          abort(404);
      }

      $data = [
          'student' => $student
      ];
      // $pdf = Pdf::loadView('student.certificate.index', $data); // Replace "certificate" with your view file name
      // return $pdf->download('certificate.pdf');
      $pdf=PDF::loadView('student.certificate.index', $data);
      return $pdf->stream('test_pdf.pdf');
  }
  // public function downloadPDF($id)
  // {
  //     $student = Student::find($id);

  //     if (!$student) {
  //         abort(404);
  //     }
  //     $html= view('student.certificate.index', compact('student'));

  //     $dompdf = new Dompdf();
  //     $dompdf->loadHtml($html);
  //     $dompdf->setPaper('A4', 'portrait');
  //     $dompdf->render();
  //     $dompdf->stream("certificate.pdf", array("Attachment" => false));
  // }
}
