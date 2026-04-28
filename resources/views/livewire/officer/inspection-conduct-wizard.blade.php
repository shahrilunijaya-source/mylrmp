<div style="max-width:1060px;margin:0 auto;">

{{-- Step progress --}}
<div style="display:flex;align-items:center;gap:0;margin-bottom:28px;">
    @foreach(['Senarai Semak', 'Penemuan', 'Kesimpulan'] as $i => $label)
    @php $n = $i + 1; $done = $step > $n; $active = $step === $n; @endphp
    <div style="display:flex;align-items:center;flex:1;">
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;
                background:{{ $done ? 'var(--brand)' : ($active ? 'var(--navy)' : 'var(--bg)') }};
                color:{{ ($done || $active) ? '#fff' : 'var(--text-4)' }};
                border:2px solid {{ $done ? 'var(--brand)' : ($active ? 'var(--navy)' : 'var(--border-2)') }};">
                @if($done)
                    <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8l4 4 6-6"/></svg>
                @else
                    {{ $n }}
                @endif
            </div>
            <span style="font-size:13px;font-weight:{{ $active ? '600' : '400' }};color:{{ $active ? 'var(--text)' : ($done ? 'var(--brand)' : 'var(--text-4)') }};">{{ $label }}</span>
        </div>
        @if($n < 3)
        <div style="flex:1;height:1px;background:{{ $step > $n ? 'var(--brand)' : 'var(--border)' }};margin:0 16px;"></div>
        @endif
    </div>
    @endforeach
</div>

