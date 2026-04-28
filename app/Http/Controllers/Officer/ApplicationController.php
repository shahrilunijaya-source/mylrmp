<?php

namespace App\Http\Controllers\Officer;

use App\Enums\ApplicationStage;
use App\Http\Controllers\Controller;
use App\Models\RegistrationApplication;
use App\Services\ApplicationWorkflow;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Maps workflow action names to the roles permitted to perform them.
     */
    private const ACTION_ROLES = [
        'passIntake'    => ['Pegawai Pendaftaran', 'Super Admin'],
        'failIntake'    => ['Pegawai Pendaftaran', 'Super Admin'],
        'passTechnical' => ['Penilai Teknikal', 'Super Admin'],
        'failTechnical' => ['Penilai Teknikal', 'Super Admin'],
        'passLabel'     => ['Penilai Label', 'Super Admin'],
        'failLabel'     => ['Penilai Label', 'Super Admin'],
        'approveFinal'  => ['Pendaftar', 'Super Admin'],
        'rejectFinal'   => ['Pendaftar', 'Super Admin'],
    ];

    /**
     * Actions that require comments to be present.
     */
    private const REQUIRES_COMMENTS = [
        'failIntake',
        'failTechnical',
        'failLabel',
        'rejectFinal',
    ];

    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $stage  = $request->input('stage', '');
        $stages = ApplicationStage::cases();

        $query = RegistrationApplication::with(['company', 'product', 'category']);

        if ($stage !== '') {
            $query->where('current_stage', $stage);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('application_no', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $applications = $query->latest()->paginate(20)->withQueryString();

        return view('officer.applications.index', compact('applications', 'stages', 'search', 'stage'));
    }

    public function show(RegistrationApplication $application)
    {
        $application->load([
            'company',
            'product.activeIngredients',
            'product.formulationType',
            'category',
            'subcategory',
            'documents',
            'reviews.reviewer',
            'certificate',
        ]);

        $user        = auth()->user();
        $stage       = $application->current_stage;
        $daysElapsed = $application->submitted_at ? (int) $application->submitted_at->diffInDays(now()) : 0;

        $canReview = match ($stage) {
            ApplicationStage::Submitted    => $user->hasAnyRole(['Pegawai Pendaftaran', 'Super Admin']),
            ApplicationStage::TechReview   => $user->hasAnyRole(['Penilai Teknikal', 'Super Admin']),
            ApplicationStage::LabelReview  => $user->hasAnyRole(['Penilai Label', 'Super Admin']),
            ApplicationStage::Decision     => $user->hasAnyRole(['Pendaftar', 'Super Admin']),
            ApplicationStage::NeedsRevision => false,
            default                        => false,
        };

        return view('officer.applications.show', compact('application', 'canReview', 'daysElapsed'));
    }

    public function review(Request $request, RegistrationApplication $application)
    {
        $action = $request->input('action');

        // Validate the action is one we know about
        if (! array_key_exists($action, self::ACTION_ROLES)) {
            return back()->withErrors(['action' => 'Tindakan tidak sah.']);
        }

        // Check role permission
        $user = $request->user();
        $allowedRoles = self::ACTION_ROLES[$action];

        if (! $user->hasAnyRole($allowedRoles)) {
            return back()->withErrors(['action' => 'Anda tidak mempunyai kebenaran untuk melakukan tindakan ini.']);
        }

        // Validate comments when required
        $requiresComments = in_array($action, self::REQUIRES_COMMENTS, true);

        $request->validate([
            'comments' => $requiresComments ? ['required', 'string', 'min:1'] : ['nullable', 'string'],
        ], [
            'comments.required' => 'Komen diperlukan untuk tindakan ini.',
        ]);

        $comments = $request->input('comments', '');

        try {
            $workflow = app(ApplicationWorkflow::class);
            $workflow->{$action}($application, $user, $comments);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['action' => $e->getMessage()]);
        }

        return back()->with('success', 'Tindakan berjaya dilaksanakan.');
    }
}
