<x-layouts.public title="Laman Utama">

    {{-- Hero section --}}
    <section class="doa-hero-bg text-white">
        <div class="max-w-7xl mx-auto px-4 py-16 md:py-24 text-center">
            <p class="text-gold-400 text-sm font-semibold uppercase tracking-widest mb-3">Portal Rasmi</p>
            <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-4">
                {{ __('app.home.hero_title') }}
            </h1>
            <p class="text-green-200 text-lg md:text-xl mb-10">{{ __('app.home.hero_subtitle') }}</p>

            {{-- Hero search bar --}}
            <div class="max-w-2xl mx-auto">
                <form action="{{ route('products.search') }}" method="GET" class="flex gap-2">
                    <input
                        type="text"
                        name="q"
                        placeholder="{{ __('app.home.search_placeholder') }}"
                        class="flex-1 px-5 py-3.5 rounded-lg text-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-gold-400 shadow-lg"
                    />
                    <button type="submit"
                            class="px-6 py-3.5 bg-gold-400 text-doa-800 font-semibold rounded-lg hover:bg-gold-500 transition-colors shadow-lg whitespace-nowrap text-sm">
                        Cari Produk
                    </button>
                </form>
                <p class="text-green-300 text-xs mt-3">Contoh: Glyphosate, BKRPB-001, Roundup</p>
            </div>
        </div>
    </section>

    {{-- Stats strip --}}
    <section class="bg-doa-800 text-white">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-doa-700">
                <div class="text-center py-4 md:py-0 md:px-8">
                    <p class="text-3xl font-bold text-gold-400">{{ number_format($stats['total_registered_products']) }}</p>
                    <p class="text-green-200 text-sm mt-1">Produk Berdaftar Aktif</p>
                </div>
                <div class="text-center py-4 md:py-0 md:px-8">
                    <p class="text-3xl font-bold text-gold-400">{{ number_format($stats['total_companies']) }}</p>
                    <p class="text-green-200 text-sm mt-1">Syarikat Berdaftar</p>
                </div>
                <div class="text-center py-4 md:py-0 md:px-8">
                    <p class="text-3xl font-bold text-gold-400">{{ number_format($stats['total_applications_this_year']) }}</p>
                    <p class="text-green-200 text-sm mt-1">Permohonan Tahun Ini</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Livewire real-time search --}}
    <section class="max-w-7xl mx-auto px-4 py-10">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Carian Pantas Produk Berdaftar</h2>
        <livewire:public.product-search />
    </section>

    {{-- Feature cards --}}
    <section class="bg-white py-14">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-doa-700 text-center mb-2">Perkhidmatan myLRMP</h2>
            <p class="text-gray-500 text-center text-sm mb-10">Akses semua perkhidmatan Jabatan Pertanian dalam satu platform</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Card 1 --}}
                <a href="{{ route('products.search') }}"
                   class="group block p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md hover:border-doa-300 transition-all">
                    <div class="w-12 h-12 bg-doa-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-doa-100 transition-colors">
                        <svg class="w-6 h-6 text-doa-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Cari Produk Berdaftar</h3>
                    <p class="text-sm text-gray-500">Semak status pendaftaran, bahan aktif dan butiran sijil produk racun makhluk perosak.</p>
                    <span class="mt-4 inline-block text-doa-600 text-sm font-medium group-hover:underline">Cari sekarang &rarr;</span>
                </a>

                {{-- Card 2 --}}
                <a href="{{ route('industri.register') }}"
                   class="group block p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md hover:border-doa-300 transition-all">
                    <div class="w-12 h-12 bg-doa-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-doa-100 transition-colors">
                        <svg class="w-6 h-6 text-doa-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Mohon Pendaftaran</h3>
                    <p class="text-sm text-gray-500">Daftarkan syarikat dan mohon pendaftaran produk racun makhluk perosak baharu.</p>
                    <span class="mt-4 inline-block text-doa-600 text-sm font-medium group-hover:underline">Daftar sekarang &rarr;</span>
                </a>

                {{-- Card 3 --}}
                <a href="{{ route('calculator') }}"
                   class="group block p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md hover:border-doa-300 transition-all">
                    <div class="w-12 h-12 bg-doa-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-doa-100 transition-colors">
                        <svg class="w-6 h-6 text-doa-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Kalkulator Dos</h3>
                    <p class="text-sm text-gray-500">Kira jumlah racun yang diperlukan berdasarkan keluasan kawasan dan kadar disyorkan.</p>
                    <span class="mt-4 inline-block text-doa-600 text-sm font-medium group-hover:underline">Kira sekarang &rarr;</span>
                </a>
            </div>
        </div>
    </section>

    {{-- Pautan Berguna --}}
    <section class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-xl font-bold text-doa-700 mb-6">Pautan Berguna</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <a href="https://www.doa.gov.my" target="_blank" rel="noopener"
               class="flex items-center gap-3 p-4 bg-white border border-gray-200 rounded-lg hover:border-doa-300 hover:shadow-sm transition-all text-sm text-gray-700 hover:text-doa-700">
                <svg class="w-4 h-4 text-doa-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Laman Web DOA
            </a>
            <a href="https://www.moa.gov.my" target="_blank" rel="noopener"
               class="flex items-center gap-3 p-4 bg-white border border-gray-200 rounded-lg hover:border-doa-300 hover:shadow-sm transition-all text-sm text-gray-700 hover:text-doa-700">
                <svg class="w-4 h-4 text-doa-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Kementerian Pertanian
            </a>
            <a href="https://www.myipo.gov.my" target="_blank" rel="noopener"
               class="flex items-center gap-3 p-4 bg-white border border-gray-200 rounded-lg hover:border-doa-300 hover:shadow-sm transition-all text-sm text-gray-700 hover:text-doa-700">
                <svg class="w-4 h-4 text-doa-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                MyIPO
            </a>
            <a href="https://www.ssm.com.my" target="_blank" rel="noopener"
               class="flex items-center gap-3 p-4 bg-white border border-gray-200 rounded-lg hover:border-doa-300 hover:shadow-sm transition-all text-sm text-gray-700 hover:text-doa-700">
                <svg class="w-4 h-4 text-doa-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                SSM Malaysia
            </a>
        </div>
    </section>

</x-layouts.public>
