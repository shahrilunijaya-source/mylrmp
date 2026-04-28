<?php

namespace App\Http\Controllers\Industri;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Inspection;

class PemeriksaanController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;

        abort_unless($company, 404);

        $inspections = Inspection::where('target_type', Company::class)
            ->where('target_id', $company->id)
            ->withCount('findings')
            ->orderByDesc('scheduled_for')
            ->paginate(20);

        return view('industri.pemeriksaan.index', compact('inspections', 'company'));
    }

    public function show(Inspection $inspection)
    {
        $company = auth()->user()->company;

        abort_unless(
            $company &&
            $inspection->target_type === Company::class &&
            $inspection->target_id === $company->id,
            403
        );

        $inspection->load([
            'inspector',
            'checklistResponses.item',
            'findings.linkedProduct',
        ]);

        return view('industri.pemeriksaan.show', compact('inspection'));
    }
}
