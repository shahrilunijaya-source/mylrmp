<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'company'])->paginate(20);

        return view('officer.users.index', compact('users'));
    }
}
