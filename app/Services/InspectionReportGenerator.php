<?php

namespace App\Services;

use App\Models\Inspection;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InspectionReportGenerator
{
    public function generateReport(Inspection $inspection): string
    {
        $inspection->load([
            'target',
            'inspector',
            'checklistResponses.item',
            'findings.linkedProduct',
            'findings.attachments',
        ]);

        $pdf      = Pdf::loadView('pdf.inspection-report', compact('inspection'));
        $filename = 'private/inspections/reports/' . $inspection->inspection_no . '.pdf';

        Storage::disk('local')->put($filename, $pdf->output());

        return $filename;
    }

    public function generateNotice(Inspection $inspection): string
    {
        $inspection->load(['target', 'inspector', 'findings']);

        $pdf      = Pdf::loadView('pdf.inspection-notice', compact('inspection'));
        $filename = 'private/inspections/notices/' . $inspection->inspection_no . '.pdf';

        Storage::disk('local')->put($filename, $pdf->output());

        return $filename;
    }
}
