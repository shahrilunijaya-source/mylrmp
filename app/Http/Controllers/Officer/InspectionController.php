<?php

namespace App\Http\Controllers\Officer;

use App\Enums\InspectionStatus;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Inspection;
use App\Models\Premises;
use App\Models\User;
use App\Services\InspectionNumberAllocator;
use App\Services\InspectionWorkflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InspectionController extends Controller
{
    public function index(Request $request)
    {
        $status   = $request->input('status', '');
        $mine     = $request->boolean('mine');
        $statuses = InspectionStatus::cases();

        $query = Inspection::with(['inspector'])->withCount('findings');

        if ($status !== '') {
            $query->where('status', $status);
        }

        if ($mine) {
            $query->where('inspector_id', auth()->id());
        }

        $inspections = $query->orderByDesc('scheduled_for')->paginate(20)->withQueryString();

        return view('officer.pemeriksaan.index', compact('inspections', 'statuses', 'status', 'mine'));
    }

    public function create(Request $request)
    {
        $inspectors = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['Pegawai Pemeriksaan', 'Super Admin', 'Pegawai Pendaftaran']);
        })->where('is_active', true)->orderBy('name')->get();

        $premises  = Premises::where('is_active', true)->orderBy('name')->get();
        $companies = Company::where('status', 'active')->orderBy('name')->get();

        $preTargetType = $request->input('target_type', '');
        $preTargetId   = $request->input('target_id', '');

        return view('officer.pemeriksaan.create', compact('inspectors', 'premises', 'companies', 'preTargetType', 'preTargetId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'target_type'   => ['required', 'in:premises,company'],
            'target_id'     => ['required', 'integer'],
            'inspector_id'  => ['required', 'exists:users,id'],
            'scheduled_for' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $targetClass = $data['target_type'] === 'premises' ? Premises::class : Company::class;
        $target      = $targetClass::findOrFail($data['target_id']);

        $inspection = Inspection::create([
            'inspection_no' => 'DRAFT',
            'target_type'   => $targetClass,
            'target_id'     => $target->id,
            'inspector_id'  => $data['inspector_id'],
            'scheduled_for' => $data['scheduled_for'],
            'status'        => InspectionStatus::Scheduled,
        ]);

        app(InspectionNumberAllocator::class)->allocate($inspection);

        return redirect()->route('officer.pemeriksaan.show', $inspection)
            ->with('success', 'Pemeriksaan berjaya dijadualkan: ' . $inspection->fresh()->inspection_no);
    }

    public function show(Inspection $inspection)
    {
        $inspection->load([
            'target',
            'inspector',
            'checklistResponses.item',
            'findings.linkedProduct',
            'findings.attachments',
        ]);

        return view('officer.pemeriksaan.show', compact('inspection'));
    }

    public function conduct(Inspection $inspection)
    {
        abort_unless($inspection->status === InspectionStatus::InProgress, 403, 'Pemeriksaan belum dimulakan.');

        return view('officer.pemeriksaan.conduct', compact('inspection'));
    }

    public function start(Request $request, Inspection $inspection)
    {
        try {
            app(InspectionWorkflow::class)->start($inspection, $request->user());
        } catch (\RuntimeException $e) {
            return back()->withErrors(['action' => $e->getMessage()]);
        }

        return redirect()->route('officer.pemeriksaan.conduct', $inspection)
            ->with('success', 'Pemeriksaan dimulakan.');
    }

    public function cancel(Request $request, Inspection $inspection)
    {
        $request->validate(['reason' => ['nullable', 'string', 'max:500']]);

        try {
            app(InspectionWorkflow::class)->cancel($inspection, $request->user(), $request->input('reason', ''));
        } catch (\RuntimeException $e) {
            return back()->withErrors(['action' => $e->getMessage()]);
        }

        return back()->with('success', 'Pemeriksaan dibatalkan.');
    }

    public function downloadReport(Inspection $inspection)
    {
        abort_unless($inspection->report_pdf_path, 404);

        return Storage::disk('local')->download(
            $inspection->report_pdf_path,
            $inspection->inspection_no . '_laporan.pdf'
        );
    }

    public function downloadNotice(Inspection $inspection)
    {
        abort_unless($inspection->notice_pdf_path, 404);

        return Storage::disk('local')->download(
            $inspection->notice_pdf_path,
            $inspection->inspection_no . '_notis.pdf'
        );
    }
}
