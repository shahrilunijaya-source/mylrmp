<?php

namespace Tests\Feature;

use App\Enums\ApplicationStage;
use App\Models\Company;
use App\Models\Product;
use App\Models\RegistrationApplication;
use App\Models\User;
use App\Services\ApplicationWorkflow;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ApplicationWorkflowTest extends TestCase
{
    use DatabaseTransactions;

    private function makeApplication(Company $company, User $applicant): RegistrationApplication
    {
        $product = Product::factory()->create([
            'registrant_company_id' => $company->id,
        ]);

        return RegistrationApplication::create([
            'application_no'       => 'TEST-' . uniqid(),
            'applicant_user_id'    => $applicant->id,
            'applicant_company_id' => $company->id,
            'product_id'           => $product->id,
            'current_stage'        => ApplicationStage::Draft,
        ]);
    }

    public function test_application_moves_from_draft_to_submitted(): void
    {
        $company   = Company::first();
        $applicant = User::role('Industri')->first();

        $this->assertNotNull($company, 'No company seeded');
        $this->assertNotNull($applicant, 'No Industri user seeded');

        $app      = $this->makeApplication($company, $applicant);
        $workflow = app(ApplicationWorkflow::class);

        $workflow->submit($app, $applicant);

        $app->refresh();
        $this->assertEquals(ApplicationStage::Submitted, $app->current_stage);
        $this->assertNotNull($app->submitted_at);
    }

    public function test_full_approval_workflow(): void
    {
        $company   = Company::first();
        $applicant = User::role('Industri')->first();
        $intake    = User::role('Pegawai Pendaftaran')->first();
        $tech      = User::role('Penilai Teknikal')->first();
        $label     = User::role('Penilai Label')->first();
        $registrar = User::role('Pendaftar')->first();

        $this->assertNotNull($company, 'No company seeded');
        $this->assertNotNull($applicant, 'No Industri user seeded');
        $this->assertNotNull($intake, 'No Pegawai Pendaftaran user seeded');
        $this->assertNotNull($tech, 'No Penilai Teknikal user seeded');
        $this->assertNotNull($label, 'No Penilai Label user seeded');
        $this->assertNotNull($registrar, 'No Pendaftar user seeded');

        $app      = $this->makeApplication($company, $applicant);
        $workflow = app(ApplicationWorkflow::class);

        $workflow->submit($app, $applicant);
        $workflow->passIntake($app, $intake, 'OK');
        $workflow->passTechnical($app, $tech, 'OK');
        $workflow->passLabel($app, $label, 'OK');
        $workflow->approveFinal($app, $registrar, 'Approved');

        $app->refresh();
        $this->assertEquals(ApplicationStage::Approved, $app->current_stage);
        $this->assertNotNull($app->decided_at);

        // Certificate should have been created
        $cert = $app->certificate;
        $this->assertNotNull($cert);
        $this->assertStringStartsWith('MP-', $cert->registration_no);
    }

    public function test_wrong_stage_throws_exception(): void
    {
        $company   = Company::first();
        $applicant = User::role('Industri')->first();
        $tech      = User::role('Penilai Teknikal')->first();

        $this->assertNotNull($company, 'No company seeded');
        $this->assertNotNull($applicant, 'No Industri user seeded');
        $this->assertNotNull($tech, 'No Penilai Teknikal user seeded');

        $app = $this->makeApplication($company, $applicant);
        // Application is in draft — passTechnical should throw

        $this->expectException(\RuntimeException::class);
        app(ApplicationWorkflow::class)->passTechnical($app, $tech, 'Should fail');
    }
}
