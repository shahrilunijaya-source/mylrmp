<x-layouts.public title="Carian Produk">

    {{-- Page header --}}
    <div class="bg-doa-700 text-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="text-xs text-green-300 mb-2">
                <a href="{{ route('home') }}" class="hover:text-white">Laman Utama</a>
                <span class="mx-1">/</span>
                <span>Carian Produk</span>
            </nav>
            <h1 class="text-2xl font-bold">Carian Produk Berdaftar</h1>
            <p class="text-green-200 text-sm mt-1">Semak status pendaftaran produk racun makhluk perosak</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">

        {{-- Search form --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-8">
            <form action="{{ route('products.search') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-1">
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Carian</label>
                        <input type="text" name="q" value="{{ $query }}"
                               placeholder="Nama produk, No. Pendaftaran atau Bahan Aktif..."
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-doa-400 focus:border-transparent"/>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Jenis Formulasi</label>
                        <select name="formulation_type_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-doa-400 focus:border-transparent">
                            <option value="">-- Semua --</option>
                            @foreach($formulationTypes as $ft)
                                <option value="{{ $ft->id }}" {{ $formulationTypeId == $ft->id ? 'selected' : '' }}>
                                    {{ $ft->name_ms }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Kategori</label>
                        <select name="category_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-doa-400 focus:border-transparent">
                            <option value="">-- Semua --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name_ms }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="px-6 py-2.5 bg-doa-600 text-white text-sm font-semibold rounded-lg hover:bg-doa-700 transition-colors">
                        Cari
                    </button>
                    @if($query || $formulationTypeId || $categoryId)
                        <a href="{{ route('products.search') }}"
                           class="px-4 py-2.5 text-sm text-gray-600 hover:text-gray-800 transition-colors">
                            Kosongkan
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Real-time search widget --}}
        <div class="mb-8">
            <livewire:public.product-search />
        </div>

        {{-- Results --}}
        @if($products->isEmpty())
            <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-gray-500 font-medium">Tiada rekod dijumpai. Cuba carian lain.</p>
                <a href="{{ route('products.search') }}" class="mt-3 inline-block text-doa-600 text-sm hover:underline">Lihat semua produk</a>
            </div>
        @else
            <div class="mb-4 flex items-center justify-between">
                <p class="text-sm text-gray-500">
                    Menunjukkan <span class="font-semibold text-gray-700">{{ $products->firstItem() }}–{{ $products->lastItem() }}</span>
                    daripada <span class="font-semibold text-gray-700">{{ $products->total() }}</span> rekod
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product) }}"
                       class="block bg-white border border-gray-200 rounded-xl p-5 hover:shadow-md hover:border-doa-300 transition-all group">
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <span class="text-xs font-mono font-semibold text-doa-600 bg-doa-50 px-2 py-0.5 rounded">
                                {{ $product->registration_no }}
                            </span>
                            @php
                                $statusClass = match($product->status->value) {
                                    'active'    => 'bg-green-100 text-green-700',
                                    'expired'   => 'bg-amber-100 text-amber-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    default     => 'bg-gray-100 text-gray-600',
                                };
                            @endphp
                            <span class="text-xs font-semibold px-2 py-0.5 rounded {{ $statusClass }}">
                                {{ $product->status->label() }}
                            </span>
                        </div>
                        <h3 class="font-semibold text-gray-800 text-sm leading-snug mb-3 group-hover:text-doa-700 transition-colors">
                            {{ $product->name }}
                        </h3>
                        <div class="space-y-1 text-xs text-gray-500">
                            <div class="flex gap-2">
                                <span class="w-24 flex-shrink-0 font-medium text-gray-400">Pendaftar</span>
                                <span class="truncate">{{ $product->registrant?->name ?? '—' }}</span>
                            </div>
                            <div class="flex gap-2">
                                <span class="w-24 flex-shrink-0 font-medium text-gray-400">Formulasi</span>
                                <span>{{ $product->formulationType?->name_ms ?? '—' }}</span>
                            </div>
                            @if($product->expires_at)
                                <div class="flex gap-2">
                                    <span class="w-24 flex-shrink-0 font-medium text-gray-400">Tamat</span>
                                    <span>{{ $product->expires_at->format('d/m/Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="flex justify-center">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</x-layouts.public>
