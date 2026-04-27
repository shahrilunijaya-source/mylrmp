<?php

namespace App\Providers;

use App\Models\Certificate;
use App\Models\Company;
use App\Models\Product;
use App\Models\RegistrationApplication;
use App\Policies\CertificatePolicy;
use App\Policies\CompanyPolicy;
use App\Policies\ProductPolicy;
use App\Policies\RegistrationApplicationPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(RegistrationApplication::class, RegistrationApplicationPolicy::class);
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Company::class, CompanyPolicy::class);
        Gate::policy(Certificate::class, CertificatePolicy::class);
    }
}
