<?php

namespace App\Http\Controllers\Officer;

use App\Enums\ApplicationStage;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Product;
use App\Models\RegistrationApplication;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingCount = RegistrationApplication::whereIn('current_stage', [
            ApplicationStage::Submitted->value,
            ApplicationStage::TechReview->value,
            ApplicationStage::LabelReview->value,
            ApplicationStage::Decision->value,
            ApplicationStage::NeedsRevision->value,
        ])->count();

        $approvedThisMonth = RegistrationApplication::where('current_stage', ApplicationStage::Approved->value)
            ->where('decided_at', '>=', Carbon::now()->startOfMonth())
            ->count();

        $rejectedCount = RegistrationApplication::where('current_stage', ApplicationStage::Rejected->value)->count();

        $activeProducts = Product::where('status', 'active')->count();

        $recentApplications = RegistrationApplication::with(['company', 'product', 'category'])
            ->latest()
            ->limit(8)
            ->get();

        $stageBreakdown = [];
        foreach (ApplicationStage::cases() as $stage) {
            $stageBreakdown[$stage->value] = RegistrationApplication::where('current_stage', $stage->value)->count();
        }

        $companiesCount = Company::count();
        $usersCount     = User::count();
        $totalApps      = RegistrationApplication::count();

        return view('officer.dashboard', compact(
            'pendingCount',
            'approvedThisMonth',
            'rejectedCount',
            'activeProducts',
            'recentApplications',
            'stageBreakdown',
            'companiesCount',
            'usersCount',
            'totalApps'
        ));
    }
}
