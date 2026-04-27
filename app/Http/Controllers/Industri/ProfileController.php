<?php

namespace App\Http\Controllers\Industri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user    = $request->user()->load('company');
        $company = $user->company;

        return view('industri.profile', compact('user', 'company'));
    }
}
