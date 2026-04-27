<x-layouts.industri>
    <x-slot name="title">Permohonan Baharu</x-slot>

    <div class="mb-5">
        <a href="{{ route('industri.applications.index') }}"
           class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Senarai
        </a>
        <h2 class="text-xl font-bold text-gray-800 mt-1">Permohonan Pendaftaran Baharu</h2>
        <p class="text-sm text-gray-500 mt-0.5">Ikut langkah di bawah untuk melengkapkan permohonan pendaftaran produk.</p>
    </div>

    <livewire:industri.application-wizard />
</x-layouts.industri>
