<?php

namespace App\Services;

use App\Enums\InspectionStatus;
use App\Models\Inspection;
use App\Models\User;

class InspectionWorkflow
{
    public function start(Inspection $inspection, User $by): void
    {
        $this->assertStatus($inspection, InspectionStatus::Scheduled);

        $inspection->status       = InspectionStatus::InProgress;
        $inspection->conducted_at = now();
        $inspection->save();

        activity()->causedBy($by)->performedOn($inspection)->log('start');
    }

    public function concludeCompliant(Inspection $inspection, User $by, string $summary): void
    {
        $this->assertStatus($inspection, InspectionStatus::InProgress);

        $inspection->status  = InspectionStatus::Compliant;
        $inspection->summary = $summary;
        $inspection->save();

        $reportPath = app(InspectionReportGenerator::class)->generateReport($inspection);
        $inspection->update(['report_pdf_path' => $reportPath]);

        activity()->causedBy($by)->performedOn($inspection)->log('concludeCompliant');
    }

    public function concludeWithFindings(
        Inspection $inspection,
        User $by,
        string $summary,
        InspectionStatus $severity,
        \Carbon\Carbon $deadline
    ): void {
        $this->assertStatus($inspection, InspectionStatus::InProgress);

        if (! $severity->requiresNotice()) {
            throw new \RuntimeException("Status [{$severity->value}] does not require a notice.");
        }

        $inspection->status          = $severity;
        $inspection->summary         = $summary;
        $inspection->notice_deadline = $deadline;
        $inspection->save();

        $reportPath = app(InspectionReportGenerator::class)->generateReport($inspection);
        $noticePath = app(InspectionReportGenerator::class)->generateNotice($inspection);

        $inspection->update([
            'report_pdf_path' => $reportPath,
            'notice_pdf_path' => $noticePath,
        ]);

        activity()->causedBy($by)->performedOn($inspection)->log('concludeWithFindings');
    }

    public function cancel(Inspection $inspection, User $by, string $reason = ''): void
    {
        if ($inspection->status->isTerminal()) {
            throw new \RuntimeException("Cannot cancel an inspection that is already [{$inspection->status->value}].");
        }

        $inspection->status  = InspectionStatus::Cancelled;
        $inspection->summary = $reason;
        $inspection->save();

        activity()->causedBy($by)->performedOn($inspection)->log('cancel');
    }

    private function assertStatus(Inspection $inspection, InspectionStatus $expected): void
    {
        if ($inspection->status !== $expected) {
            throw new \RuntimeException(
                "Cannot perform this action: inspection is [{$inspection->status->value}], expected [{$expected->value}]."
            );
        }
    }
}
