<x-layouts.officer title="Butiran Premis">

<div class="pg-head">
    <div>
        <div class="pg-title">{{ $premis->name }}</div>
        <div class="pg-sub">{{ $premis->license_no ?? 'Tiada No. Lesen' }} &mdash; {{ $premis->state?->label() ?? '' }}</div>
    </div>
    @can('premises.edit')
    <a href="{{ route('officer.premis.edit', $premis) }}" class="btn-ghost">Sunting</a>
    @endcan
</div>

@if(session('success'))
    <div style="background:var(--brand-light);border:1px solid #bbf7d0;border-radius:8px;padding:12px 16px;font-size:13px;color:var(--brand);margin-bottom:20px;">
        {{ session('success') }}
    </div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

    <div class="card">
        <div class="card-head"><span class="card-title">Maklumat Premis</span></div>
        <div style="padding:0;">
            @foreach([
                ['label' => 'NAMA', 'value' => $premis->name],
                ['label' => 'NO. LESEN', 'value' => $premis->license_no ?? '—'],
                ['label' => 'ALAMAT', 'value' => implode(', ', array_filter([$premis->address_line1, $premis->address_line2, $premis->postcode, $premis->district, $premis->state?->label()]))],
                ['label' => 'PIC', 'value' => implode(' ', array_filter([$premis->pic_name, $premis->pic_phone ? '(' . $premis->pic_phone . ')' : null])) ?: '—'],
                ['label' => 'SYARIKAT PEMILIK', 'value' => $premis->ownerCompany?->name ?? '—'],
            ] as $row)
            <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:11px 18px;border-bottom:1px solid var(--border);gap:16px;">
                <span style="font-size:10.5px;font-weight:700;letter-spacing:0.06em;color:var(--text-4);flex-shrink:0;min-width:140px;">{{ $row['label'] }}</span>
                <span style="font-size:13px;color:var(--text-2);font-weight:500;text-align:right;">{{ $row['value'] }}</span>
            </div>
            @endforeach
            <div style="display:flex;justify-content:space-between;align-items:center;padding:11px 18px;gap:16px;">
                <span style="font-size:10.5px;font-weight:700;letter-spacing:0.06em;color:var(--text-4);">STATUS</span>
                @if($premis->is_active)<span class="st st-ok">Aktif</span>@else<span class="st st-drf">Tidak Aktif</span>@endif
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <span class="card-title">Sejarah Pemeriksaan</span>
            @can('inspections.schedule')
            <a href="{{ route('officer.pemeriksaan.create', ['target_type' => 'premises', 'target_id' => $premis->id]) }}" class="btn-navy" style="font-size:12px;padding:5px 12px;">+ Jadual</a>
            @endcan
        </div>
        @forelse($premis->inspections->sortByDesc('scheduled_for') as $insp)
            <div style="padding:12px 18px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <a href="{{ route('officer.pemeriksaan.show', $insp) }}" style="font-weight:600;color:var(--navy);text-decoration:none;font-size:13px;">{{ $insp->inspection_no }}</a>
                    <div style="font-size:11.5px;color:var(--text-4);margin-top:2px;">{{ $insp->scheduled_for?->format('d M Y') }}</div>
                </div>
                <span class="st {{ $insp->status->cssClass() }}">{{ $insp->status->label() }}</span>
            </div>
        @empty
            <div style="padding:24px;color:var(--text-4);font-size:13px;text-align:center;">Tiada sejarah pemeriksaan.</div>
        @endforelse
    </div>

</div>

</x-layouts.officer>
