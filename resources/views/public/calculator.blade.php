<x-layouts.public title="Kalkulator Dos">

    {{-- Page header --}}
    <div class="bg-doa-700 text-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="text-xs text-green-300 mb-2">
                <a href="{{ route('home') }}" class="hover:text-white">Laman Utama</a>
                <span class="mx-1">/</span>
                <span>Kalkulator</span>
            </nav>
            <h1 class="text-2xl font-bold">Kalkulator Pengiraan Kadar/Dos Racun</h1>
            <p class="text-green-200 text-sm mt-1">Kira jumlah racun yang diperlukan berdasarkan keluasan kawasan</p>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 py-10">

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8"
             x-data="{
                 kawasan: '',
                 kadar: '',
                 unit: 'L/ha',
                 get jumlah() {
                     const k = parseFloat(this.kawasan);
                     const r = parseFloat(this.kadar);
                     if (!k || !r || k <= 0 || r <= 0) return null;
                     return (k * r).toFixed(2);
                 },
                 get unitLabel() {
                     return this.unit.split('/')[0];
                 }
             }">

            <h2 class="text-lg font-bold text-gray-800 mb-6">Parameter Pengiraan</h2>

            <div class="space-y-5">
                {{-- Keluasan kawasan --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Keluasan Kawasan
                        <span class="text-gray-400 font-normal">(hektar)</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="number" x-model="kawasan" min="0" step="0.01" placeholder="Contoh: 2.5"
                               class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-doa-400 focus:border-transparent"/>
                        <span class="text-sm text-gray-500 font-medium w-12">ha</span>
                    </div>
                </div>

                {{-- Kadar disyorkan --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Kadar Disyorkan
                        <span class="text-gray-400 font-normal">(berdasarkan label produk)</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="number" x-model="kadar" min="0" step="0.001" placeholder="Contoh: 4.0"
                               class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-doa-400 focus:border-transparent"/>
                        <span class="text-sm text-gray-500 font-medium w-12" x-text="unit"></span>
                    </div>
                </div>

                {{-- Unit --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Unit Pengiraan</label>
                    <select x-model="unit"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-doa-400 focus:border-transparent">
                        <option value="L/ha">L/ha (Liter per Hektar)</option>
                        <option value="mL/ha">mL/ha (Mililiter per Hektar)</option>
                        <option value="kg/ha">kg/ha (Kilogram per Hektar)</option>
                        <option value="g/ha">g/ha (Gram per Hektar)</option>
                    </select>
                </div>
            </div>

            {{-- Result --}}
            <div class="mt-8 p-6 rounded-xl border-2 transition-colors"
                 :class="jumlah ? 'bg-doa-50 border-doa-200' : 'bg-gray-50 border-gray-200'">
                <p class="text-xs font-semibold uppercase tracking-wide mb-2"
                   :class="jumlah ? 'text-doa-600' : 'text-gray-400'">
                    Jumlah yang Diperlukan
                </p>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold"
                          :class="jumlah ? 'text-doa-700' : 'text-gray-300'"
                          x-text="jumlah ? jumlah : '—'"></span>
                    <span class="text-lg font-semibold"
                          :class="jumlah ? 'text-doa-500' : 'text-gray-300'"
                          x-text="jumlah ? unitLabel : ''"></span>
                </div>
                <p class="text-xs mt-2" :class="jumlah ? 'text-doa-500' : 'text-gray-400'"
                   x-show="jumlah">
                    Pengiraan: <span x-text="kawasan"></span> ha &times; <span x-text="kadar"></span> <span x-text="unit"></span>
                </p>
                <p class="text-xs text-gray-400 mt-1" x-show="!jumlah">Masukkan nilai di atas untuk melihat keputusan</p>
            </div>

            {{-- Quick reference --}}
            <div class="mt-6 bg-gray-50 rounded-lg p-4">
                <h3 class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-3">Rujukan Pantas Penukaran Unit</h3>
                <div class="grid grid-cols-2 gap-2 text-xs text-gray-500">
                    <div>1 hektar = 10,000 m&sup2;</div>
                    <div>1 L = 1,000 mL</div>
                    <div>1 kg = 1,000 g</div>
                    <div>1 ekar = 0.405 ha</div>
                </div>
            </div>
        </div>

        {{-- Disclaimer --}}
        <div class="mt-6 bg-amber-50 border border-amber-200 rounded-xl p-5 flex gap-3">
            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <p class="text-sm text-amber-700">
                <span class="font-semibold">Penafian:</span>
                Pengiraan ini adalah untuk panduan sahaja. Sila rujuk label produk untuk arahan sebenar.
                Kadar penggunaan mungkin berbeza mengikut jenis perosak, tanaman, dan keadaan persekitaran.
                Pastikan penggunaan racun mematuhi peraturan di bawah Akta Racun Makhluk Perosak 1974 (Akta 149).
            </p>
        </div>
    </div>

</x-layouts.public>
