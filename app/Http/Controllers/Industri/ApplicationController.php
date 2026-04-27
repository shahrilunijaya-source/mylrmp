<?php

namespace App\Http\Controllers\Industri;

use App\Http\Controllers\Controller;
use App\Models\ApplicationDocument;
use App\Models\RegistrationApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $applications = RegistrationApplication::with(['product', 'category'])
            ->where('applicant_company_id', $user->company_id)
            ->latest()
            ->paginate(15);

        return view('industri.applications.index', compact('applications'));
    }

    public function create()
    {
        return view('industri.applications.create');
    }

    public function show(RegistrationApplication $application)
    {
        Gate::authorize('view', $application);

        $application->load(['product.formulationType', 'product.activeIngredients', 'category', 'subcategory', 'documents', 'reviews.reviewer', 'certificate']);

        return view('industri.applications.show', compact('application'));
    }

    public function uploadDocument(Request $request, RegistrationApplication $application)
    {
        Gate::authorize('view', $application);

        $request->validate([
            'document_type' => ['required', 'string', 'max:100'],
            'file'          => ['required', 'file', 'max:10240', 'mimes:pdf,jpg,jpeg,png,docx,xlsx'],
        ]);

        $uploadedFile = $request->file('file');
        $directory    = 'uploads/' . $application->id;
        $storedPath   = $uploadedFile->store($directory, 'private');

        ApplicationDocument::create([
            'application_id' => $application->id,
            'document_type'  => $request->input('document_type'),
            'original_name'  => $uploadedFile->getClientOriginalName(),
            'stored_path'    => $storedPath,
            'mime'           => $uploadedFile->getClientMimeType(),
            'size'           => $uploadedFile->getSize(),
            'uploaded_by'    => $request->user()->id,
        ]);

        return redirect()->route('industri.applications.show', $application)
            ->with('success', 'Dokumen berjaya dimuat naik.');
    }
}
