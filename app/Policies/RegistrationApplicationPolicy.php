<?php

namespace App\Policies;

use App\Enums\ApplicationStage;
use App\Models\RegistrationApplication;
use App\Models\User;

class RegistrationApplicationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('applications.view_any') || $user->can('applications.view_own');
    }

    public function view(User $user, RegistrationApplication $application): bool
    {
        if ($user->can('applications.view_any')) {
            return true;
        }

        return $user->can('applications.view_own')
            && $user->company_id === $application->applicant_company_id;
    }

    public function create(User $user): bool
    {
        return $user->can('applications.create');
    }

    public function update(User $user, RegistrationApplication $application): bool
    {
        return $user->can('applications.view_any');
    }

    public function delete(User $user, RegistrationApplication $application): bool
    {
        return false;
    }

    public function submit(User $user, RegistrationApplication $application): bool
    {
        if (! $user->can('applications.submit')) {
            return false;
        }

        if ($user->company_id !== $application->applicant_company_id) {
            return false;
        }

        return in_array($application->current_stage, [
            ApplicationStage::Draft,
            ApplicationStage::NeedsRevision,
        ], true);
    }

    public function reviewIntake(User $user, RegistrationApplication $application): bool
    {
        return $user->can('applications.review_intake')
            && $application->current_stage === ApplicationStage::Submitted;
    }

    public function reviewTechnical(User $user, RegistrationApplication $application): bool
    {
        return $user->can('applications.review_technical')
            && $application->current_stage === ApplicationStage::TechReview;
    }

    public function reviewLabel(User $user, RegistrationApplication $application): bool
    {
        return $user->can('applications.review_label')
            && $application->current_stage === ApplicationStage::LabelReview;
    }

    public function approveFinal(User $user, RegistrationApplication $application): bool
    {
        return $user->can('applications.approve_final')
            && $application->current_stage === ApplicationStage::Decision;
    }

    public function rejectFinal(User $user, RegistrationApplication $application): bool
    {
        return $user->can('applications.reject')
            && $application->current_stage === ApplicationStage::Decision;
    }
}
