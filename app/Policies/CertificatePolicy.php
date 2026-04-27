<?php

namespace App\Policies;

use App\Models\Certificate;
use App\Models\User;

class CertificatePolicy
{
    public function view(User $user, Certificate $certificate): bool
    {
        return $user->can('certificates.view');
    }

    public function regenerate(User $user, Certificate $certificate): bool
    {
        return $user->can('certificates.regenerate');
    }
}
