<div class="max-w-3xl mx-auto">

    {{-- Step progress bar --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            @foreach ($stepLabels as $num => $label)
                <div class="flex flex-col items-center flex-1">
                    <div class="flex items-center w-full">
                        @if ($num > 1)
                            <div class="flex-1 h-1 {{ $step >= $num ? 'bg-green-600' : 'bg-gray-300' }}"></div>
                        @endif
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold flex-shrink-0
                            {{ $step > $num ? 'bg-green-600 text-white' : ($step === $num ? 'bg-green-700 text-white ring-4 ring-green-100' : 'bg-gray-200 text-gray-500') }}">
                            @if ($step > $num)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                {{ $num }}
                            @endif
                        </div>
                        @if ($num < $totalSteps)
                            <div class="flex-1 h-1 {{ $step > $num ? 'bg-green-600' : 'bg-gray-300' }}"></div>
                        @endif
                    </div>
                    <span class="mt-1 text-xs text-center {{ $step === $num ? 'text-green-700 font-semibold' : 'text-gray-500' }} hidden sm:block">
                        {{ $label }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">
            Langkah {{ $step }}: {{ $stepLabels[$step] }}
        </h2>

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                <ul class="text-sm text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Step 1: Kategori Produk --}}
        @if ($step === 1)
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kategori Produk <span class="text-red-500">*</span>
                    </label>
                    <select wire:model.live="category_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Sub-Kategori
                    </label>
                    <select wire:model="subcategory_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                            @if ($subcategories->isEmpty()) disabled @endif>
                        <option value="">-- Pilih Sub-Kategori (Pilihan) --</option>
                        @foreach ($subcategories as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                        @endforeach
                    </select>
                    @if (! $category_id)
                        <p class="text-xs text-gray-400 mt-1">Pilih kategori dahulu.</p>
                    @endif
                </div>
            </div>
        @endif

        {{-- Step 2: Butiran Produk --}}
        @if ($step === 2)
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="product_name"
                           placeholder="Contoh: RoundUp Pro 480 SL"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Jenis Formulasi
                    </label>
                    <select wire:model="formulation_type_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">-- Pilih Jenis Formulasi --</option>
                        @foreach ($formulationTypes as $ft)
                            <option value="{{ $ft->id }}">{{ $ft->code }} — {{ $ft->name_ms }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Pengeluar
                    </label>
                    <input type="text" wire:model="manufacturer_name"
                           placeholder="Nama syarikat pengeluar"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
            </div>
        @endif

        {{-- Step 3: Perawis Aktif --}}
        @if ($step === 3)
            <div class="space-y-3">
                @foreach ($ingredients as $index => $ingredient)
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Perawis Aktif</label>
                            <select wire:model="ingredients.{{ $index }}.active_ingredient_id"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="">-- Pilih Perawis --</option>
                                @foreach ($activeIngredients as $ai)
                                    <option value="{{ $ai->id }}">{{ $ai->name }}{{ $ai->cas_no ? ' (' . $ai->cas_no . ')' : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-36">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Kepekatan (%)</label>
                            <input type="number"
                                   wire:model="ingredients.{{ $index }}.concentration_percent"
                                   min="0" max="100" step="0.01"
                                   placeholder="mis: 48.0"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        @if (count($ingredients) > 1)
                            <button type="button" wire:click="removeIngredient({{ $index }})"
                                    class="mt-5 text-red-500 hover:text-red-700 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                @endforeach

                <button type="button" wire:click="addIngredient"
                        class="flex items-center gap-2 text-sm text-green-700 hover:text-green-900 font-medium mt-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Perawis
                </button>
            </div>
        @endif

        {{-- Step 4: Dokumen --}}
        @if ($step === 4)
            <div class="space-y-4">
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-800">
                    <p class="font-semibold mb-2">Maklumat Dokumen</p>
                    <p>Muat naik dokumen sokongan selepas permohonan ini dihantar. Dokumen boleh dimuat naik melalui halaman butiran permohonan.</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-700 mb-3">Dokumen Diperlukan:</p>
                    <ul class="space-y-2">
                        @foreach ([
                            'Label Produk' => 'Contoh label produk siap cetakan (PDF)',
                            'Data Teknikal' => 'Spesifikasi teknikal bahan aktif (PDF/DOCX)',
                            'Laporan Makmal' => 'Keputusan ujian makmal bertauliah (PDF)',
                            'Sijil Analisis' => 'Certificate of Analysis daripada pengeluar (PDF)',
                        ] as $docName => $description)
                            <li class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $docName }}</p>
                                    <p class="text-xs text-gray-500">{{ $description }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Step 5: Semak & Hantar --}}
        @if ($step === 5)
            <div class="space-y-5">
                {{-- Category summary --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-2">Kategori Produk</h3>
                    <div class="p-3 bg-gray-50 rounded-lg text-sm border border-gray-200 space-y-1">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Kategori</span>
                            <span class="font-medium">
                                @if ($category_id)
                                    {{ $categories->firstWhere('id', $category_id)?->name ?? '-' }}
                                @else
                                    <span class="text-red-500">Tidak dipilih</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Sub-Kategori</span>
                            <span class="font-medium">
                                {{ $subcategory_id ? ($subcategories->firstWhere('id', $subcategory_id)?->name ?? '-') : 'Tiada' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Product details summary --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-2">Butiran Produk</h3>
                    <div class="p-3 bg-gray-50 rounded-lg text-sm border border-gray-200 space-y-1">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Nama Produk</span>
                            <span class="font-medium">{{ $product_name ?: '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Jenis Formulasi</span>
                            <span class="font-medium">
                                {{ $formulation_type_id ? ($formulationTypes->firstWhere('id', $formulation_type_id)?->name_ms ?? '-') : '-' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Pengeluar</span>
                            <span class="font-medium">{{ $manufacturer_name ?: '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Active ingredients summary --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-2">Perawis Aktif</h3>
                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                        @php
                            $filledIngredients = collect($ingredients)->filter(fn($i) => !empty($i['active_ingredient_id']));
                        @endphp
                        @if ($filledIngredients->isEmpty())
                            <p class="text-sm text-gray-400">Tiada perawis aktif dipilih.</p>
                        @else
                            <ul class="space-y-1 text-sm">
                                @foreach ($filledIngredients as $row)
                                    <li class="flex justify-between">
                                        <span>{{ $activeIngredients->firstWhere('id', $row['active_ingredient_id'])?->name ?? '-' }}</span>
                                        <span class="text-gray-500">{{ $row['concentration_percent'] ? $row['concentration_percent'] . '%' : '-' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                {{-- Confirmation checkbox --}}
                <div class="flex items-start gap-3 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <input type="checkbox" wire:model="confirmed" id="confirmed"
                           class="mt-0.5 h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <label for="confirmed" class="text-sm text-gray-700">
                        Saya mengesahkan bahawa maklumat di atas adalah benar dan tepat. Saya faham bahawa maklumat palsu boleh menyebabkan permohonan ditolak atau tindakan undang-undang diambil.
                    </label>
                </div>

                <button type="button" wire:click="submit"
                        wire:loading.attr="disabled"
                        class="w-full py-3 bg-green-700 hover:bg-green-800 text-white font-semibold rounded-lg transition-colors disabled:opacity-50">
                    <span wire:loading.remove wire:target="submit">Hantar Permohonan</span>
                    <span wire:loading wire:target="submit">Menghantar...</span>
                </button>
            </div>
        @endif

        {{-- Navigation buttons --}}
        @if ($step < 5)
            <div class="flex justify-between mt-8">
                @if ($step > 1)
                    <button type="button" wire:click="previousStep"
                            class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                        Kembali
                    </button>
                @else
                    <div></div>
                @endif

                <button type="button" wire:click="nextStep"
                        wire:loading.attr="disabled"
                        class="px-6 py-2 bg-green-700 hover:bg-green-800 text-white rounded-lg text-sm font-semibold transition-colors">
                    <span wire:loading.remove wire:target="nextStep">
                        {{ $step < 4 ? 'Seterusnya' : 'Semak Permohonan' }}
                    </span>
                    <span wire:loading wire:target="nextStep">Memproses...</span>
                </button>
            </div>
        @elseif ($step === 5)
            <div class="mt-4">
                <button type="button" wire:click="previousStep"
                        class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    Kembali
                </button>
            </div>
        @endif
    </div>
</div>
