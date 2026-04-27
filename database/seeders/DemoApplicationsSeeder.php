<?php

namespace Database\Seeders;

use App\Enums\ApplicationDecision;
use App\Enums\ApplicationStage;
use App\Enums\ProductStatus;
use App\Models\ActiveIngredient;
use App\Models\ApplicationDocument;
use App\Models\ApplicationReview;
use App\Models\Certificate;
use App\Models\Company;
use App\Models\FormulationType;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Models\RegistrationApplication;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoApplicationsSeeder extends Seeder
{
    public function run(): void
    {
        // Load reference data
        $companies        = Company::whereIn('status', ['active'])->get();
        $categories       = ProductCategory::all();
        $subcategories    = ProductSubcategory::all();
        $formulations     = FormulationType::all();
        $ingredients      = ActiveIngredient::all();
        $officers         = User::role('Pegawai Pendaftaran')->get();
        $techEvaluators   = User::role('Penilai Teknikal')->get();
        $labelEvaluators  = User::role('Penilai Label')->get();
        $registrars       = User::role('Pendaftar')->get();
        $industriUsers    = User::role('Industri')->get();

        $productNames = [
            'GlyFos', 'AgroKill', 'TaniMox', 'BioShield', 'ChemGuard',
            'HerbAway', 'FungoClear', 'InsectoKill', 'WeedBuster', 'CropSafe',
            'RootGuard', 'LeafShield', 'SoilFix', 'PestOff', 'GreenKill',
            'AquaProtect', 'AgriMax', 'TaniGuard', 'BioFarm', 'EcoShield',
        ];

        // Stage distribution: 50 total
        // draft=5, submitted=8, tech_review=7, label_review=5, decision=4,
        // approved=15, rejected=4, needs_revision=2
        $stageDistribution = array_merge(
            array_fill(0, 5,  ApplicationStage::Draft),
            array_fill(0, 8,  ApplicationStage::Submitted),
            array_fill(0, 7,  ApplicationStage::TechReview),
            array_fill(0, 5,  ApplicationStage::LabelReview),
            array_fill(0, 4,  ApplicationStage::Decision),
            array_fill(0, 15, ApplicationStage::Approved),
            array_fill(0, 4,  ApplicationStage::Rejected),
            array_fill(0, 2,  ApplicationStage::NeedsRevision),
        );

        $certSeq = 1;

        foreach ($stageDistribution as $seq => $stage) {
            $appNo   = 'APP-2026-' . str_pad($seq + 1, 4, '0', STR_PAD_LEFT);
            $company = $companies->random();

            // Pick an industri user from this company; fall back to any industri user
            $applicant = $industriUsers->where('company_id', $company->id)->first()
                ?? $industriUsers->random();

            $category    = $categories->random();
            $subcategory = $subcategories->random();
            $formulation = $formulations->random();

            // Build product name
            $baseName    = $productNames[array_rand($productNames)];
            $productName = $baseName . ' ' . $formulation->code . ' ' . ($seq + 1);

            // Create product
            $product = Product::create([
                'name'                  => $productName,
                'registrant_company_id' => $company->id,
                'formulation_type_id'   => $formulation->id,
                'status'                => ProductStatus::Pending,
            ]);

            // Attach 1-3 random active ingredients
            $pickedIngredients = $ingredients->random(rand(1, 3));
            foreach ($pickedIngredients as $ingredient) {
                $product->activeIngredients()->attach($ingredient->id, [
                    'concentration_percent' => rand(5, 25),
                ]);
            }

            // Determine submitted_at
            $submittedAt = match ($stage) {
                ApplicationStage::Draft => null,
                default                 => Carbon::now()->subDays(rand(1, 90)),
            };

            // Create the application
            $application = RegistrationApplication::create([
                'application_no'      => $appNo,
                'category_id'         => $category->id,
                'subcategory_id'      => $subcategory->id,
                'applicant_user_id'   => $applicant->id,
                'applicant_company_id'=> $company->id,
                'product_id'          => $product->id,
                'current_stage'       => $stage,
                'submitted_at'        => $submittedAt,
                'decided_at'          => null,
            ]);

            // Upload document (label)
            ApplicationDocument::create([
                'application_id' => $application->id,
                'document_type'  => 'label_produk',
                'original_name'  => 'label.pdf',
                'stored_path'    => 'uploads/demo/label.pdf',
                'mime'           => 'application/pdf',
                'size'           => 204800,
                'uploaded_by'    => $applicant->id,
            ]);

            // Build review chain depending on stage
            $reviewedAt = $submittedAt ? $submittedAt->copy()->addDays(rand(1, 5)) : null;

            $this->createReviewsForStage(
                $application,
                $stage,
                $officers,
                $techEvaluators,
                $labelEvaluators,
                $registrars,
                $reviewedAt,
            );

            // Handle final decisions
            if (in_array($stage, [ApplicationStage::Approved, ApplicationStage::Rejected])) {
                $decidedAt = $reviewedAt ? $reviewedAt->copy()->addDays(rand(1, 7)) : Carbon::now()->subDays(rand(1, 10));

                $application->update(['decided_at' => $decidedAt]);

                if ($stage === ApplicationStage::Approved) {
                    $regNo = 'MP-2026-' . str_pad($certSeq++, 5, '0', STR_PAD_LEFT);

                    Certificate::create([
                        'application_id'  => $application->id,
                        'registration_no' => $regNo,
                        'issued_at'       => $decidedAt,
                        'expires_at'      => $decidedAt->copy()->addYears(5)->toDateString(),
                    ]);

                    $product->update([
                        'status'          => ProductStatus::Active,
                        'registration_no' => $regNo,
                        'expires_at'      => $decidedAt->copy()->addYears(5)->toDateString(),
                    ]);
                }
            }
        }
    }

    private function createReviewsForStage(
        RegistrationApplication $application,
        ApplicationStage $stage,
        $officers,
        $techEvaluators,
        $labelEvaluators,
        $registrars,
        ?Carbon $baseReviewedAt,
    ): void {
        $at = $baseReviewedAt ?? Carbon::now()->subDays(rand(5, 30));

        switch ($stage) {
            case ApplicationStage::Draft:
                // No reviews yet
                break;

            case ApplicationStage::Submitted:
                // Intake review pending – no completed review
                break;

            case ApplicationStage::TechReview:
                // Intake (submitted) review completed
                $this->addReview($application, $officers->random(), ApplicationStage::Submitted, ApplicationDecision::Approved, $at);
                activity()->causedBy($officers->random())->performedOn($application)->log('submitted -> tech_review');
                break;

            case ApplicationStage::LabelReview:
                $this->addReview($application, $officers->random(),  ApplicationStage::Submitted,  ApplicationDecision::Approved, $at);
                $this->addReview($application, $techEvaluators->random(), ApplicationStage::TechReview, ApplicationDecision::Approved, $at->copy()->addDays(3));
                activity()->causedBy($techEvaluators->random())->performedOn($application)->log('tech_review -> label_review');
                break;

            case ApplicationStage::Decision:
                $this->addReview($application, $officers->random(),       ApplicationStage::Submitted,  ApplicationDecision::Approved, $at);
                $this->addReview($application, $techEvaluators->random(), ApplicationStage::TechReview, ApplicationDecision::Approved, $at->copy()->addDays(3));
                $this->addReview($application, $labelEvaluators->random(), ApplicationStage::LabelReview, ApplicationDecision::Approved, $at->copy()->addDays(6));
                activity()->causedBy($labelEvaluators->random())->performedOn($application)->log('label_review -> decision');
                break;

            case ApplicationStage::Approved:
                $this->addReview($application, $officers->random(),        ApplicationStage::Submitted,  ApplicationDecision::Approved, $at);
                $this->addReview($application, $techEvaluators->random(),  ApplicationStage::TechReview, ApplicationDecision::Approved, $at->copy()->addDays(3));
                $this->addReview($application, $labelEvaluators->random(), ApplicationStage::LabelReview, ApplicationDecision::Approved, $at->copy()->addDays(6));
                $this->addReview($application, $registrars->random(),      ApplicationStage::Decision,   ApplicationDecision::Approved, $at->copy()->addDays(9));
                activity()->causedBy($registrars->random())->performedOn($application)->log('decision -> approved');
                break;

            case ApplicationStage::Rejected:
                $this->addReview($application, $officers->random(),        ApplicationStage::Submitted,  ApplicationDecision::Approved,  $at);
                $this->addReview($application, $techEvaluators->random(),  ApplicationStage::TechReview, ApplicationDecision::Approved,  $at->copy()->addDays(3));
                $this->addReview($application, $labelEvaluators->random(), ApplicationStage::LabelReview, ApplicationDecision::Approved, $at->copy()->addDays(6));
                $this->addReview($application, $registrars->random(),      ApplicationStage::Decision,   ApplicationDecision::Rejected,  $at->copy()->addDays(9));
                activity()->causedBy($registrars->random())->performedOn($application)->log('decision -> rejected');
                break;

            case ApplicationStage::NeedsRevision:
                // Failed at intake or technical stage
                $failStage = (rand(0, 1) === 0) ? ApplicationStage::Submitted : ApplicationStage::TechReview;
                $reviewer  = ($failStage === ApplicationStage::Submitted) ? $officers->random() : $techEvaluators->random();
                $this->addReview($application, $reviewer, $failStage, ApplicationDecision::NeedsRevision, $at);
                activity()->causedBy($reviewer)->performedOn($application)->log($failStage->value . ' -> needs_revision');
                break;
        }
    }

    private function addReview(
        RegistrationApplication $application,
        User $reviewer,
        ApplicationStage $stage,
        ApplicationDecision $decision,
        Carbon $reviewedAt,
    ): void {
        ApplicationReview::create([
            'application_id' => $application->id,
            'reviewer_id'    => $reviewer->id,
            'stage'          => $stage,
            'decision'       => $decision,
            'comments'       => $this->sampleComment($decision),
            'reviewed_at'    => $reviewedAt,
        ]);
    }

    private function sampleComment(ApplicationDecision $decision): string
    {
        return match ($decision) {
            ApplicationDecision::Approved      => 'Dokumen lengkap dan memenuhi keperluan. Diluluskan untuk peringkat seterusnya.',
            ApplicationDecision::Rejected      => 'Permohonan tidak memenuhi kriteria pendaftaran. Ditolak.',
            ApplicationDecision::NeedsRevision => 'Terdapat kekurangan dalam dokumen yang dikemukakan. Sila kemukakan semula dengan pindaan.',
            ApplicationDecision::Pending       => '',
        };
    }
}
