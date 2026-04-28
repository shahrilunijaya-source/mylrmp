<x-layouts.industri title="Permohonan Saya">

    {{-- Page heading --}}
    <div class="pg-head">
        <div>
            <div class="pg-title">Permohonan Saya</div>
            <div class="pg-sub">Semua permohonan pendaftaran produk syarikat anda</div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <span class="card-title">Senarai Permohonan</span>
            @if(!$applications->isEmpty())
                <span class="card-meta">{{ $applications->total() }} permohonan</span>
            @endif
        </div>

        @if ($applications->isEmpty())
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
                    Mulakan Permohonan Pertama
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
                            <th>Tarikh Hantar</th>
                            <th style="width:80px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $app)
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
                                    @if($app->category?->name_ms)
                                        <div class="prod-ing">{{ $app->category->name_ms }}</div>
                                    @endif
                                </td>
                                <td style="color:var(--text-3);font-size:13px;">
                                    {{ $app->subcategory?->name_ms ?? '—' }}
                                </td>
                                <td><span class="st {{ $stClass }}">{{ $app->current_stage->label() }}</span></td>
                                <td style="font-size:12px;color:var(--text-4);white-space:nowrap;">
                                    {{ $app->submitted_at?->format('d M Y') ?? '—' }}
                                </td>
                                <td>
                                    <a href="{{ route('industri.applications.show', $app) }}" class="tbl-action">Semak →</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($applications->hasPages())
                <div style="padding:14px 20px;border-top:1px solid var(--border);">
                    {{ $applications->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.industri>
