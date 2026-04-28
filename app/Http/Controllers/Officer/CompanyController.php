<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::withCount('users')->paginate(20);

        return view('officer.companies.index', compact('companies'));
    }

    public function show(Company $company)
    {
        $company->load(['users', 'applications.product', 'registeredProducts']);

        return view('officer.companies.show', compact('company'));
    }
}
