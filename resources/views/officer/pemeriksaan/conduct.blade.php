<x-layouts.officer title="Jalankan Pemeriksaan — {{ $inspection->inspection_no }}">

<div class="pg-head">
    <div>
        <div class="pg-title">Jalankan Pemeriksaan</div>
        <div class="pg-sub">{{ $inspection->inspection_no }} &mdash; {{ $inspection->targetLabel() }}</div>
    </div>
</div>

@livewire('officer.inspection-conduct-wizard', ['inspection' => $inspection])

</x-layouts.officer>
