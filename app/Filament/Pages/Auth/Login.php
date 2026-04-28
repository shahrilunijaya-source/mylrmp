<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

class Login extends BaseLogin
{
    protected static string $layout = 'filament.layouts.auth-login';

    protected string $view = 'filament.pages.auth.login';

    public function fillDemo(string $email, string $password): void
    {
        $this->data['email']    = $email;
        $this->data['password'] = $password;
    }
}
