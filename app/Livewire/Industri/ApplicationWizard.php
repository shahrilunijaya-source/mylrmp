<?php

namespace App\Livewire\Industri;

use App\Enums\ApplicationStage;
use App\Models\ActiveIngredient;
use App\Models\FormulationType;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Models\RegistrationApplication;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ApplicationWizard extends Component
{
    public int $step = 1;
    public int $totalSteps = 5;

    // Step 1 — Kategori Produk
    public ?int $category_id    = null;
    public ?int $subcategory_id = null;

    // Step 2 — Butiran Produk
    public string $product_name      = '';
    public ?int   $formulation_type_id = null;
    public string $manufacturer_name  = '';

    // Step 3 — Perawis Aktif
    public array $ingredients = [
        ['active_ingredient_id' => null, 'concentration_percent' => ''],
    ];

    // Step 5 — Confirmation
    public bool $confirmed = false;

    // Computed for display
    public array $stepLabels = [
        1 => 'Kategori Produk',
        2 => 'Butiran Produk',
        3 => 'Perawis Aktif',
        4 => 'Dokumen',
        5 => 'Semak & Hantar',
    ];

    public function nextStep(): void
    {
        $this->validateCurrentStep();
        if ($this->step < $this->totalSteps) {
            $this->step++;
        }
    }

    public function previousStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function addIngredient(): void
    {
        $this->ingredients[] = ['active_ingredient_id' => null, 'concentration_percent' => ''];
    }

    public function removeIngredient(int $index): void
    {
        if (count($this->ingredients) > 1) {
            array_splice($this->ingredients, $index, 1);
        }
    }

    public function submit(): void
    {
        $this->validate([
            'confirmed' => ['accepted'],
        ], [
            'confirmed.accepted' => 'Anda mesti mengesahkan maklumat sebelum menghantar.',
        ]);

        $user = Auth::user();

        // Generate application_no
        $year    = now()->year;
        $seq     = RegistrationApplication::count() + 1;
        $appNo   = sprintf('APP-%d-%05d', $year, $seq);

        // Create Product
        $product = Product::create([
            'name'                  => $this->product_name,
            'registrant_company_id' => $user->company_id,
            'formulation_type_id'   => $this->formulation_type_id,
        ]);

        // Attach active ingredients
        $pivotData = [];
        foreach ($this->ingredients as $row) {
            if (! empty($row['active_ingredient_id'])) {
                $pivotData[(int) $row['active_ingredient_id']] = [
                    'concentration_percent' => $row['concentration_percent'] ?: null,
                ];
            }
        }
        if (! empty($pivotData)) {
            $product->activeIngredients()->sync($pivotData);
        }

        // Create RegistrationApplication
        $application = RegistrationApplication::create([
            'application_no'       => $appNo,
            'category_id'          => $this->category_id,
            'subcategory_id'       => $this->subcategory_id,
            'applicant_user_id'    => $user->id,
            'applicant_company_id' => $user->company_id,
            'product_id'           => $product->id,
            'current_stage'        => ApplicationStage::Draft,
        ]);

        $this->redirectRoute('industri.applications.show', ['application' => $application->id]);
    }

    private function validateCurrentStep(): void
    {
        match ($this->step) {
            1 => $this->validate([
                'category_id' => ['required', 'integer', 'exists:product_categories,id'],
            ], [
                'category_id.required' => 'Sila pilih kategori produk.',
            ]),
            2 => $this->validate([
                'product_name' => ['required', 'string', 'max:255'],
            ], [
                'product_name.required' => 'Nama produk diperlukan.',
            ]),
            3, 4 => null,
            default => null,
        };
    }

    public function render()
    {
        return view('livewire.industri.application-wizard', [
            'categories'         => ProductCategory::orderBy('name')->get(),
            'subcategories'      => $this->category_id
                ? ProductSubcategory::where('category_id', $this->category_id)->orderBy('name')->get()
                : collect(),
            'formulationTypes'   => FormulationType::orderBy('name_ms')->get(),
            'activeIngredients'  => ActiveIngredient::orderBy('name')->get(),
        ]);
    }
}
