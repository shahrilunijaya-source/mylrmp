<div>
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <div class="flex flex-col sm:flex-row gap-3 mb-4">
            <input type="text"
                   wire:model.debounce.300ms="query"
                   placeholder="Taip nama produk atau nombor pendaftaran..."
                   class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-doa-400 focus:border-transparent"/>
            <select wire:model.live="formulationType"
                    class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-doa-400 focus:border-transparent">
                <option value="">Semua Formulasi</option>
                @foreach($formulationTypes as $ft)
                    <option value="{{ $ft->id }}">{{ $ft->name_ms }}</option>
                @endforeach
            </select>
        </div>

        {{-- Loading indicator --}}
        <div wire:loading class="text-xs text-doa-500 mb-2 flex items-center gap-1.5">
            <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            Mencari...
        </div>

        {{-- Results --}}
        <div wire:loading.remove>
            @if(strlen($query) >= 2 || $formulationType)
                @if($results->isEmpty())
                    <p class="text-sm text-gray-400 text-center py-6">Tiada produk dijumpai.</p>
                @else
                    <p class="text-xs text-gray-400 mb-3">{{ $results->count() }} rekod dijumpai</p>
                    <div class="divide-y divide-gray-100">
                        @foreach($results as $product)
                            <a href="{{ route('products.show', $product) }}"
                               class="flex items-center justify-between py-2.5 hover:bg-gray-50 px-2 -mx-2 rounded transition-colors group">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-800 group-hover:text-doa-700 truncate">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-400 font-mono">{{ $product->registration_no }}</p>
                                </div>
                                <div class="flex items-center gap-2 ml-3 flex-shrink-0">
                                    @if($product->formulationType)
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded hidden sm:block">
                                            {{ $product->formulationType->name_ms }}
                                        </span>
                                    @endif
                                    <svg class="w-4 h-4 text-gray-300 group-hover:text-doa-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            @else
                <p class="text-xs text-gray-400 text-center py-4">Taip sekurang-kurangnya 2 aksara untuk mencari produk</p>
            @endif
        </div>
    </div>
</div>
