<?php

namespace App\Services;

use App\Models\Certificate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CertificateGenerator
{
    public function generate(Certificate $certificate): string
    {
        $certificate->load([
            'application.product.activeIngredients',
            'application.company',
            'application.category',
        ]);

        $pdf = Pdf::loadView('pdf.certificate', ['certificate' => $certificate]);

        $filename = 'certificates/' . $certificate->registration_no . '.pdf';

        Storage::disk('local')->put('private/' . $filename, $pdf->output());

        $path = 'private/' . $filename;
        $certificate->update(['pdf_path' => $path]);

        return $path;
    }
}
