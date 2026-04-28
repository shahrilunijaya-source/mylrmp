<?php

namespace Database\Seeders;

use App\Enums\InspectionStatus;
use App\Models\Inspection;
use App\Models\InspectionChecklistItem;
use App\Models\InspectionChecklistResponse;
use App\Models\InspectionFinding;
use App\Models\Premises;
use App\Models\User;
use App\Services\InspectionNumberAllocator;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoInspectionsSeeder extends Seeder
{
    public function run(): void
    {
        $inspectors = User::whereHas('roles', fn ($q) => $q->whereIn('name', ['Pegawai Pemeriksaan', 'Pegawai Pendaftaran', 'Super Admin']))
            ->where('is_active', true)
            ->get();

        if ($inspectors->isEmpty()) {
            return;
        }

        $premises  = Premises::all();
        $allocator = app(InspectionNumberAllocator::class);

        $scenarios = [
            // 4 Scheduled
            ['status' => InspectionStatus::Scheduled,  'days_ahead' =>  3,  'findings' => []],
            ['status' => InspectionStatus::Scheduled,  'days_ahead' =>  7,  'findings' => []],
            ['status' => InspectionStatus::Scheduled,  'days_ahead' => 14,  'findings' => []],
            ['status' => InspectionStatus::Scheduled,  'days_ahead' =>  1,  'findings' => []],
            // 2 InProgress
            ['status' => InspectionStatus::InProgress, 'days_ago'   =>  0,  'findings' => []],
            ['status' => InspectionStatus::InProgress, 'days_ago'   =>  1,  'findings' => []],
            // 3 Compliant
            ['status' => InspectionStatus::Compliant,  'days_ago'   =>  5,  'findings' => []],
            ['status' => InspectionStatus::Compliant,  'days_ago'   => 12,  'findings' => []],
            ['status' => InspectionStatus::Compliant,  'days_ago'   => 20,  'findings' => []],
            // 2 MinorNC
            ['status' => InspectionStatus::MinorNC,    'days_ago'   =>  8,  'findings' => [['severity' => 'minor', 'category' => 'Pelabelan',  'description' => 'Label produk tidak mengandungi amaran keselamatan yang lengkap.']]],
            ['status' => InspectionStatus::MinorNC,    'days_ago'   => 15,  'findings' => [['severity' => 'minor', 'category' => 'Inventori',  'description' => 'Rekod stok tidak dikemaskini selama 2 minggu.']]],
            // 1 MajorNC
            ['status' => InspectionStatus::MajorNC,    'days_ago'   => 10,  'findings' => [
                ['severity' => 'major', 'category' => 'Inventori',  'description' => 'Terdapat 3 kotak produk racun perosak tidak berdaftar (MP-2019-00088) dijumpai di rak jualan.'],
                ['severity' => 'major', 'category' => 'Penyimpanan','description' => 'Racun perosak disimpan bersama bahan makanan di dalam bilik sejuk yang sama.'],
            ]],
        ];

        foreach ($scenarios as $i => $scenario) {
            $premis    = $premises->get($i % $premises->count());
            $inspector = $inspectors->get($i % $inspectors->count());

            if (! $premis) {
                continue;
            }

            $scheduledFor = isset($scenario['days_ahead'])
                ? Carbon::today()->addDays($scenario['days_ahead'])
                : Carbon::today()->subDays($scenario['days_ago'] ?? 0);

            $inspection = Inspection::create([
                'inspection_no' => 'DRAFT',
                'target_type'   => \App\Models\Premises::class,
                'target_id'     => $premis->id,
                'inspector_id'  => $inspector->id,
                'scheduled_for' => $scheduledFor,
                'status'        => InspectionStatus::Scheduled,
            ]);

            $allocator->allocate($inspection);
            $inspection->refresh();

            // Advance to target status
            if ($scenario['status'] !== InspectionStatus::Scheduled) {
                $inspection->update([
                    'status'       => $scenario['status'],
                    'conducted_at' => $scheduledFor,
                    'summary'      => $this->fakeSummary($scenario['status']),
                ]);

                if ($scenario['status']->requiresNotice()) {
                    $inspection->update(['notice_deadline' => Carbon::today()->addDays(30)]);
                }

                // Seed a handful of checklist responses
                $items = InspectionChecklistItem::active()->limit(8)->get();
                foreach ($items as $item) {
                    InspectionChecklistResponse::firstOrCreate(
                        ['inspection_id' => $inspection->id, 'checklist_item_id' => $item->id],
                        ['answer' => collect(['Yes', 'Yes', 'Yes', 'No', 'NA'])->random()]
                    );
                }

                // Seed findings
                foreach ($scenario['findings'] as $f) {
                    InspectionFinding::create([
                        'inspection_id' => $inspection->id,
                        'severity'      => $f['severity'],
                        'category'      => $f['category'],
                        'description'   => $f['description'],
                    ]);
                }
            }
        }
    }

    private function fakeSummary(InspectionStatus $status): string
    {
        return match ($status) {
            InspectionStatus::Compliant  => 'Premis didapati mematuhi semua keperluan Akta Racun Makanan 1974. Semua produk berdaftar, label lengkap dan kawasan penyimpanan memuaskan.',
            InspectionStatus::MinorNC    => 'Premis secara keseluruhannya dalam keadaan baik. Beberapa ketidakpatuhan kecil dikenal pasti dan perlu diperbetulkan dalam tempoh yang ditetapkan.',
            InspectionStatus::MajorNC    => 'Pemeriksaan mendapati ketidakpatuhan serius yang memerlukan tindakan segera. Premis diarah mematuhi notis ini dalam masa 30 hari atau tindakan lanjut akan diambil.',
            default                      => '',
        };
    }
}