@if($step === 1)
{{-- ───────────── STEP 1: Checklist ───────────── --}}
<div class="card">
    <div class="card-head">
        <span class="card-title">Senarai Semak Pemeriksaan</span>
        @php $tidakCount = collect($answers)->filter(fn($a) => ($a['answer'] ?? '') === 'No')->count(); @endphp
        <span class="card-meta" style="{{ $tidakCount > 0 ? 'color:var(--red);font-weight:600;' : '' }}">
            {{ $tidakCount }} tidak akur
        </span>
    </div>

    @forelse($checklistItems as $category => $items)

    {{-- Category section header --}}
    <div style="display:flex;align-items:center;gap:10px;padding:10px 20px;background:var(--bg);border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
        <div style="width:3px;height:14px;background:var(--brand);border-radius:2px;flex-shrink:0;"></div>
        <span style="font-size:11px;font-weight:700;letter-spacing:0.1em;color:var(--text-2);text-transform:uppercase;">{{ $category }}</span>
        <span style="font-size:10.5px;font-weight:600;color:var(--text-4);background:var(--border);padding:1px 8px;border-radius:999px;">{{ count($items) }}</span>
    </div>

    {{-- 2-column item grid --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;padding:14px 20px;">
        @foreach($items as $item)
        @php
            $ans   = $answers[$item->id]['answer'] ?? 'NA';
            $lbord = $ans === 'No' ? 'var(--red)' : ($ans === 'Yes' ? 'var(--brand)' : 'var(--border)');
        @endphp
        <div style="border:1px solid var(--border);border-left:3px solid {{ $lbord }};border-radius:8px;padding:14px;background:var(--surface);display:flex;flex-direction:column;gap:10px;">

            {{-- Question --}}
            <div style="font-size:13px;color:var(--text);line-height:1.55;flex:1;">{{ $item->prompt_ms }}</div>

            {{-- Ya / Tidak / T/B buttons --}}
            <div style="display:flex;gap:5px;">
                @foreach(['Yes' => ['Ya','var(--brand)','var(--brand-light)','var(--brand)'], 'No' => ['Tidak','var(--red)','var(--red-bg)','var(--red)'], 'NA' => ['T/B','var(--text-2)','#e2e8f0','var(--border-2)']] as $val => [$lbl,$tc,$bg,$bdr])
                @php $sel = $ans === $val; @endphp
                <button type="button"
                    wire:click="setAnswer({{ $item->id }}, '{{ $val }}')"
                    style="flex:1;height:32px;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer;font-family:inherit;transition:all .12s;
                        background:{{ $sel ? $bg : '#fff' }};
                        color:{{ $sel ? $tc : 'var(--text-4)' }};
                        border:1.5px solid {{ $sel ? $bdr : 'var(--border)' }};">
                    {{ $lbl }}
                </button>
                @endforeach
            </div>

            {{-- Notes --}}
            <input type="text"
                wire:model.defer="answers.{{ $item->id }}.note"
                placeholder="Nota (pilihan)..."
                class="form-input"
                style="font-size:12px;padding:5px 10px;">

        </div>
        @endforeach
    </div>

    @empty
        <div style="padding:40px;text-align:center;color:var(--text-4);font-size:13px;">Tiada item senarai semak untuk jenis sasaran ini.</div>
    @endforelse
</div>

<div style="display:flex;justify-content:flex-end;gap:10px;margin-top:16px;">
    <a href="{{ route('officer.pemeriksaan.show', $inspection) }}" class="btn-ghost">← Kembali</a>
    <button wire:click="nextStep" class="btn-navy">Seterusnya: Penemuan →</button>
</div>

@elseif($step === 2)
{{-- ───────────── STEP 2: Findings ───────────── --}}
<div class="card">
    <div class="card-head">
        <span class="card-title">Penemuan Ketidakpatuhan</span>
        <button wire:click="addFinding" class="btn-navy" style="font-size:12px;padding:6px 14px;">+ Tambah Penemuan</button>
    </div>
    <div style="padding:18px;display:grid;gap:14px;">
        @forelse($findings as $i => $finding)
        <div style="border:1px solid var(--border);border-left:3px solid {{ ($finding['severity'] ?? 'minor') === 'major' ? 'var(--red)' : 'var(--amber)' }};border-radius:8px;padding:16px;background:var(--surface-2);">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                <span style="font-size:12px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:0.05em;">Penemuan {{ $i + 1 }}</span>
                <button wire:click="removeFinding({{ $i }})" style="font-size:12px;color:var(--red);background:none;border:none;cursor:pointer;padding:2px 8px;border-radius:4px;">Padam</button>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div>
                    <label class="form-label">Keterukan</label>
                    <select wire:model.live="findings.{{ $i }}.severity" class="form-select">
                        <option value="minor">Kecil</option>
                        <option value="major">Major</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Kategori</label>
                    <select wire:model.defer="findings.{{ $i }}.category" class="form-select">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" @selected(($finding['category'] ?? '') === $cat)>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Penerangan Penemuan <span style="color:var(--red)">*</span></label>
                    <textarea wire:model.defer="findings.{{ $i }}.description" class="form-textarea" rows="2" placeholder="Huraikan penemuan secara terperinci...">{{ $finding['description'] ?? '' }}</textarea>
                </div>
                <div>
                    <label class="form-label">Produk Berkaitan</label>
                    <select wire:model.defer="findings.{{ $i }}.product_id" class="form-select">
                        <option value="">— Tiada —</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" @selected(($finding['product_id'] ?? null) == $p->id)>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Foto Bukti</label>
                    <input type="file" wire:model.defer="findings.{{ $i }}.photo" accept="image/*"
                           style="font-size:12.5px;color:var(--text-2);padding:6px 0;">
                </div>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:32px;color:var(--text-4);">
            <div style="font-size:13.5px;margin-bottom:6px;">Tiada penemuan ketidakpatuhan direkodkan.</div>
            <div style="font-size:12px;">Klik "+ Tambah Penemuan" jika terdapat isu untuk dilaporkan.</div>
        </div>
        @endforelse
    </div>
</div>

<div style="display:flex;justify-content:space-between;gap:10px;margin-top:16px;">
    <button wire:click="prevStep" class="btn-ghost">← Kembali</button>
    <button wire:click="nextStep" class="btn-navy">Seterusnya: Kesimpulan →</button>
</div>

@elseif($step === 3)
{{-- ───────────── STEP 3: Conclusion ───────────── --}}
<div class="card">
    <div class="card-head"><span class="card-title">Kesimpulan Pemeriksaan</span></div>
    <div style="padding:24px;display:grid;gap:20px;">

        <div>
            <label class="form-label">Rumusan Keseluruhan <span style="color:var(--red)">*</span></label>
            <textarea wire:model.defer="summary" class="form-textarea" rows="4"
                      placeholder="Huraikan keputusan keseluruhan pemeriksaan ini..."></textarea>
            @error('summary')<div style="font-size:12px;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="form-label" style="margin-bottom:10px;">Status Keputusan <span style="color:var(--red)">*</span></label>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">
                @foreach([
                    'compliant' => ['label' => 'Akur', 'sub' => 'Tiada isu ditemui', 'tc' => 'var(--brand)', 'bg' => 'var(--brand-light)', 'border' => 'var(--brand)'],
                    'minor_nc'  => ['label' => 'Ketidakpatuhan Kecil', 'sub' => 'Isu kecil, notis diperlukan', 'tc' => 'var(--amber)', 'bg' => 'var(--amber-bg)', 'border' => 'var(--amber)'],
                    'major_nc'  => ['label' => 'Ketidakpatuhan Major', 'sub' => 'Isu serius, tindakan segera', 'tc' => 'var(--red)', 'bg' => 'var(--red-bg)', 'border' => 'var(--red)'],
                ] as $val => $cfg)
                @php $sel = $outcomeStatus === $val; @endphp
                <label style="cursor:pointer;">
                    <input type="radio" wire:model.live="outcomeStatus" value="{{ $val }}" style="display:none;">
                    <div style="border:2px solid {{ $sel ? $cfg['border'] : 'var(--border)' }};border-radius:10px;padding:14px;text-align:center;background:{{ $sel ? $cfg['bg'] : 'var(--surface)' }};transition:all .1s;">
                        <div style="font-size:13.5px;font-weight:700;color:{{ $sel ? $cfg['tc'] : 'var(--text-3)' }};margin-bottom:4px;">{{ $cfg['label'] }}</div>
                        <div style="font-size:11.5px;color:{{ $sel ? $cfg['tc'] : 'var(--text-4)' }};line-height:1.4;">{{ $cfg['sub'] }}</div>
                    </div>
                </label>
                @endforeach
            </div>
            @error('outcomeStatus')<div style="font-size:12px;color:var(--red);margin-top:6px;">{{ $message }}</div>@enderror
        </div>

        @if(in_array($outcomeStatus, ['minor_nc', 'major_nc']))
        <div>
            <label class="form-label">Tarikh Akhir Pembetulan <span style="color:var(--red)">*</span></label>
            <input type="date" wire:model.defer="deadline" class="form-input"
                   min="{{ date('Y-m-d', strtotime('+1 day')) }}" style="max-width:220px;">
            <div style="font-size:12px;color:var(--text-4);margin-top:4px;">Semua ketidakpatuhan mesti diperbetulkan sebelum tarikh ini.</div>
            @error('deadline')<div style="font-size:12px;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
        </div>
        @endif

        {{-- Summary of what will be generated --}}
        @if($outcomeStatus)
        <div style="background:var(--bg);border:1px solid var(--border);border-radius:8px;padding:14px 16px;">
            <div style="font-size:11.5px;font-weight:700;color:var(--text-4);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:8px;">Dokumen yang akan dijana</div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <span class="st st-sub">↓ Laporan Pemeriksaan PDF</span>
                @if(in_array($outcomeStatus, ['minor_nc', 'major_nc']))
                    <span class="st st-rej">↓ Notis Ketidakpatuhan PDF</span>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>

<div style="display:flex;justify-content:space-between;gap:10px;margin-top:16px;">
    <button wire:click="prevStep" class="btn-ghost">← Kembali</button>
    <button wire:click="conclude" class="btn-navy"
            onclick="return confirm('Sahkan kesimpulan ini? Laporan PDF akan dijana dan pemeriksaan ditutup.')"
            @if(!$outcomeStatus) disabled style="opacity:.5;cursor:not-allowed;" @endif>
        Selesaikan &amp; Jana Laporan
    </button>
</div>

@endif

</div>
