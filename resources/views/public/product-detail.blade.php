<x-layouts.public :title="$product->name">

    {{-- Page header --}}
    <div style="background: #004d28;" class="text-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="text-xs text-green-300 mb-2">
                <a href="{{ route('home') }}" class="hover:text-white">Laman Utama</a>
                <span class="mx-1">/</span>
                <a href="{{ route('products.search') }}" class="hover:text-white">Carian Produk</a>
                <span class="mx-1">/</span>
                <span>{{ $product->registration_no }}</span>
            </nav>
            <div class="flex flex-wrap items-start gap-4">
                <div class="flex-1 min-w-0">
                    <p style="color: #FFCC00;" class="text-sm font-mono font-semibold mb-1">{{ $product->registration_no }}</p>
                    <h1 class="text-2xl md:text-3xl font-bold leading-tight">{{ $product->name }}</h1>
                </div>
                @php
                    $badgeClass = match($product->status->value) {
                        'active'    => 'bg-green-500 text-white',
                        'expired'   => 'bg-amber-500 text-white',
                        'cancelled' => 'bg-red-500 text-white',
                        default     => 'bg-gray-500 text-white',
                    };
                @endphp
                <span class="px-4 py-1.5 rounded-full text-sm font-bold {{ $badgeClass }} self-start">
                    {{ $product->status->label() }}
                </span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Left: Butiran Produk --}}
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h2 class="text-base font-bold mb-5 pb-3 border-b border-gray-100" style="color: #004d28;">Butiran Produk</h2>
                <dl class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:gap-4">
                        <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-40 flex-shrink-0 mb-0.5 sm:mb-0 pt-0.5">No. Pendaftaran</dt>
                        <dd class="text-sm font-mono font-semibold" style="color: #004d28;">{{ $product->registration_no }}</dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:gap-4">
                        <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-40 flex-shrink-0 mb-0.5 sm:mb-0 pt-0.5">Nama Produk</dt>
                        <dd class="text-sm text-gray-800 font-medium">{{ $product->name }}</dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:gap-4">
                        <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-40 flex-shrink-0 mb-0.5 sm:mb-0 pt-0.5">Jenis Formulasi</dt>
                        <dd class="text-sm text-gray-700">{{ $product->formulationType?->name_ms ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:gap-4">
                        <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-40 flex-shrink-0 mb-0.5 sm:mb-0 pt-0.5">Syarikat Pendaftar</dt>
                        <dd class="text-sm text-gray-700">{{ $product->registrant?->name ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:gap-4">
                        <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-40 flex-shrink-0 mb-0.5 sm:mb-0 pt-0.5">Tarikh Pendaftaran</dt>
                        <dd class="text-sm text-gray-700">{{ $product->created_at?->format('d/m/Y') ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:gap-4">
                        <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-40 flex-shrink-0 mb-0.5 sm:mb-0 pt-0.5">Tarikh Tamat</dt>
                        <dd class="text-sm {{ $product->expires_at && $product->expires_at->isPast() ? 'text-amber-600 font-semibold' : 'text-gray-700' }}">
                            {{ $product->expires_at?->format('d/m/Y') ?? '—' }}
                        </dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:gap-4">
                        <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-40 flex-shrink-0 mb-0.5 sm:mb-0 pt-0.5">Status</dt>
                        <dd>
                            <span class="text-sm font-semibold px-2.5 py-0.5 rounded {{ $badgeClass }}">
                                {{ $product->status->label() }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Right: Perawis Aktif (Active Ingredients) --}}
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h2 class="text-base font-bold mb-5 pb-3 border-b border-gray-100" style="color: #004d28;">Perawis Aktif (Bahan Aktif)</h2>
                @if($product->activeIngredients->isEmpty())
                    <p class="text-sm text-gray-400 italic">Tiada bahan aktif direkodkan.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="text-left px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wide rounded-l">Nama Bahan Aktif</th>
                                    <th class="text-left px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wide">No. CAS</th>
                                    <th class="text-right px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wide rounded-r">Kepekatan (%)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($product->activeIngredients as $ai)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-3 font-medium text-gray-800">{{ $ai->name }}</td>
                                        <td class="px-3 py-3 font-mono text-gray-500 text-xs">{{ $ai->cas_no ?? '—' }}</td>
                                        <td class="px-3 py-3 text-right text-gray-700">
                                            {{ $ai->pivot->concentration_percent !== null ? $ai->pivot->concentration_percent . '%' : '—' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Certificate section --}}
        @if($product->certificate)
            <div class="mt-6 bg-white border border-gray-200 rounded-xl p-6">
                <h2 class="text-base font-bold mb-5 pb-3 border-b border-gray-100" style="color: #004d28;">Sijil Pendaftaran</h2>
                <div class="flex flex-wrap items-center gap-6">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold mb-1">No. Sijil</p>
                        <p class="text-sm font-mono font-bold" style="color: #004d28;">{{ $product->certificate->certificate_no ?? '—' }}</p>
                    </div>
                    @if($product->certificate->issued_at)
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold mb-1">Tarikh Dikeluarkan</p>
                            <p class="text-sm text-gray-700">{{ $product->certificate->issued_at->format('d/m/Y') }}</p>
                        </div>
                    @endif
                    @if($product->certificate->expires_at)
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold mb-1">Sah Hingga</p>
                            <p class="text-sm text-gray-700">{{ $product->certificate->expires_at->format('d/m/Y') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- CTA --}}
        <div class="mt-8 rounded-xl p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
             style="background: #f0fdf4; border: 1px solid #bbf7d0;">
            <div>
                <h3 class="font-semibold mb-1" style="color: #004d28;">Ada pertanyaan mengenai produk ini?</h3>
                <p class="text-sm text-gray-600">Hubungi Bahagian Kawalan Racun Makhluk Perosak (BKRPB) untuk maklumat lanjut.</p>
            </div>
            <a href="#hubungi"
               class="flex-shrink-0 px-6 py-2.5 text-white text-sm font-semibold rounded-lg transition-colors"
               style="background: #006837;"
               onmouseover="this.style.background='#004d28'"
               onmouseout="this.style.background='#006837'">
                Hubungi BKRPB
            </a>
        </div>

        {{-- Back link --}}
        <div class="mt-6">
            <a href="{{ route('products.search') }}" class="text-sm hover:underline" style="color: #006837;">&larr; Kembali ke Carian Produk</a>
        </div>
    </div>

</x-layouts.public>
