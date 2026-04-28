<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $query  = Product::with(['registrant', 'formulationType', 'activeIngredients']);

        if ($search !== '') {
            $query->where('name', 'like', "%{$search}%");
        }

        $products = $query->latest()->paginate(20)->withQueryString();

        return view('officer.products.index', compact('products', 'search'));
    }
}
