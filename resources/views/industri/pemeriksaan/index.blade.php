<x-layouts.industri title="Rekod Pemeriksaan">

<div class="pg-head">
    <div>
        <div class="pg-title">Rekod Pemeriksaan</div>
        <div class="pg-sub">Sejarah pemeriksaan yang dijalankan terhadap {{ $company->name }}</div>
    </div>
</div>

<div class="card">
    <div class="card-head">
        <span class="card-title">Senarai Pemeriksaan</span>
        @if(!$inspections->isEmpty())
            <span class="card-meta">{{ $inspections->total() }} rekod</span>
        @endif
    </div>

    @if($inspections->isEmpty())
        <div class="empty">
            <div class="empty-icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="empty-title">Tiada rekod pemeriksaan</div>
            <div class="empty-sub">Tiada pemeriksaan telah dijalankan terhadap syarikat anda setakat ini.</div>
        </div>
    @else
        <div style="overflow-x:auto;">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>No. Pemeriksaan</th>
                        <th>Tarikh Dijadual</th>
                        <th>Tarikh Dijalankan</th>
                        <th>Pemeriksa</th>
                        <th>Penemuan</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inspections as $insp)
                    <tr>
                        <td><span class="app-chip">{{ $insp->inspection_no }}</span></td>
                        <td style="font-size:13px;color:var(--text-3);white-space:nowrap;">
                            {{ $insp->scheduled_for?->format('d M Y') ?? '—' }}
                        </td>
                        <td style="font-size:13px;color:var(--text-3);white-space:nowrap;">
                            {{ $insp->conducted_at?->format('d M Y') ?? '—' }}
                        </td>
                        <td style="font-size:13px;color:var(--text-2);">
                            {{ $insp->inspector?->name ?? '—' }}
                        </td>
                        <td>
                            @if($insp->findings_count > 0)
                                <span style="display:inline-flex;align-items:center;justify-content:center;min-width:24px;height:22px;padding:0 8px;background:var(--red-bg);border:1px solid #fecaca;border-radius:9999px;font-size:11.5px;font-weight:700;color:var(--red);">
                                    {{ $insp->findings_count }}
                                </span>
                            @else
                                <span style="font-size:12px;color:var(--text-4);">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="st {{ $insp->status->cssClass() }}">{{ $insp->status->label() }}</span>
                        </td>
                        <td>
                            @if($insp->status->isTerminal() && $insp->status !== \App\Enums\InspectionStatus::Cancelled)
                                <a href="{{ route('industri.pemeriksaan.show', $insp) }}" class="tbl-action">Lihat →</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($inspections->hasPages())
            <div class="pagination">{{ $inspections->links() }}</div>
        @endif
    @endif
</div>

{{-- Info notice --}}
<div style="background:var(--blue-bg);border:1px solid #bfdbfe;border-radius:8px;padding:14px 18px;display:flex;gap:12px;align-items:flex-start;margin-top:4px;">
    <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor" style="color:var(--blue);flex-shrink:0;margin-top:1px;">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
    </svg>
    <div style="font-size:13px;color:var(--blue);line-height:1.6;">
        Halaman ini menunjukkan pemeriksaan yang telah dijalankan oleh pegawai Jabatan Pertanian Malaysia terhadap syarikat anda. Jika anda menerima notis ketidakpatuhan, sila pastikan semua pembetulan dilaksanakan sebelum tarikh akhir yang ditetapkan.
    </div>
</div>

</x-layouts.industri>
