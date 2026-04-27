<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('companies.view_any');
    }

    public function view(User $user, Company $company): bool
    {
        if ($user->can('companies.view_any')) {
            return true;
        }

        return $user->can('companies.view_own')
            && $user->company_id === $company->id;
    }

    public function create(User $user): bool
    {
        return $user->can('companies.create');
    }

    public function update(User $user, Company $company): bool
    {
        if ($user->can('companies.view_any')) {
            return true;
        }

        return $user->can('companies.view_own')
            && $user->company_id === $company->id;
    }
}
