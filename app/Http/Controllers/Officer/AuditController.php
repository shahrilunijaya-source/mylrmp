<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class AuditController extends Controller
{
    public function index()
    {
        $activities = Activity::with('causer')->latest()->paginate(30);

        return view('officer.audit.index', compact('activities'));
    }
}
