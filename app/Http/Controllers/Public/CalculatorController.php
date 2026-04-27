<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CalculatorController extends Controller
{
    public function index(): View
    {
        return view('public.calculator');
    }
}
