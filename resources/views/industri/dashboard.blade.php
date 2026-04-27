<x-layouts.industri title="Dashboard">

    {{-- Session messages --}}
    @if (session('success'))
        <div style="margin-bottom:16px;padding:12px 16px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;font-size:13px;color:#15803d;">
            {{ session('success') }}
        </div>
    @endif

    {{-- KPI grid --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:20px">
        <div class="kpi-card">
            <div class="kpi-label">Jumlah Permohonan</div>
            <div class="kpi-value">{{ $total }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Dalam Proses</div>
            <div class="kpi-value orange">{{ $pending + $inReview }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Diluluskan</div>
            <div class="kpi-value green">{{ $approved }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Ditolak</div>
            <div class="kpi-value red">{{ $rejected }}</div>
        </div>
    </div>

    {{-- Recent applications --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-title">Permohonan Terkini</div>
            <a href="{{ route('industri.applications.index') }}" class="section-more">Lihat Semua &rarr;</a>
        </div>

        @if ($recentApplications->isEmpty())
            <div style="padding:40px 0;text-align:center;">
                <p style="font-size:13px;color:var(--text-4);margin:0 0 12px;">Tiada permohonan lagi.</p>
                <a href="{{ route('industri.applications.create') }}"
                   style="display:inline-block;padding:8px 16px;background:var(--brand);color:#fff;font-size:13px;font-weight:500;border-radius:8px;text-decoration:none;">
                    Buat Permohonan Baharu
                </a>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No. Permohonan</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Tarikh</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentApplications as $app)
                            @php
                                $badgeClass = match($app->current_stage->color()) {
                                    'success' => 'badge-diluluskan',
                                    'danger'  => 'badge-ditolak',
                                    'warning' => 'badge-dalam-proses',
                                    'info'    => 'badge-dihantar',
                                    'primary' => 'badge-semakan',
                                    default   => 'badge-draf',
                                };
                            @endphp
                            <tr>
                                <td>
                                    <span style="font-family:'SF Mono','Courier New',monospace;font-size:12px;background:var(--border-soft);padding:2px 6px;border-radius:4px;color:var(--text-2);">
                                        {{ $app->application_no }}
                                    </span>
                                </td>
                                <td style="font-weight:500;color:var(--text-1);">{{ $app->product?->name ?? '-' }}</td>
                                <td style="color:var(--text-3);">{{ $app->category?->name ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $badgeClass }}">{{ $app->current_stage->label() }}</span>
                                </td>
                                <td style="color:var(--text-3);font-size:12px;">
                                    {{ $app->submitted_at?->format('d/m/Y') ?? $app->created_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    <a href="{{ route('industri.applications.show', $app) }}"
                                       style="font-size:12px;font-weight:500;color:var(--brand);text-decoration:none;border:1px solid var(--brand);padding:3px 10px;border-radius:6px;display:inline-block;">
                                        Lihat
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
