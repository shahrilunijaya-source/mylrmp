<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Product;
use App\Models\RegistrationApplication;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_registered_products' => Product::where('status', 'active')->count(),
            'total_applications_this_year' => RegistrationApplication::whereYear('submitted_at', now()->year)->count(),
            'total_companies' => Company::count(),
        ];

        return view('public.home', compact('stats'));
    }
}
