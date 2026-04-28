<x-layouts.industri title="Papan Pemuka">

    {{-- Session messages --}}
    @if (session('success'))
        <div style="margin-bottom:20px;padding:12px 16px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;font-size:13px;color:#15803d;display:flex;align-items:center;gap:8px;">
            <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Page heading --}}
    <div class="pg-head">
        <div>
            <div class="pg-title">Selamat datang, {{ explode(' ', auth()->user()?->name ?? 'Pengguna')[0] }}</div>
            <div class="pg-sub">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                &nbsp;·&nbsp;
                {{ auth()->user()?->company?->name ?? 'Portal Industri' }}
            </div>
        </div>
    </div>

    {{-- KPI grid --}}
    <div class="kpi-row">
        <div class="kpi">
            <div class="kpi-lbl">Jumlah Permohonan</div>
            <div class="kpi-val">{{ $total }}</div>
            <div class="kpi-foot">Keseluruhan permohonan</div>
        </div>
        <div class="kpi accent-amber">
            <div class="kpi-lbl">Dalam Proses</div>
            <div class="kpi-val v-amber">{{ $pending + $inReview }}</div>
            <div class="kpi-foot">
                @if($pending > 0)
                    <strong>{{ $pending }}</strong>&nbsp;perlu perhatian
                @else
                    Tiada tindakan segera
                @endif
            </div>
        </div>
        <div class="kpi accent-brand">
            <div class="kpi-lbl">Diluluskan</div>
            <div class="kpi-val v-brand">{{ $approved }}</div>
            <div class="kpi-foot">Permohonan berjaya</div>
        </div>
        <div class="kpi accent-red">
            <div class="kpi-lbl">Ditolak</div>
            <div class="kpi-val v-red">{{ $rejected }}</div>
            <div class="kpi-foot">
                @if($rejected > 0)
                    Semak sebab penolakan
                @else
                    Tiada penolakan
                @endif
            </div>
        </div>
    </div>

    {{-- Recent applications --}}
    <div class="card">
        <div class="card-head">
            <span class="card-title">Permohonan Terkini</span>
            @if(!$recentApplications->isEmpty())
                <span class="card-meta">{{ $recentApplications->count() }} daripada {{ $total }}</span>
            @endif
            <a href="{{ route('industri.applications.index') }}" class="card-link">
                Lihat semua
                <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 8h10M9 4l4 4-4 4"/>
                </svg>
            </a>
        </div>

        @if ($recentApplications->isEmpty())
            <div class="empty">
                <div class="empty-icon">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="empty-title">Tiada permohonan lagi</div>
                <div class="empty-sub">Mulakan permohonan pertama anda untuk mendaftarkan produk racun makhluk perosak.</div>
                <a href="{{ route('industri.applications.create') }}" class="btn-primary">
                    <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                    Buat Permohonan Baharu
                </a>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>No. Permohonan</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Tarikh</th>
                            <th style="width:80px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentApplications as $app)
                            @php
                                $stClass = match($app->current_stage->color()) {
                                    'success' => 'st-ok',
                                    'danger'  => 'st-rej',
                                    'warning' => 'st-rev',
                                    'info'    => 'st-sub',
                                    'primary' => 'st-dec',
                                    default   => 'st-drf',
                                };
                            @endphp
                            <tr>
                                <td><span class="app-chip">{{ $app->application_no }}</span></td>
                                <td>
                                    <div class="prod-name">{{ $app->product?->name ?? '—' }}</div>
                                    @if($app->product?->activeIngredients->first())
                                        <div class="prod-ing">{{ $app->product->activeIngredients->first()->name }}</div>
                                    @endif
                                </td>
                                <td style="color:var(--text-3);font-size:13px">{{ $app->category?->name_ms ?? '—' }}</td>
                                <td><span class="st {{ $stClass }}">{{ $app->current_stage->label() }}</span></td>
                                <td style="font-size:12px;color:var(--text-4);white-space:nowrap">
                                    {{ ($app->submitted_at ?? $app->created_at)->format('d M Y') }}
                                </td>
                                <td>
                                    <a href="{{ route('industri.applications.show', $app) }}" class="tbl-action">
                                        Semak →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</x-layouts.industri>
