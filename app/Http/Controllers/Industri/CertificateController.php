<?php

namespace App\Http\Controllers\Industri;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Services\CertificateGenerator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CertificateController extends Controller
{
    public function download(Certificate $certificate): StreamedResponse
    {
        Gate::authorize('view', $certificate);

        if (! $certificate->pdf_path || ! Storage::disk('local')->exists($certificate->pdf_path)) {
            app(CertificateGenerator::class)->generate($certificate);
            $certificate->refresh();
        }

        return Storage::disk('local')->download(
            $certificate->pdf_path,
            $certificate->registration_no . '.pdf'
        );
    }
}
