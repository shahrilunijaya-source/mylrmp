<x-layouts.industri title="Butiran Pemeriksaan — {{ $inspection->inspection_no }}">

<div class="page-back-wrap" style="margin-bottom:20px;">
    <a href="{{ route('industri.pemeriksaan.index') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:var(--text-3);text-decoration:none;">
        <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.5 3L5 8l5.5 5"/></svg>
        Kembali ke Rekod Pemeriksaan
    </a>
</div>

<div class="pg-head">
    <div>
        <div class="pg-title">{{ $inspection->inspection_no }}</div>
        <div class="pg-sub">{{ $inspection->conducted_at?->format('d M Y') ?? $inspection->scheduled_for?->format('d M Y') }}</div>
    </div>
    <div style="display:flex;gap:8px;">
        @if($inspection->report_pdf_path)
            <a href="{{ route('officer.pemeriksaan.report.download', $inspection) }}" class="btn-primary" style="font-size:12.5px;">
                ↓ Laporan PDF
            </a>
        @endif
        @if($inspection->notice_pdf_path)
            <a href="{{ route('officer.pemeriksaan.notice.download', $inspection) }}"
               style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:var(--red-bg);color:var(--red);border:1px solid #fecaca;border-radius:4px;font-size:12.5px;font-weight:500;text-decoration:none;">
                ↓ Notis Ketidakpatuhan
            </a>
        @endif
    </div>
</div>

{{-- Status banner if there's a notice --}}
@if($inspection->status === \App\Enums\InspectionStatus::MajorNC)
<div style="background:var(--red-bg);border:1px solid #fecaca;border-radius:8px;padding:16px 18px;margin-bottom:20px;display:flex;gap:14px;align-items:flex-start;">
    <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor" style="color:var(--red);flex-shrink:0;margin-top:1px;">
        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
    </svg>
    <div>
        <div style="font-weight:700;color:var(--red);font-size:14px;margin-bottom:3px;">Ketidakpatuhan Major Dikesan</div>
        <div style="font-size:13px;color:var(--red);line-height:1.5;">
            Sila ambil tindakan pembetulan segera.
            @if($inspection->notice_deadline)
                Tarikh akhir: <strong>{{ $inspection->notice_deadline->format('d M Y') }}</strong>.
            @endif
        </div>
    </div>
</div>
@elseif($inspection->status === \App\Enums\InspectionStatus::MinorNC)
<div style="background:var(--amber-bg);border:1px solid #fde68a;border-radius:8px;padding:16px 18px;margin-bottom:20px;display:flex;gap:14px;align-items:flex-start;">
    <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor" style="color:var(--amber);flex-shrink:0;margin-top:1px;">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
    </svg>
    <div>
        <div style="font-weight:700;color:var(--amber);font-size:14px;margin-bottom:3px;">Ketidakpatuhan Kecil Dikesan</div>
        <div style="font-size:13px;color:var(--amber);line-height:1.5;">
            Sila perbetulkan isu yang disenaraikan di bawah.
            @if($inspection->notice_deadline)
                Tarikh akhir: <strong>{{ $inspection->notice_deadline->format('d M Y') }}</strong>.
            @endif
        </div>
    </div>
</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

    <div class="card">
        <div class="card-head"><span class="card-title">Maklumat Pemeriksaan</span></div>
        <div style="padding:0;">
            @foreach([
                ['STATUS', null],
                ['PEMERIKSA', $inspection->inspector?->name ?? '—'],
                ['TARIKH DIJADUAL', $inspection->scheduled_for?->format('d M Y') ?? '—'],
                ['TARIKH DIJALANKAN', $inspection->conducted_at?->format('d M Y') ?? '—'],
                $inspection->notice_deadline ? ['TARIKH AKHIR NOTIS', $inspection->notice_deadline->format('d M Y')] : null,
            ] as $row)
            @if(!$row) @continue @endif
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 18px;border-bottom:1px solid var(--border);gap:16px;">
                <span style="font-size:10.5px;font-weight:700;letter-spacing:0.06em;color:var(--text-4);flex-shrink:0;min-width:140px;">{{ $row[0] }}</span>
                @if($row[0] === 'STATUS')
                    <span class="st {{ $inspection->status->cssClass() }}">{{ $inspection->status->label() }}</span>
                @elseif($row[0] === 'TARIKH AKHIR NOTIS')
                    <span style="font-size:13px;font-weight:700;color:var(--red);">{{ $row[1] }}</span>
                @else
                    <span style="font-size:13px;color:var(--text-2);font-weight:500;">{{ $row[1] }}</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <div class="card">
        <div class="card-head"><span class="card-title">Rumusan Pegawai Pemeriksa</span></div>
        <div style="padding:18px;">
            @if($inspection->summary)
                <p style="font-size:13.5px;color:var(--text-2);line-height:1.7;margin:0;">{{ $inspection->summary }}</p>
            @else
                <p style="font-size:13px;color:var(--text-4);font-style:italic;margin:0;">Tiada rumusan.</p>
            @endif
        </div>
    </div>

</div>

{{-- Findings if any --}}
@if($inspection->findings->isNotEmpty())
<div class="card" style="margin-bottom:20px;">
    <div class="card-head">
        <span class="card-title">Penemuan Ketidakpatuhan</span>
        <span class="card-meta">{{ $inspection->findings->count() }} penemuan</span>
    </div>
    @foreach($inspection->findings as $i => $finding)
    <div style="padding:16px 18px;border-bottom:1px solid var(--border);{{ !$loop->last ? '' : 'border-bottom:none;' }}">
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

{{-- Checklist (read-only) --}}
@if($inspection->checklistResponses->isNotEmpty())
<div class="card">
    <div class="card-head">
        <span class="card-title">Senarai Semak</span>
        <span class="card-meta">
            {{ $inspection->checklistResponses->where('answer', 'Yes')->count() }} akur &bull;
            {{ $inspection->checklistResponses->where('answer', 'No')->count() }} tidak akur
        </span>
    </div>
    <table class="tbl">
        <thead>
            <tr><th>Perkara</th><th>Jawapan</th><th>Nota</th></tr>
        </thead>
        <tbody>
        @foreach($inspection->checklistResponses->sortBy('item.display_order') as $resp)
        <tr>
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

</x-layouts.industri>
