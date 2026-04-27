<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FormulationType;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductSearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = $request->get('q', '');
        $formulationTypeId = $request->get('formulation_type_id', '');
        $categoryId = $request->get('category_id', '');

        $products = Product::with(['formulationType', 'registrant'])
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('name', 'like', "%{$query}%")
                        ->orWhere('registration_no', 'like', "%{$query}%")
                        ->orWhereHas('activeIngredients', function ($ai) use ($query) {
                            $ai->where('name', 'like', "%{$query}%");
                        });
                });
            })
            ->when($formulationTypeId, fn($q) => $q->where('formulation_type_id', $formulationTypeId))
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->whereHas('applications', fn($a) => $a->where('category_id', $categoryId));
            })
            ->paginate(15)
            ->withQueryString();

        $formulationTypes = FormulationType::orderBy('name_ms')->get();
        $categories = ProductCategory::orderBy('name_ms')->get();

        return view('public.product-search', compact('products', 'formulationTypes', 'categories', 'query', 'formulationTypeId', 'categoryId'));
    }

    public function show(Product $product): View
    {
        if ($product->status->value !== 'active') {
            abort(404);
        }

        $product->load(['activeIngredients', 'registrant', 'certificate', 'formulationType']);

        return view('public.product-detail', compact('product'));
    }
}
