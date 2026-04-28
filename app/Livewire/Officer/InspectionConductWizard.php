<?php

namespace App\Livewire\Officer;

use App\Enums\InspectionStatus;
use App\Models\Inspection;
use App\Models\InspectionChecklistItem;
use App\Models\InspectionChecklistResponse;
use App\Models\InspectionFinding;
use App\Models\InspectionFindingAttachment;
use App\Models\Product;
use App\Services\InspectionWorkflow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class InspectionConductWizard extends Component
{
    use WithFileUploads;

    public Inspection $inspection;

    public int $step = 1;

    // Step 1 — checklist answers keyed by checklist_item_id
    public array $answers = [];   // [item_id => ['answer' => 'Yes|No|NA', 'note' => '']]

    // Step 2 — findings
    public array $findings = [];
    // Each entry: ['severity' => 'minor|major', 'category' => '', 'description' => '', 'product_id' => null, 'photo' => null]

    // Step 3 — conclusion
    public string $summary      = '';
    public string $outcomeStatus = '';
    public string $deadline      = '';

    public function mount(Inspection $inspection): void
    {
        $this->inspection = $inspection;

        // Load existing checklist responses
        $targetType = class_basename($inspection->target_type);

        $items = InspectionChecklistItem::active()
            ->forTarget($targetType)
            ->get();

        $existing = $inspection->checklistResponses->keyBy('checklist_item_id');

        foreach ($items as $item) {
            $resp = $existing->get($item->id);
            $this->answers[$item->id] = [
                'answer' => $resp?->answer ?? 'NA',
                'note'   => $resp?->note   ?? '',
            ];
        }

        // Load existing findings
        foreach ($inspection->findings as $f) {
            $this->findings[] = [
                'id'          => $f->id,
                'severity'    => $f->severity->value,
                'category'    => $f->category,
                'description' => $f->description,
                'product_id'  => $f->linked_product_id,
                'photo'       => null,
            ];
        }

        $this->summary = $inspection->summary ?? '';
    }

    public function nextStep(): void
    {
        if ($this->step === 1) {
            $this->saveChecklist();
        } elseif ($this->step === 2) {
            $this->saveFindings();
        }

        $this->step++;
    }

    public function prevStep(): void
    {
        $this->step = max(1, $this->step - 1);
    }

    public function addFinding(): void
    {
        $this->findings[] = [
            'id'          => null,
            'severity'    => 'minor',
            'category'    => 'Inventori',
            'description' => '',
            'product_id'  => null,
            'photo'       => null,
        ];
    }

    public function removeFinding(int $index): void
    {
        $entry = $this->findings[$index] ?? null;

        if ($entry && $entry['id']) {
            InspectionFinding::find($entry['id'])?->delete();
        }

        array_splice($this->findings, $index, 1);
        $this->findings = array_values($this->findings);
    }

    public function conclude(): void
    {
        $this->validate([
            'summary'       => ['required', 'string', 'min:10'],
            'outcomeStatus' => ['required', 'in:compliant,minor_nc,major_nc'],
            'deadline'      => ['required_if:outcomeStatus,minor_nc,major_nc', 'nullable', 'date', 'after:today'],
        ]);

        $this->saveFindings();

        $workflow = app(InspectionWorkflow::class);
        $user     = auth()->user();

        if ($this->outcomeStatus === 'compliant') {
            $workflow->concludeCompliant($this->inspection, $user, $this->summary);
        } else {
            $status   = InspectionStatus::from($this->outcomeStatus);
            $deadline = Carbon::parse($this->deadline);
            $workflow->concludeWithFindings($this->inspection, $user, $this->summary, $status, $deadline);
        }

        session()->flash('success', 'Pemeriksaan selesai. ' . ($this->inspection->fresh()->report_pdf_path ? 'Laporan telah dijana.' : ''));

        $this->redirectRoute('officer.pemeriksaan.show', $this->inspection);
    }

    private function saveChecklist(): void
    {
        foreach ($this->answers as $itemId => $data) {
            InspectionChecklistResponse::updateOrCreate(
                ['inspection_id' => $this->inspection->id, 'checklist_item_id' => $itemId],
                ['answer' => $data['answer'], 'note' => $data['note'] ?? null]
            );
        }
    }

    private function saveFindings(): void
    {
        // Remove DB findings not in current array
        $keepIds = collect($this->findings)->pluck('id')->filter()->all();
        InspectionFinding::where('inspection_id', $this->inspection->id)
            ->whereNotIn('id', $keepIds)
            ->delete();

        foreach ($this->findings as $i => $entry) {
            $finding = InspectionFinding::updateOrCreate(
                ['id' => $entry['id'] ?? 0],
                [
                    'inspection_id'     => $this->inspection->id,
                    'severity'          => $entry['severity'],
                    'category'          => $entry['category'],
                    'linked_product_id' => $entry['product_id'] ?: null,
                    'description'       => $entry['description'],
                ]
            );

            $this->findings[$i]['id'] = $finding->id;

            if (! empty($entry['photo'])) {
                $photo = $entry['photo'];
                $path  = $photo->storeAs(
                    'private/inspections/' . $this->inspection->id,
                    $finding->id . '_' . time() . '.' . $photo->getClientOriginalExtension(),
                    'local'
                );

                InspectionFindingAttachment::create([
                    'finding_id' => $finding->id,
                    'path'       => $path,
                    'mime'       => $photo->getMimeType(),
                    'size_bytes' => $photo->getSize(),
                ]);

                $this->findings[$i]['photo'] = null;
            }
        }
    }

    public function render()
    {
        $targetType = class_basename($this->inspection->target_type);

        $checklistItems = InspectionChecklistItem::active()
            ->forTarget($targetType)
            ->get()
            ->groupBy('category');

        $products = Product::orderBy('name')->get(['id', 'name', 'registration_no']);

        $categories = ['Pelesenan', 'Penyimpanan', 'Pelabelan', 'Inventori', 'Pelupusan', 'Lain-lain'];

        return view('livewire.officer.inspection-conduct-wizard', compact('checklistItems', 'products', 'categories'));
    }
}
