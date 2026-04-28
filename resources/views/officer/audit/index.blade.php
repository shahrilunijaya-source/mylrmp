<x-layouts.officer title="Log Audit">

    {{-- Page heading --}}
    <div class="pg-head">
        <div>
            <div class="pg-title">Log Audit</div>
            <div class="pg-sub">Semua aktiviti sistem yang direkodkan secara automatik</div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <span class="card-title">Rekod Aktiviti</span>
            <span class="card-meta">{{ $activities->total() }} rekod</span>
        </div>

        @if($activities->isEmpty())
            <div class="empty">
                <div class="empty-icon">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="empty-title">Tiada log audit</div>
                <div class="empty-sub">Belum ada aktiviti direkodkan dalam sistem.</div>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Penerangan</th>
                            <th>Jenis Subjek</th>
                            <th style="white-space:nowrap;">Tarikh &amp; Masa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                            @php
                                // Get short class name from subject_type
                                $subjectType = $activity->subject_type ?? '';
                                if ($subjectType) {
                                    $parts = explode('\\', $subjectType);
                                    $shortType = end($parts);
                                } else {
                                    $shortType = '—';
                                }

                                // Causer name
                                $causerName = $activity->causer?->name ?? 'Sistem';
                                $isCauserSystem = !$activity->causer;
                            @endphp
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        @if($isCauserSystem)
                                            <div style="width:28px;height:28px;border-radius:50%;background:var(--bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor" style="color:var(--text-4);">
                                                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        @else
                                            @php
                                                $initials = implode('', array_map(fn($w) => strtoupper($w[0] ?? ''), array_slice(explode(' ', $causerName), 0, 2)));
                                            @endphp
                                            <div style="width:28px;height:28px;border-radius:50%;background:var(--bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:var(--text-3);flex-shrink:0;">
                                                {{ $initials }}
                                            </div>
                                        @endif
                                        <span style="font-size:13px;color:{{ $isCauserSystem ? 'var(--text-4)' : 'var(--text-2)' }};">
                                            {{ $causerName }}
                                        </span>
                                    </div>
                                </td>
                                <td style="font-size:13px;color:var(--text-2);max-width:360px;">
                                    {{ $activity->description ?? '—' }}
                                </td>
                                <td>
                                    @if($shortType !== '—')
                                        <span style="display:inline-block;font-size:11px;font-weight:500;padding:2px 8px;border-radius:4px;background:var(--bg);border:1px solid var(--border);color:var(--text-3);font-family:var(--mono);white-space:nowrap;">
                                            {{ $shortType }}
                                        </span>
                                    @else
                                        <span style="color:var(--text-4);font-size:12px;">—</span>
                                    @endif
                                </td>
                                <td style="font-size:12px;color:var(--text-4);white-space:nowrap;">
                                    {{ $activity->created_at?->format('d/m/Y H:i') ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($activities->hasPages())
                <div class="pagination">
                    {{ $activities->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.officer>
