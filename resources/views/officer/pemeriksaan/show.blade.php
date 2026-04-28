<x-layouts.officer title="Butiran Pemeriksaan">

<div class="pg-head">
    <div>
        <div class="pg-title">{{ $inspection->inspection_no }}</div>
        <div class="pg-sub">{{ $inspection->targetLabel() }}</div>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        @if($inspection->status === \App\Enums\InspectionStatus::Scheduled)
            @can('inspections.conduct')
            <form method="POST" action="{{ route('officer.pemeriksaan.start', $inspection) }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-navy">Mulakan Pemeriksaan</button>
            </form>
            @endcan
            @can('inspections.cancel')
            <button onclick="document.getElementById('cancel-modal').style.display='flex'" class="btn-ghost" style="color:var(--red);border-color:var(--red);">Batal Pemeriksaan</button>
            @endcan
        @elseif($inspection->status === \App\Enums\InspectionStatus::InProgress)
            @can('inspections.conduct')
            <a href="{{ route('officer.pemeriksaan.conduct', $inspection) }}" class="btn-navy">Sambung Mengisi →</a>
            @endcan
        @endif
        @if($inspection->report_pdf_path)
            <a href="{{ route('officer.pemeriksaan.report.download', $inspection) }}" class="btn-ghost">↓ Laporan PDF</a>
        @endif
        @if($inspection->notice_pdf_path)
            <a href="{{ route('officer.pemeriksaan.notice.download', $inspection) }}" class="btn-ghost" style="color:var(--red);border-color:var(--red);">↓ Notis PDF</a>
        @endif
    </div>
</div>

@if(session('success'))
    <div style="background:var(--brand-light);border:1px solid #bbf7d0;border-radius:8px;padding:12px 16px;font-size:13px;color:var(--brand);margin-bottom:20px;">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div style="background:var(--red-bg);border:1px solid #fecaca;border-radius:8px;padding:12px 16px;font-size:13px;color:var(--red);margin-bottom:20px;">{{ $errors->first() }}</div>
@endif

