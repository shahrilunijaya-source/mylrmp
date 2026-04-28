<?php

namespace App\Services;

use App\Models\Inspection;

class InspectionNumberAllocator
{
    public function allocate(Inspection $inspection): string
    {
        $year     = now()->year;
        $sequence = Inspection::count();

        $no = sprintf('PMK/%d/%05d', $year, $sequence);

        $inspection->update(['inspection_no' => $no]);

        return $no;
    }
}
