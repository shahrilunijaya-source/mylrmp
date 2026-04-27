<?php

namespace App\Http\Controllers\Industri;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CertificateController extends Controller
{
    public function download(Certificate $certificate): StreamedResponse
    {
        Gate::authorize('view', $certificate);

        if (! $certificate->pdf_path || ! Storage::disk('private')->exists($certificate->pdf_path)) {
            abort(404, 'Fail sijil tidak ditemui. Sila hubungi pihak pentadbiran.');
        }

        $filename = 'Sijil-' . $certificate->registration_no . '.pdf';

        return Storage::disk('private')->download($certificate->pdf_path, $filename);
    }
}
