<?php

namespace App\Http\Controllers\Industri;

use App\Enums\ApplicationStage;
use App\Http\Controllers\Controller;
use App\Models\RegistrationApplication;
use Illuminate\Http\Request;

class IndustriDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user      = $request->user();
        $companyId = $user->company_id;

        $baseQuery = RegistrationApplication::where('applicant_company_id', $companyId);

        $total = (clone $baseQuery)->count();

        $pending = (clone $baseQuery)->whereIn('current_stage', [
            ApplicationStage::Draft->value,
            ApplicationStage::Submitted->value,
            ApplicationStage::NeedsRevision->value,
        ])->count();

        $inReview = (clone $baseQuery)->whereIn('current_stage', [
            ApplicationStage::TechReview->value,
            ApplicationStage::LabelReview->value,
            ApplicationStage::Decision->value,
        ])->count();

        $approved = (clone $baseQuery)->where('current_stage', ApplicationStage::Approved->value)->count();
        $rejected = (clone $baseQuery)->where('current_stage', ApplicationStage::Rejected->value)->count();

        $recentApplications = (clone $baseQuery)
            ->with(['product', 'category'])
            ->latest()
            ->take(5)
            ->get();

        return view('industri.dashboard', compact(
            'total',
            'pending',
            'inReview',
            'approved',
            'rejected',
            'recentApplications'
        ));
    }
}
