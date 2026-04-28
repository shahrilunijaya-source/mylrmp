<x-layouts.officer title="Butiran Syarikat">

    {{-- Back + heading --}}
    <div style="margin-bottom:24px;">
        <a href="{{ route('officer.companies.index') }}"
           style="display:inline-flex;align-items:center;gap:5px;font-size:13px;color:var(--text-3);text-decoration:none;transition:color .15s;margin-bottom:10px;"
           onmouseover="this.style.color='var(--brand)'" onmouseout="this.style.color='var(--text-3)'">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Senarai Syarikat
        </a>
        <div style="display:flex;align-items:center;gap:14px;">
            @php
                $initials = implode('', array_map(fn($w) => strtoupper($w[0] ?? ''), array_slice(explode(' ', $company->name ?? 'S'), 0, 2)));
            @endphp
            <div style="width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,#0a2440,#1e3a5f);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#FFCC00;flex-shrink:0;letter-spacing:-0.3px;">
                {{ $initials }}
            </div>
            <div>
                <div class="pg-title">{{ $company->name }}</div>
                <div style="font-size:12px;font-family:var(--mono);color:var(--text-3);margin-top:2px;">SSM: {{ $company->ssm_no }}</div>
            </div>
            <div style="margin-left:auto;">
                @if(isset($company->status) && $company->status->value === 'active')
                    <span class="st st-ok">Aktif</span>
                @else
                    <span class="st st-drf">Tidak Aktif</span>
                @endif
            </div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

        {{-- Company details --}}
        <div class="card">
            <div class="card-head">
                <span class="card-title">Maklumat Syarikat</span>
            </div>
            <div style="padding:20px;">
                <dl style="display:flex;flex-direction:column;gap:14px;">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;">
                        <dt style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-4);flex-shrink:0;">Nama Syarikat</dt>
                        <dd style="font-size:13px;font-weight:500;color:var(--text);text-align:right;">{{ $company->name }}</dd>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
                        <dt style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-4);flex-shrink:0;">No. SSM</dt>
                        <dd><span class="app-chip">{{ $company->ssm_no ?? '—' }}</span></dd>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;">
                        <dt style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-4);flex-shrink:0;">Alamat</dt>
                        <dd style="font-size:13px;color:var(--text-2);text-align:right;">{{ $company->address ?? '—' }}</dd>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
                        <dt style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-4);flex-shrink:0;">Telefon</dt>
                        <dd style="font-size:13px;color:var(--text-2);">{{ $company->phone ?? '—' }}</dd>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
                        <dt style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-4);flex-shrink:0;">E-mel</dt>
                        <dd style="font-size:13px;color:var(--text-2);">{{ $company->email ?? '—' }}</dd>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
                        <dt style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-4);flex-shrink:0;">Orang Hubungi</dt>
                        <dd style="font-size:13px;color:var(--text-2);">{{ $company->contact_person ?? '—' }}</dd>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
                        <dt style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-4);flex-shrink:0;">Tarikh Daftar</dt>
                        <dd style="font-size:13px;color:var(--text-2);">{{ $company->registered_at?->format('d M Y') ?? $company->created_at?->format('d M Y') ?? '—' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Users --}}
        <div class="card">
            <div class="card-head">
                <span class="card-title">Pengguna</span>
                <span class="card-meta">{{ $company->users->count() }} pengguna</span>
            </div>
            @if($company->users->isEmpty())
                <div class="empty" style="padding:32px 24px;">
                    <div class="empty-title">Tiada pengguna</div>
                </div>
            @else
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>E-mel</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($company->users as $user)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <div style="width:28px;height:28px;border-radius:50%;background:var(--brand);color:#fff;font-size:11px;font-weight:600;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span style="font-size:13px;font-weight:500;color:var(--text);">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td style="font-size:12.5px;color:var(--text-3);">{{ $user->email }}</td>
                                <td>
                                    @if($user->is_active ?? true)
                                        <span class="st st-ok">Aktif</span>
                                    @else
                                        <span class="st st-drf">Tidak Aktif</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>

    {{-- Applications --}}
    <div class="card" style="margin-bottom:20px;">
        <div class="card-head">
            <span class="card-title">Permohonan</span>
            <span class="card-meta">{{ $company->applications->count() }} permohonan</span>
        </div>
        @if($company->applications->isEmpty())
            <div class="empty" style="padding:32px 24px;">
                <div class="empty-title">Tiada permohonan</div>
                <div class="empty-sub">Syarikat ini belum membuat sebarang permohonan.</div>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>No. Permohonan</th>
                            <th>Produk</th>
                            <th>Status</th>
                            <th>Tarikh</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($company->applications as $application)
                            <tr>
                                <td>
                                    <span class="app-chip">{{ $application->application_no }}</span>
                                </td>
                                <td style="font-size:13px;color:var(--text-2);">{{ $application->product?->name ?? '—' }}</td>
                                <td>
                                    <span class="st {{ match($application->current_stage?->value ?? '') {
                                        'approved'         => 'st-ok',
                                        'rejected'         => 'st-rej',
                                        'submitted'        => 'st-sub',
                                        'under_review'     => 'st-rev',
                                        'needs_document'   => 'st-nds',
                                        'technical_review' => 'st-tec',
                                        'label_review'     => 'st-lbl',
                                        default            => 'st-drf',
                                    } }}">{{ ucfirst(str_replace('_', ' ', $application->current_stage?->value ?? 'Draft')) }}</span>
                                </td>
                                <td style="font-size:12px;color:var(--text-4);white-space:nowrap;">
                                    {{ $application->created_at?->format('d M Y') ?? '—' }}
                                </td>
                                <td>
                                    <a href="{{ route('officer.applications.show', $application) }}" class="tbl-action">Lihat</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Registered products --}}
    <div class="card">
        <div class="card-head">
            <span class="card-title">Produk Berdaftar</span>
            <span class="card-meta">{{ $company->registeredProducts->count() }} produk</span>
        </div>
        @if($company->registeredProducts->isEmpty())
            <div class="empty" style="padding:32px 24px;">
                <div class="empty-title">Tiada produk berdaftar</div>
                <div class="empty-sub">Syarikat ini belum mempunyai produk yang berdaftar.</div>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Jenis Formulasi</th>
                            <th>Tarikh Cipta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($company->registeredProducts as $product)
                            <tr>
                                <td style="font-size:13px;font-weight:500;color:var(--text);">{{ $product->name }}</td>
                                <td style="font-size:13px;color:var(--text-3);">{{ $product->formulationType?->name_ms ?? '—' }}</td>
                                <td style="font-size:12px;color:var(--text-4);">{{ $product->created_at?->format('d M Y') ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</x-layouts.officer>
