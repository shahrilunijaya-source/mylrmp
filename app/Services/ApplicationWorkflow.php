<?php

namespace App\Services;

use App\Enums\ApplicationDecision;
use App\Enums\ApplicationStage;
use App\Models\ApplicationReview;
use App\Models\RegistrationApplication;
use App\Models\User;

class ApplicationWorkflow
{
    // -------------------------------------------------------------------------
    // Public transition methods
    // -------------------------------------------------------------------------

    public function submit(RegistrationApplication $app, User $by): void
    {
        $this->assertStage($app, ApplicationStage::Draft);

        $app->current_stage = ApplicationStage::Submitted;
        $app->submitted_at  = now();

        $this->createReview($app, $by, ApplicationStage::Submitted, ApplicationDecision::Pending);
        $app->save();

        activity()->causedBy($by)->performedOn($app)->log('submit');
    }

    public function passIntake(RegistrationApplication $app, User $by, string $comments = ''): void
    {
        $this->assertStage($app, ApplicationStage::Submitted);

        $app->current_stage = ApplicationStage::TechReview;

        $this->createReview($app, $by, ApplicationStage::Submitted, ApplicationDecision::Approved, $comments);
        $app->save();

        activity()->causedBy($by)->performedOn($app)->log('passIntake');
    }

    public function failIntake(RegistrationApplication $app, User $by, string $comments): void
    {
        $this->assertStage($app, ApplicationStage::Submitted);

        $app->current_stage = ApplicationStage::NeedsRevision;

        $this->createReview($app, $by, ApplicationStage::Submitted, ApplicationDecision::NeedsRevision, $comments);
        $app->save();

        activity()->causedBy($by)->performedOn($app)->log('failIntake');
    }

    public function passTechnical(RegistrationApplication $app, User $by, string $comments = ''): void
    {
        $this->assertStage($app, ApplicationStage::TechReview);

        $app->current_stage = ApplicationStage::LabelReview;

        $this->createReview($app, $by, ApplicationStage::TechReview, ApplicationDecision::Approved, $comments);
        $app->save();

        activity()->causedBy($by)->performedOn($app)->log('passTechnical');
    }

    public function failTechnical(RegistrationApplication $app, User $by, string $comments): void
    {
        $this->assertStage($app, ApplicationStage::TechReview);

        $app->current_stage = ApplicationStage::NeedsRevision;

        $this->createReview($app, $by, ApplicationStage::TechReview, ApplicationDecision::NeedsRevision, $comments);
        $app->save();

        activity()->causedBy($by)->performedOn($app)->log('failTechnical');
    }

    public function passLabel(RegistrationApplication $app, User $by, string $comments = ''): void
    {
        $this->assertStage($app, ApplicationStage::LabelReview);

        $app->current_stage = ApplicationStage::Decision;

        $this->createReview($app, $by, ApplicationStage::LabelReview, ApplicationDecision::Approved, $comments);
        $app->save();

        activity()->causedBy($by)->performedOn($app)->log('passLabel');
    }

    public function failLabel(RegistrationApplication $app, User $by, string $comments): void
    {
        $this->assertStage($app, ApplicationStage::LabelReview);

        $app->current_stage = ApplicationStage::NeedsRevision;

        $this->createReview($app, $by, ApplicationStage::LabelReview, ApplicationDecision::NeedsRevision, $comments);
        $app->save();

        activity()->causedBy($by)->performedOn($app)->log('failLabel');
    }

    public function approveFinal(RegistrationApplication $app, User $by, string $comments = ''): void
    {
        $this->assertStage($app, ApplicationStage::Decision);

        $app->current_stage = ApplicationStage::Approved;
        $app->decided_at    = now();

        $this->createReview($app, $by, ApplicationStage::Decision, ApplicationDecision::Approved, $comments);
        $app->save();

        activity()->causedBy($by)->performedOn($app)->log('approveFinal');

        app(RegistrationNumberAllocator::class)->allocate($app);
    }

    public function rejectFinal(RegistrationApplication $app, User $by, string $comments): void
    {
        $this->assertStage($app, ApplicationStage::Decision);

        $app->current_stage = ApplicationStage::Rejected;
        $app->decided_at    = now();

        $this->createReview($app, $by, ApplicationStage::Decision, ApplicationDecision::Rejected, $comments);
        $app->save();

        activity()->causedBy($by)->performedOn($app)->log('rejectFinal');
    }

    public function resubmit(RegistrationApplication $app, User $by): void
    {
        $this->assertStage($app, ApplicationStage::NeedsRevision);

        $app->current_stage = ApplicationStage::Submitted;
        $app->submitted_at  = now();

        $this->createReview($app, $by, ApplicationStage::NeedsRevision, ApplicationDecision::Pending);
        $app->save();

        activity()->causedBy($by)->performedOn($app)->log('resubmit');
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function assertStage(RegistrationApplication $app, ApplicationStage $expected): void
    {
        if ($app->current_stage !== $expected) {
            throw new \RuntimeException(
                "Cannot perform this action: application is in stage [{$app->current_stage->value}], expected [{$expected->value}]."
            );
        }
    }

    private function createReview(
        RegistrationApplication $app,
        User $by,
        ApplicationStage $stage,
        ApplicationDecision $decision,
        string $comments = ''
    ): void {
        ApplicationReview::create([
            'application_id' => $app->id,
            'reviewer_id'    => $by->id,
            'stage'          => $stage,
            'decision'       => $decision,
            'comments'       => $comments,
            'reviewed_at'    => now(),
        ]);
    }
}
