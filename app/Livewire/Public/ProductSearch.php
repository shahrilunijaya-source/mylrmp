<?php

namespace App\Livewire\Public;

use App\Models\FormulationType;
use App\Models\Product;
use Livewire\Component;

class ProductSearch extends Component
{
    public string $query = '';
    public string $formulationType = '';

    public function render()
    {
        $results = Product::with(['formulationType', 'registrant'])
            ->where('status', 'active')
            ->when(strlen($this->query) >= 2, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('name', 'like', "%{$this->query}%")
                        ->orWhere('registration_no', 'like', "%{$this->query}%");
                });
            })
            ->when($this->formulationType, fn($q) => $q->where('formulation_type_id', $this->formulationType))
            ->limit(20)
            ->get();

        $formulationTypes = FormulationType::orderBy('name_ms')->get();

        return view('livewire.public.product-search', compact('results', 'formulationTypes'));
    }
}
