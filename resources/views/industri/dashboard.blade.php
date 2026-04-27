<x-layouts.industri>
    <x-slot name="title">Dashboard</x-slot>

    <div class="content-area">

        {{-- Session messages --}}
        @if (session('success'))
            <div style="margin-bottom: 16px; padding: 12px 16px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; font-size: 14px; color: #15803d;">
                {{ session('success') }}
            </div>
        @endif

        {{-- KPI cards --}}
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px;">
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
        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid #f3f4f6;">
                <h2 style="font-size: 16px; font-weight: 600; color: #111827; letter-spacing: -0.01em; margin: 0;">Permohonan Terkini</h2>
                <a href="{{ route('industri.applications.index') }}"
                   style="font-size: 13px; font-weight: 500; color: #5e6ad2; text-decoration: none; transition: color 0.15s;"
                   onmouseover="this.style.color='#7170ff'"
                   onmouseout="this.style.color='#5e6ad2'">
                    Lihat Semua &rarr;
                </a>
            </div>

            @if ($recentApplications->isEmpty())
                <div style="padding: 48px 20px; text-align: center;">
                    <p style="font-size: 14px; color: #9ca3af; margin: 0 0 12px;">Tiada permohonan lagi.</p>
                    <a href="{{ route('industri.applications.create') }}"
                       style="display: inline-block; padding: 8px 16px; background: #5e6ad2; color: white; font-size: 13px; font-weight: 500; border-radius: 8px; text-decoration: none; transition: background 0.15s;"
                       onmouseover="this.style.background='#7170ff'"
                       onmouseout="this.style.background='#5e6ad2'">
                        Buat Permohonan Baharu
                    </a>
                </div>
            @else
                <div style="overflow-x: auto;">
                    <table class="data-table">
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
                            @foreach ($recentApplications as $app)
                                <tr>
                                    <td>
                                        <span style="font-family: 'SF Mono', 'Fira Code', monospace; font-size: 12px; color: #374151;">{{ $app->application_no }}</span>
                                    </td>
                                    <td style="font-weight: 500; color: #111827;">{{ $app->product?->name ?? '-' }}</td>
                                    <td>
                                        @php
                                            $stageLabel = $app->current_stage->label();
                                            $badgeClass = match($app->current_stage->color()) {
                                                'success' => 'badge-diluluskan',
                                                'danger'  => 'badge-ditolak',
                                                'warning' => 'badge-dalam-proses',
                                                'info'    => 'badge-dihantar',
                                                'primary' => 'badge-semakan',
                                                default   => 'badge-draf',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $stageLabel }}</span>
                                    </td>
                                    <td style="color: #6b7280; font-size: 13px;">
                                        {{ $app->submitted_at?->format('d/m/Y') ?? $app->created_at->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('industri.applications.show', $app) }}"
                                           style="font-size: 13px; font-weight: 500; color: #5e6ad2; text-decoration: none; transition: color 0.15s;"
                                           onmouseover="this.style.color='#7170ff'"
                                           onmouseout="this.style.color='#5e6ad2'">
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

    </div>
</x-layouts.industri>
