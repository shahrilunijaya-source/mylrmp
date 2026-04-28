<?php

namespace App\Http\Controllers\Officer;

use App\Enums\MalaysianState;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Premises;
use Illuminate\Http\Request;

class PremisesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $state  = $request->input('state', '');

        $query = Premises::withCount('inspections');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('license_no', 'like', "%{$search}%");
            });
        }

        if ($state !== '') {
            $query->where('state', $state);
        }

        $premises = $query->latest()->paginate(20)->withQueryString();
        $states   = MalaysianState::cases();

        return view('officer.premis.index', compact('premises', 'states', 'search', 'state'));
    }

    public function create()
    {
        $companies = Company::where('status', 'active')->orderBy('name')->get();
        $states    = MalaysianState::cases();

        return view('officer.premis.create', compact('companies', 'states'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'license_no'       => ['nullable', 'string', 'max:50', 'unique:premises,license_no'],
            'owner_company_id' => ['nullable', 'exists:companies,id'],
            'address_line1'    => ['required', 'string', 'max:255'],
            'address_line2'    => ['nullable', 'string', 'max:255'],
            'postcode'         => ['nullable', 'string', 'max:10'],
            'district'         => ['nullable', 'string', 'max:100'],
            'state'            => ['nullable', 'string'],
            'pic_name'         => ['nullable', 'string', 'max:255'],
            'pic_phone'        => ['nullable', 'string', 'max:20'],
        ]);

        Premises::create($data);

        return redirect()->route('officer.premis.index')->with('success', 'Premis berjaya didaftarkan.');
    }

    public function show(Premises $premis)
    {
        $premis->load(['ownerCompany', 'inspections.inspector']);

        return view('officer.premis.show', compact('premis'));
    }

    public function edit(Premises $premis)
    {
        $companies = Company::where('status', 'active')->orderBy('name')->get();
        $states    = MalaysianState::cases();

        return view('officer.premis.edit', compact('premis', 'companies', 'states'));
    }

    public function update(Request $request, Premises $premis)
    {
        $data = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'license_no'       => ['nullable', 'string', 'max:50', "unique:premises,license_no,{$premis->id}"],
            'owner_company_id' => ['nullable', 'exists:companies,id'],
            'address_line1'    => ['required', 'string', 'max:255'],
            'address_line2'    => ['nullable', 'string', 'max:255'],
            'postcode'         => ['nullable', 'string', 'max:10'],
            'district'         => ['nullable', 'string', 'max:100'],
            'state'            => ['nullable', 'string'],
            'pic_name'         => ['nullable', 'string', 'max:255'],
            'pic_phone'        => ['nullable', 'string', 'max:20'],
            'is_active'        => ['boolean'],
        ]);

        $premis->update($data);

        return redirect()->route('officer.premis.show', $premis)->with('success', 'Maklumat premis dikemaskini.');
    }
}
