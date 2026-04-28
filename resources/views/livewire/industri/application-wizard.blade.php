<div style="max-width:700px;margin:0 auto;">

    {{-- Step progress --}}
    <div style="display:flex;align-items:flex-start;margin-bottom:28px;">
        @foreach ($stepLabels as $num => $label)
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;position:relative;">
                {{-- Connector line left --}}
                @if ($num > 1)
                    <div style="position:absolute;top:14px;left:0;right:50%;height:2px;background:{{ $step >= $num ? 'var(--brand)' : 'var(--border)' }};z-index:0;"></div>
                @endif
                {{-- Connector line right --}}
                @if ($num < $totalSteps)
                    <div style="position:absolute;top:14px;left:50%;right:0;height:2px;background:{{ $step > $num ? 'var(--brand)' : 'var(--border)' }};z-index:0;"></div>
                @endif

                {{-- Circle --}}
                <div style="
                    width:28px;height:28px;border-radius:50%;
                    display:flex;align-items:center;justify-content:center;
                    font-size:12px;font-weight:600;flex-shrink:0;position:relative;z-index:1;
                    {{ $step > $num
                        ? 'background:var(--brand);color:#fff;'
                        : ($step === $num
                            ? 'background:var(--brand);color:#fff;box-shadow:0 0 0 4px #f0fdf4;'
                            : 'background:var(--border);color:var(--text-4);') }}
                ">
                    @if ($step > $num)
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 6l3 3 5-5"/>
                        </svg>
                    @else
                        {{ $num }}
                    @endif
                </div>

                {{-- Label --}}
                <span style="
                    margin-top:6px;font-size:10.5px;text-align:center;
                    {{ $step === $num ? 'color:var(--brand);font-weight:600;' : 'color:var(--text-4);' }}
                ">{{ $label }}</span>
            </div>
        @endforeach
    </div>

    {{-- Step card --}}
    <div class="card" style="overflow:visible;">
        <div class="card-head">
            <span class="card-title">Langkah {{ $step }}: {{ $stepLabels[$step] }}</span>
            <span style="font-size:12px;color:var(--text-4);">{{ $step }} / {{ $totalSteps }}</span>
        </div>
        <div style="padding:24px;">

            {{-- Validation errors --}}
            @if ($errors->any())
                <div style="margin-bottom:16px;padding:12px 16px;background:#fef2f2;border:1px solid #fecaca;border-radius:6px;">
                    @foreach ($errors->all() as $error)
                        <div style="font-size:13px;color:#b91c1c;display:flex;align-items:center;gap:6px;">
                            <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- ── Step 1: Kategori Produk ── --}}
            @if ($step === 1)
                <div style="display:flex;flex-direction:column;gap:16px;">
                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--text);margin-bottom:6px;letter-spacing:0.2px;">
                            Kategori Produk <span style="color:#dc2626;">*</span>
                        </label>
                        <select wire:model.live="category_id"
                                style="width:100%;border:1px solid var(--border);border-radius:6px;padding:10px 14px;font-family:var(--font);font-size:13.5px;color:var(--text);background:#fff;outline:none;transition:border-color .15s,box-shadow .15s;-webkit-appearance:none;"
                                onfocus="this.style.borderColor='var(--brand)';this.style.boxShadow='0 0 0 3px rgba(0,104,55,.12)'"
                                onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                            <option value="">— Pilih Kategori —</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name_ms }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--text);margin-bottom:6px;letter-spacing:0.2px;">
                            Sub-Kategori <span style="font-weight:400;color:var(--text-4);">(pilihan)</span>
                        </label>
                        <select wire:model="subcategory_id"
                                style="width:100%;border:1px solid var(--border);border-radius:6px;padding:10px 14px;font-family:var(--font);font-size:13.5px;color:var(--text);background:#fff;outline:none;transition:border-color .15s,box-shadow .15s;-webkit-appearance:none;"
                                onfocus="this.style.borderColor='var(--brand)';this.style.boxShadow='0 0 0 3px rgba(0,104,55,.12)'"
                                onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                            <option value="">— Pilih Sub-Kategori (Pilihan) —</option>
                            @foreach ($subcategories as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->name_ms }}</option>
                            @endforeach
                        </select>
                        @if (!$category_id)
                            <p style="font-size:11.5px;color:var(--text-4);margin-top:5px;">Pilih kategori dahulu.</p>
                        @endif
                    </div>
                </div>
            @endif

            {{-- ── Step 2: Butiran Produk ── --}}
            @if ($step === 2)
                <div style="display:flex;flex-direction:column;gap:16px;">
                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--text);margin-bottom:6px;letter-spacing:0.2px;">
                            Nama Produk <span style="color:#dc2626;">*</span>
                        </label>
                        <input type="text" wire:model="product_name"
                               placeholder="Contoh: RoundUp Pro 480 SL"
                               style="width:100%;border:1px solid var(--border);border-radius:6px;padding:10px 14px;font-family:var(--font);font-size:13.5px;color:var(--text);background:#fff;outline:none;transition:border-color .15s,box-shadow .15s;"
                               onfocus="this.style.borderColor='var(--brand)';this.style.boxShadow='0 0 0 3px rgba(0,104,55,.12)'"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                    </div>

                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--text);margin-bottom:6px;letter-spacing:0.2px;">
                            Jenis Formulasi
                        </label>
                        <select wire:model="formulation_type_id"
                                style="width:100%;border:1px solid var(--border);border-radius:6px;padding:10px 14px;font-family:var(--font);font-size:13.5px;color:var(--text);background:#fff;outline:none;transition:border-color .15s,box-shadow .15s;-webkit-appearance:none;"
                                onfocus="this.style.borderColor='var(--brand)';this.style.boxShadow='0 0 0 3px rgba(0,104,55,.12)'"
                                onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                            <option value="">— Pilih Jenis Formulasi —</option>
                            @foreach ($formulationTypes as $ft)
                                <option value="{{ $ft->id }}">{{ $ft->code }} — {{ $ft->name_ms }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:var(--text);margin-bottom:6px;letter-spacing:0.2px;">
                            Nama Pengeluar
                        </label>
                        <input type="text" wire:model="manufacturer_name"
                               placeholder="Nama syarikat pengeluar"
                               style="width:100%;border:1px solid var(--border);border-radius:6px;padding:10px 14px;font-family:var(--font);font-size:13.5px;color:var(--text);background:#fff;outline:none;transition:border-color .15s,box-shadow .15s;"
                               onfocus="this.style.borderColor='var(--brand)';this.style.boxShadow='0 0 0 3px rgba(0,104,55,.12)'"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                    </div>
                </div>
            @endif

            {{-- ── Step 3: Perawis Aktif ── --}}
            @if ($step === 3)
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach ($ingredients as $index => $ingredient)
                        <div style="display:flex;align-items:flex-end;gap:10px;padding:14px;background:var(--bg);border:1px solid var(--border);border-radius:6px;">
                            <div style="flex:1;">
                                <label style="display:block;font-size:11px;font-weight:600;color:var(--text-4);margin-bottom:5px;letter-spacing:0.06em;text-transform:uppercase;">Perawis Aktif</label>
                                <select wire:model="ingredients.{{ $index }}.active_ingredient_id"
                                        style="width:100%;border:1px solid var(--border);border-radius:6px;padding:9px 12px;font-family:var(--font);font-size:13px;color:var(--text);background:#fff;outline:none;-webkit-appearance:none;"
                                        onfocus="this.style.borderColor='var(--brand)'"
                                        onblur="this.style.borderColor='var(--border)'">
                                    <option value="">— Pilih Perawis —</option>
                                    @foreach ($activeIngredients as $ai)
                                        <option value="{{ $ai->id }}">{{ $ai->name }}{{ $ai->cas_no ? ' (' . $ai->cas_no . ')' : '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="width:140px;flex-shrink:0;">
                                <label style="display:block;font-size:11px;font-weight:600;color:var(--text-4);margin-bottom:5px;letter-spacing:0.06em;text-transform:uppercase;">Kepekatan (%)</label>
                                <input type="number" wire:model="ingredients.{{ $index }}.concentration_percent"
                                       min="0" max="100" step="0.01" placeholder="mis: 48.0"
                                       style="width:100%;border:1px solid var(--border);border-radius:6px;padding:9px 12px;font-family:var(--font);font-size:13px;color:var(--text);background:#fff;outline:none;"
                                       onfocus="this.style.borderColor='var(--brand)'"
                                       onblur="this.style.borderColor='var(--border)'">
                            </div>
                            @if (count($ingredients) > 1)
                                <button type="button" wire:click="removeIngredient({{ $index }})"
                                        style="width:32px;height:32px;border:1px solid #fecaca;border-radius:6px;background:#fff;color:#dc2626;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background .12s;"
                                        onmouseover="this.style.background='#fef2f2'"
                                        onmouseout="this.style.background='#fff'">
                                    <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                </button>
                            @endif
                        </div>
                    @endforeach

                    <button type="button" wire:click="addIngredient"
                            style="display:inline-flex;align-items:center;gap:6px;font-size:13px;font-weight:500;color:var(--brand);background:none;border:1px dashed #bbf7d0;border-radius:6px;padding:8px 14px;cursor:pointer;transition:all .12s;margin-top:4px;"
                            onmouseover="this.style.background='var(--brand-light)'"
                            onmouseout="this.style.background='none'">
                        <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                        Tambah Perawis
                    </button>
                </div>
            @endif

            {{-- ── Step 4: Dokumen ── --}}
            @if ($step === 4)
                <div style="display:flex;flex-direction:column;gap:16px;">
                    <div style="padding:14px 16px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:6px;">
                        <div style="font-size:13px;font-weight:600;color:#1d4ed8;margin-bottom:4px;">Maklumat Dokumen</div>
                        <div style="font-size:13px;color:#2563eb;">Muat naik dokumen sokongan selepas permohonan ini dihantar. Dokumen boleh dimuat naik melalui halaman butiran permohonan.</div>
                    </div>

                    <div>
                        <div style="font-size:12px;font-weight:600;color:var(--text);margin-bottom:10px;letter-spacing:0.06em;text-transform:uppercase;">Dokumen Diperlukan</div>
                        <div style="display:flex;flex-direction:column;gap:8px;">
                            @foreach ([
                                ['Label Produk', 'Contoh label produk siap cetakan (PDF)', 'document'],
                                ['Data Teknikal', 'Spesifikasi teknikal bahan aktif (PDF/DOCX)', 'document'],
                                ['Laporan Makmal', 'Keputusan ujian makmal bertauliah (PDF)', 'beaker'],
                                ['Sijil Analisis', 'Certificate of Analysis daripada pengeluar (PDF)', 'badge'],
                            ] as [$docName, $desc, $icon])
                                <div style="display:flex;align-items:center;gap:12px;padding:12px 14px;background:var(--bg);border:1px solid var(--border);border-radius:6px;">
                                    <div style="width:32px;height:32px;border-radius:6px;background:#fef9c3;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor" style="color:#a16207;">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div style="font-size:13.5px;font-weight:500;color:var(--text);">{{ $docName }}</div>
                                        <div style="font-size:12px;color:var(--text-4);">{{ $desc }}</div>
                                    </div>
                                    <span style="margin-left:auto;font-size:11px;font-weight:600;padding:2px 8px;background:#fef9c3;color:#a16207;border-radius:4px;">Diperlukan</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- ── Step 5: Semak & Hantar ── --}}
            @if ($step === 5)
                <div style="display:flex;flex-direction:column;gap:18px;">

                    {{-- Summary sections --}}
                    @foreach ([
                        ['Kategori Produk', [
                            ['Kategori', $category_id ? ($categories->firstWhere('id', $category_id)?->name_ms ?? '—') : '<span style="color:#dc2626">Tidak dipilih</span>'],
                            ['Sub-Kategori', $subcategory_id ? ($subcategories->firstWhere('id', $subcategory_id)?->name_ms ?? '—') : 'Tiada'],
                        ]],
                        ['Butiran Produk', [
                            ['Nama Produk', $product_name ?: '—'],
                            ['Jenis Formulasi', $formulation_type_id ? ($formulationTypes->firstWhere('id', $formulation_type_id)?->name_ms ?? '—') : '—'],
                            ['Pengeluar', $manufacturer_name ?: '—'],
                        ]],
                    ] as [$sectionTitle, $rows])
                        <div>
                            <div style="font-size:11px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-4);margin-bottom:8px;">{{ $sectionTitle }}</div>
                            <div style="border:1px solid var(--border);border-radius:6px;overflow:hidden;">
                                @foreach ($rows as $i => [$key, $val])
                                    <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 14px;{{ $i > 0 ? 'border-top:1px solid var(--border);' : '' }}background:{{ $i % 2 === 0 ? '#fff' : 'var(--bg)' }};">
                                        <span style="font-size:13px;color:var(--text-3);">{{ $key }}</span>
                                        <span style="font-size:13px;font-weight:500;color:var(--text);">{!! $val !!}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    {{-- Ingredients summary --}}
                    <div>
                        <div style="font-size:11px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-4);margin-bottom:8px;">Perawis Aktif</div>
                        @php $filledIngredients = collect($ingredients)->filter(fn($i) => !empty($i['active_ingredient_id'])); @endphp
                        <div style="border:1px solid var(--border);border-radius:6px;overflow:hidden;">
                            @if ($filledIngredients->isEmpty())
                                <div style="padding:14px;text-align:center;font-size:13px;color:var(--text-4);">Tiada perawis aktif dipilih.</div>
                            @else
                                @foreach ($filledIngredients as $i => $row)
                                    <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 14px;{{ $i > 0 ? 'border-top:1px solid var(--border);' : '' }}">
                                        <span style="font-size:13px;color:var(--text);">{{ $activeIngredients->firstWhere('id', $row['active_ingredient_id'])?->name ?? '—' }}</span>
                                        <span style="font-size:13px;color:var(--text-3);">{{ $row['concentration_percent'] ? $row['concentration_percent'] . '%' : '—' }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    {{-- Confirmation checkbox --}}
                    <div style="display:flex;align-items:flex-start;gap:12px;padding:14px 16px;background:#fffbeb;border:1px solid #fde68a;border-radius:6px;">
                        <input type="checkbox" wire:model="confirmed" id="confirmed"
                               style="width:16px;height:16px;margin-top:2px;flex-shrink:0;accent-color:var(--brand);cursor:pointer;">
                        <label for="confirmed" style="font-size:13px;color:var(--text-2);cursor:pointer;line-height:1.5;">
                            Saya mengesahkan bahawa maklumat di atas adalah benar dan tepat. Saya faham bahawa maklumat palsu boleh menyebabkan permohonan ditolak atau tindakan undang-undang diambil.
                        </label>
                    </div>

                    {{-- Submit button --}}
                    <button type="button" wire:click="submit" wire:loading.attr="disabled"
                            style="width:100%;padding:12px;background:var(--brand);color:#fff;font-family:var(--font);font-size:14px;font-weight:500;border:none;border-radius:4px;cursor:pointer;transition:background 150ms ease,transform 150ms ease;display:flex;align-items:center;justify-content:center;gap:8px;"
                            onmouseover="this.style.background='var(--brand-dark)';this.style.transform='translateY(-1px)'"
                            onmouseout="this.style.background='var(--brand)';this.style.transform='none'">
                        <svg wire:loading.remove wire:target="submit" width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"/></svg>
                        <span wire:loading.remove wire:target="submit">Hantar Permohonan</span>
                        <span wire:loading wire:target="submit">Menghantar...</span>
                    </button>
                </div>
            @endif

        </div>
    </div>

    {{-- Navigation buttons --}}
    <div style="display:flex;justify-content:space-between;margin-top:16px;">
        @if ($step > 1)
            <button type="button" wire:click="previousStep"
                    style="padding:9px 20px;border:1px solid var(--border);border-radius:4px;background:#fff;color:var(--text-2);font-family:var(--font);font-size:13px;font-weight:500;cursor:pointer;transition:all .12s;"
                    onmouseover="this.style.borderColor='var(--border-2)';this.style.background='var(--bg)'"
                    onmouseout="this.style.borderColor='var(--border)';this.style.background='#fff'">
                ← Kembali
            </button>
        @else
            <div></div>
        @endif

        @if ($step < 5)
            <button type="button" wire:click="nextStep" wire:loading.attr="disabled"
                    style="padding:9px 24px;background:var(--brand);color:#fff;border:none;border-radius:4px;font-family:var(--font);font-size:13px;font-weight:500;cursor:pointer;transition:background 150ms ease,transform 150ms ease;"
                    onmouseover="this.style.background='var(--brand-dark)';this.style.transform='translateY(-1px)'"
                    onmouseout="this.style.background='var(--brand)';this.style.transform='none'">
                <span wire:loading.remove wire:target="nextStep">
                    {{ $step < 4 ? 'Seterusnya →' : 'Semak Permohonan →' }}
                </span>
                <span wire:loading wire:target="nextStep">Memproses...</span>
            </button>
        @endif
    </div>

</div>
