<x-layouts.public title="{{ __('app.calculator.title') }}">

    {{-- Page header --}}
    <div style="background: linear-gradient(135deg, #006837 0%, #004d28 60%, #003d20 100%); padding: 32px 0;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 16px;">
            <nav style="font-size: 12px; color: #86efac; margin-bottom: 8px;">
                <a href="{{ route('home') }}" style="color: #86efac; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#86efac'">{{ __('app.nav.home') }}</a>
                <span style="margin: 0 6px; opacity: 0.5;">/</span>
                <span style="color: #d1fae5;">{{ __('app.nav.calculator') }}</span>
            </nav>
            <h1 style="color: white; font-size: 26px; font-weight: 700; letter-spacing: -0.02em; margin: 0 0 4px;">{{ __('app.calculator.title') }}</h1>
            <p style="color: #86efac; font-size: 14px; margin: 0;">Kira jumlah racun yang diperlukan berdasarkan keluasan kawasan</p>
        </div>
    </div>

    <div style="max-width: 1280px; margin: 0 auto; padding: 40px 16px;">

        <div style="max-width: 600px; margin: 0 auto;">
            <div style="background: white; border-radius: 16px; border: 1px solid #e5e7eb; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);"
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

                <h2 style="font-size: 18px; font-weight: 600; letter-spacing: -0.02em; color: #111827; margin: 0 0 24px;">Parameter Pengiraan</h2>

                <div style="display: flex; flex-direction: column; gap: 20px;">
                    {{-- Keluasan kawasan --}}
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 6px;">
                            {{ __('app.calculator.area') }}
                        </label>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <input type="number" x-model="kawasan" min="0" step="0.01" placeholder="Contoh: 2.5"
                                   class="search-input" style="flex: 1;"/>
                            <span style="font-size: 14px; color: #6b7280; font-weight: 500; width: 28px; text-align: right; flex-shrink: 0;">ha</span>
                        </div>
                    </div>

                    {{-- Kadar disyorkan --}}
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 6px;">
                            {{ __('app.calculator.rate') }}
                            <span style="color: #9ca3af; font-weight: 400;">(berdasarkan label produk)</span>
                        </label>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <input type="number" x-model="kadar" min="0" step="0.001" placeholder="Contoh: 4.0"
                                   class="search-input" style="flex: 1;"/>
                            <span style="font-size: 14px; color: #6b7280; font-weight: 500; width: 40px; text-align: right; flex-shrink: 0;" x-text="unit"></span>
                        </div>
                    </div>

                    {{-- Unit --}}
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 6px;">Unit Pengiraan</label>
                        <select x-model="unit" class="search-input" style="cursor: pointer;">
                            <option value="L/ha">L/ha (Liter per Hektar)</option>
                            <option value="mL/ha">mL/ha (Mililiter per Hektar)</option>
                            <option value="kg/ha">kg/ha (Kilogram per Hektar)</option>
                            <option value="g/ha">g/ha (Gram per Hektar)</option>
                        </select>
                    </div>
                </div>

                {{-- Result --}}
                <div style="margin-top: 28px; border-radius: 10px; padding: 20px; transition: all 0.2s;"
                     :style="jumlah ? 'background: #f0fdf4; border: 1px solid #bbf7d0;' : 'background: #f9fafb; border: 1px solid #e5e7eb;'">
                    <p style="font-size: 11px; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; margin: 0 0 8px;"
                       :style="jumlah ? 'color: #006837;' : 'color: #9ca3af;'">
                        {{ __('app.calculator.result') }}
                    </p>
                    <div style="display: flex; align-items: baseline; gap: 8px;">
                        <span style="font-size: 36px; font-weight: 700; letter-spacing: -0.03em; line-height: 1;"
                              :style="jumlah ? 'color: #15803d;' : 'color: #d1d5db;'"
                              x-text="jumlah ? jumlah : '—'"></span>
                        <span style="font-size: 18px; font-weight: 600;"
                              :style="jumlah ? 'color: #16a34a;' : 'color: #d1d5db;'"
                              x-text="jumlah ? unitLabel : ''"></span>
                    </div>
                    <p style="font-size: 12px; margin: 8px 0 0; color: #16a34a;" x-show="jumlah">
                        Pengiraan: <span x-text="kawasan"></span> ha &times; <span x-text="kadar"></span> <span x-text="unit"></span>
                    </p>
                    <p style="font-size: 12px; color: #9ca3af; margin: 4px 0 0;" x-show="!jumlah">Masukkan nilai di atas untuk melihat keputusan</p>
                </div>

                {{-- Quick reference --}}
                <div style="margin-top: 20px; background: #f9fafb; border-radius: 8px; padding: 16px;">
                    <h3 style="font-size: 11px; font-weight: 600; color: #6b7280; letter-spacing: 0.06em; text-transform: uppercase; margin: 0 0 10px;">Rujukan Pantas Penukaran Unit</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px;">
                        <div style="font-size: 12px; color: #6b7280;">1 hektar = 10,000 m&sup2;</div>
                        <div style="font-size: 12px; color: #6b7280;">1 L = 1,000 mL</div>
                        <div style="font-size: 12px; color: #6b7280;">1 kg = 1,000 g</div>
                        <div style="font-size: 12px; color: #6b7280;">1 ekar = 0.405 ha</div>
                    </div>
                </div>
            </div>

            {{-- Disclaimer --}}
            <div style="margin-top: 20px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; padding: 20px; display: flex; gap: 12px;">
                <svg style="width: 20px; height: 20px; color: #d97706; flex-shrink: 0; margin-top: 1px;" fill="none" stroke="#d97706" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <p style="font-size: 13px; color: #92400e; line-height: 1.6; margin: 0;">
                    <span style="font-weight: 600;">Penafian:</span>
                    {{ __('app.calculator.disclaimer') }}
                    Kadar penggunaan mungkin berbeza mengikut jenis perosak, tanaman, dan keadaan persekitaran.
                    Pastikan penggunaan racun mematuhi peraturan di bawah Akta Racun Makhluk Perosak 1974 (Akta 149).
                </p>
            </div>
        </div>
    </div>

</x-layouts.public>
