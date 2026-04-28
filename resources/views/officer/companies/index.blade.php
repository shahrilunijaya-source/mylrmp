<x-layouts.officer title="Syarikat Berdaftar">

    {{-- Page heading --}}
    <div class="pg-head">
        <div>
            <div class="pg-title">Syarikat Berdaftar</div>
            <div class="pg-sub">Semua syarikat industri yang berdaftar dalam sistem myLRMP</div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <span class="card-title">Senarai Syarikat</span>
            <span class="card-meta">{{ $companies->total() }} syarikat</span>
        </div>

        @if($companies->isEmpty())
            <div class="empty">
                <div class="empty-icon">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2h-5L9 4H4zm7 5a1 1 0 10-2 0v1H8a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="empty-title">Tiada syarikat dijumpai</div>
                <div class="empty-sub">Belum ada syarikat industri yang berdaftar dalam sistem.</div>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Nama Syarikat</th>
                            <th>No. SSM</th>
                            <th>Orang Hubungan</th>
                            <th>Telefon</th>
                            <th>Pengguna</th>
                            <th>Status</th>
                            <th>Tarikh Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                            @php
                                $initials = implode('', array_map(fn($w) => strtoupper($w[0] ?? ''), array_slice(explode(' ', $company->name ?? 'S'), 0, 2)));
                                $isActive = isset($company->is_active) ? $company->is_active : true;
                            @endphp
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#0a2440,#1e3a5f);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#FFCC00;flex-shrink:0;letter-spacing:-0.3px;">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <a href="{{ route('officer.companies.show', $company) }}"
                                               style="font-weight:500;font-size:13.5px;color:var(--brand);text-decoration:none;transition:color .1s;"
                                               onmouseover="this.style.color='var(--brand-dark)'" onmouseout="this.style.color='var(--brand)'">{{ $company->name }}</a>
                                            @if($company->email ?? null)
                                                <div style="font-size:11.5px;color:var(--text-4);margin-top:1px;">{{ $company->email }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="app-chip">{{ $company->ssm_no ?? '—' }}</span>
                                </td>
                                <td style="font-size:13px;color:var(--text-2);">{{ $company->contact_person ?? '—' }}</td>
                                <td style="font-size:13px;color:var(--text-3);">{{ $company->phone ?? '—' }}</td>
                                <td>
                                    <span style="display:inline-flex;align-items:center;justify-content:center;min-width:24px;height:22px;padding:0 7px;background:var(--bg);border:1px solid var(--border);border-radius:9999px;font-size:11.5px;font-weight:600;color:var(--text-3);">
                                        {{ $company->users_count ?? 0 }}
                                    </span>
                                </td>
                                <td>
                                    @if($isActive)
                                        <span class="st st-ok">Aktif</span>
                                    @else
                                        <span class="st st-drf">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td style="font-size:12px;color:var(--text-4);white-space:nowrap;">
                                    {{ $company->created_at?->format('d M Y') ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($companies->hasPages())
                <div class="pagination">
                    {{ $companies->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.officer>
