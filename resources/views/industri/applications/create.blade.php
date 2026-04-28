<x-layouts.industri>
    <x-slot name="title">Permohonan Baharu</x-slot>

    <div style="margin-bottom:20px;">
        <a href="{{ route('industri.applications.index') }}"
           style="display:inline-flex;align-items:center;gap:5px;font-size:13px;color:var(--text-3);text-decoration:none;transition:color .15s;"
           onmouseover="this.style.color='var(--brand)'" onmouseout="this.style.color='var(--text-3)'">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Senarai
        </a>
        <div class="pg-title" style="margin-top:4px;">Permohonan Pendaftaran Baharu</div>
        <div class="pg-sub">Ikut langkah di bawah untuk melengkapkan permohonan pendaftaran produk.</div>
    </div>

    <livewire:industri.application-wizard />
</x-layouts.industri>