{{-- Top info row --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

    <div class="card">
        <div class="card-head"><span class="card-title">Maklumat Pemeriksaan</span></div>
        <div style="padding:0;">
            @php
                $rows = [
                    ['STATUS', null],
                    ['SASARAN', $inspection->targetLabel()],
                    ['PEMERIKSA', $inspection->inspector?->name ?? '—'],
                    ['TARIKH DIJADUAL', $inspection->scheduled_for?->format('d M Y') ?? '—'],
                    ['TARIKH DIJALANKAN', $inspection->conducted_at?->format('d M Y, g:ia') ?? '—'],
                ];
                if ($inspection->notice_deadline) {
                    $rows[] = ['TARIKH AKHIR NOTIS', $inspection->notice_deadline->format('d M Y')];
                }
            @endphp
            @foreach($rows as $row)
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 18px;border-bottom:1px solid var(--border);gap:16px;">
                <span style="font-size:10.5px;font-weight:700;letter-spacing:0.06em;color:var(--text-4);flex-shrink:0;min-width:140px;">{{ $row[0] }}</span>
                @if($row[0] === 'STATUS')
                    <span class="st {{ $inspection->status->cssClass() }}">{{ $inspection->status->label() }}</span>
                @elseif($row[0] === 'TARIKH AKHIR NOTIS')
                    <span style="font-size:13px;font-weight:700;color:var(--red);">{{ $row[1] }}</span>
                @else
                    <span style="font-size:13px;color:var(--text-2);font-weight:500;text-align:right;">{{ $row[1] }}</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <div class="card">
        <div class="card-head"><span class="card-title">Rumusan</span></div>
        <div style="padding:18px;">
            @if($inspection->summary)
                <p style="font-size:13.5px;color:var(--text-2);line-height:1.7;margin:0;">{{ $inspection->summary }}</p>
            @else
                <p style="font-size:13px;color:var(--text-4);font-style:italic;margin:0;">Belum ada rumusan — pemeriksaan masih dalam proses.</p>
            @endif
        </div>

        @if($inspection->findings->isNotEmpty())
        <div style="padding:0 18px 18px;">
            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:4px;">
                @php
                    $majorCount = $inspection->findings->where('severity.value', 'major')->count();
                    $minorCount = $inspection->findings->where('severity.value', 'minor')->count();
                @endphp
                @if($majorCount)
                    <span class="st st-rej">{{ $majorCount }} Ketidakpatuhan Major</span>
                @endif
                @if($minorCount)
                    <span class="st st-rev">{{ $minorCount }} Ketidakpatuhan Kecil</span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>

{{-- Checklist --}}
@if($inspection->checklistResponses->isNotEmpty())
<div class="card" style="margin-bottom:20px;">
    <div class="card-head"><span class="card-title">Senarai Semak</span><span class="card-meta">{{ $inspection->checklistResponses->count() }} item</span></div>
    <table class="tbl">
        <thead>
            <tr><th>Kod</th><th>Perkara</th><th>Jawapan</th><th>Nota</th></tr>
        </thead>
        <tbody>
        @foreach($inspection->checklistResponses->sortBy('item.display_order') as $resp)
        <tr>
            <td><span class="app-chip">{{ $resp->item?->code }}</span></td>
            <td style="font-size:13px;">{{ $resp->item?->prompt_ms }}</td>
            <td>
                @if($resp->answer === 'Yes') <span class="st st-ok">Ya</span>
                @elseif($resp->answer === 'No') <span class="st st-rej">Tidak</span>
                @else <span class="st st-drf">T/B</span>
                @endif
            </td>
            <td style="font-size:12px;color:var(--text-3);">{{ $resp->note ?? '—' }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- Findings --}}
@if($inspection->findings->isNotEmpty())
<div class="card" style="margin-bottom:20px;">
    <div class="card-head"><span class="card-title">Penemuan Ketidakpatuhan</span><span class="card-meta">{{ $inspection->findings->count() }} penemuan</span></div>
    @foreach($inspection->findings as $i => $finding)
    <div style="padding:16px 18px;border-bottom:1px solid var(--border);">
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;flex-wrap:wrap;">
            <span style="font-size:11.5px;font-weight:700;color:var(--text-4);">{{ $i + 1 }}.</span>
            @if($finding->severity === \App\Enums\FindingSeverity::Major)
                <span class="st st-rej">Major</span>
            @else
                <span class="st st-rev">Kecil</span>
            @endif
            <span style="font-size:11px;font-weight:600;letter-spacing:0.5px;text-transform:uppercase;color:var(--text-4);">{{ $finding->category }}</span>
            @if($finding->linkedProduct)
                <span class="app-chip">{{ $finding->linkedProduct->name }}</span>
            @endif
        </div>
        <p style="font-size:13.5px;color:var(--text-2);margin:0;line-height:1.65;">{{ $finding->description }}</p>
    </div>
    @endforeach
</div>
@endif

{{-- Cancel modal --}}
<div id="cancel-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;padding:28px;max-width:420px;width:90%;box-shadow:var(--stripe-shadow);">
        <div style="font-weight:700;font-size:15px;margin-bottom:6px;color:var(--text);">Batalkan Pemeriksaan?</div>
        <div style="font-size:13px;color:var(--text-3);margin-bottom:16px;">Tindakan ini tidak boleh diundur.</div>
        <form method="POST" action="{{ route('officer.pemeriksaan.cancel', $inspection) }}">
            @csrf
            <textarea name="reason" rows="3" class="form-textarea" style="margin-bottom:14px;" placeholder="Sebab pembatalan (pilihan)..."></textarea>
            <div style="display:flex;gap:8px;">
                <button type="submit" class="btn-navy" style="background:var(--red);">Ya, Batalkan</button>
                <button type="button" onclick="document.getElementById('cancel-modal').style.display='none'" class="btn-ghost">Tutup</button>
            </div>
        </form>
    </div>
</div>

</x-layouts.officer>
