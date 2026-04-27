<x-layouts.industri title="Permohonan Saya">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
        <div>
            <div style="font-size:18px;font-weight:700;color:var(--text-1);letter-spacing:-0.02em;">Senarai Permohonan</div>
            <div style="font-size:12px;color:var(--text-4);margin-top:2px;">Semua permohonan pendaftaran produk syarikat anda</div>
        </div>
        <a href="{{ route('industri.applications.create') }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:var(--brand);color:#fff;font-size:13px;font-weight:500;border-radius:8px;text-decoration:none;transition:background 0.12s;"
           onmouseover="this.style.background='var(--brand-mid)'" onmouseout="this.style.background='var(--brand)'">
            <svg viewBox="0 0 20 20" fill="currentColor" width="14" height="14">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
            </svg>
            Permohonan Baharu
        </a>
    </div>

    <div class="section-card" style="padding:0;overflow:hidden;">
        @if ($applications->isEmpty())
            <div style="padding:60px 20px;text-align:center;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="40" height="40" style="color:var(--text-4);margin:0 auto 12px;display:block;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p style="font-size:13px;color:var(--text-4);margin:0 0 12px;">Tiada permohonan lagi.</p>
                <a href="{{ route('industri.applications.create') }}"
                   style="display:inline-block;padding:8px 16px;background:var(--brand);color:#fff;font-size:13px;font-weight:500;border-radius:8px;text-decoration:none;">
                    Mulakan Permohonan Pertama
                </a>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No. Permohonan</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Tarikh Hantar</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $app)
                            @php
                                $chipClass = match($app->current_stage->color()) {
                                    'success' => 'chip-green',
                                    'danger'  => 'chip-red',
                                    'warning' => 'chip-amber',
                                    'info'    => 'chip-blue',
                                    'primary' => 'chip-brand',
                                    default   => 'chip-gray',
                                };
                            @endphp
                            <tr>
                                <td>
                                    <span style="font-family:'SF Mono','Courier New',monospace;font-size:11px;background:var(--border-soft);padding:2px 6px;border-radius:4px;color:var(--text-2);">
                                        {{ $app->application_no }}
                                    </span>
                                </td>
                                <td style="font-weight:500;color:var(--text-1);">{{ $app->product?->name ?? '-' }}</td>
                                <td>
                                    @if($app->category?->name)
                                        <span class="chip chip-gray">{{ $app->category->name }}</span>
                                    @else
                                        <span style="color:var(--text-4);">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="chip {{ $chipClass }}">{{ $app->current_stage->label() }}</span>
                                </td>
                                <td style="color:var(--text-3);font-size:12px;">
                                    {{ $app->submitted_at?->format('d/m/Y') ?? '-' }}
                                </td>
                                <td style="text-align:right;padding-right:16px;">
                                    <a href="{{ route('industri.applications.show', $app) }}"
                                       style="font-size:12px;font-weight:500;color:var(--brand);text-decoration:none;border:1px solid var(--brand);padding:4px 12px;border-radius:6px;display:inline-block;transition:all 0.12s;"
                                       onmouseover="this.style.background='var(--brand-light)'" onmouseout="this.style.background='transparent'">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($applications->hasPages())
                <div style="padding:12px 16px;border-top:1px solid var(--border-soft);">
                    {{ $applications->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.industri>
