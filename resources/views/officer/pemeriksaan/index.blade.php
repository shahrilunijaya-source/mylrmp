<x-layouts.officer title="Pemeriksaan">

<div class="pg-head">
    <div>
        <div class="pg-title">e-Pemeriksaan</div>
        <div class="pg-sub">Jadual dan rekod pemeriksaan premis &amp; syarikat</div>
    </div>
    @can('inspections.schedule')
    <a href="{{ route('officer.pemeriksaan.create') }}" class="btn-navy">+ Jadual Pemeriksaan</a>
    @endcan
</div>

@if(session('success'))
    <div style="background:var(--brand-light);border:1px solid #bbf7d0;border-radius:8px;padding:12px 16px;font-size:13px;color:var(--brand);margin-bottom:20px;">{{ session('success') }}</div>
@endif

<form method="GET" style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;align-items:center;">
    <select name="status" class="form-select" style="min-width:200px;">
        <option value="">Semua Status</option>
        @foreach($statuses as $s)
            <option value="{{ $s->value }}" @selected($status === $s->value)>{{ $s->label() }}</option>
        @endforeach
    </select>
    <label style="display:flex;align-items:center;gap:6px;font-size:13px;color:var(--text-2);cursor:pointer;">
        <input type="checkbox" name="mine" value="1" @checked($mine)> Ditugaskan kepada saya
    </label>
    <button type="submit" class="btn-ghost">Tapis</button>
    @if($status || $mine)
        <a href="{{ route('officer.pemeriksaan.index') }}" class="btn-ghost">Padam Penapis</a>
    @endif
</form>

<div class="card">
    <div class="card-head">
        <span class="card-title">Rekod Pemeriksaan</span>
        <span class="card-meta">{{ $inspections->total() }} rekod</span>
    </div>

    @if($inspections->isEmpty())
        <div class="empty">
            <div class="empty-icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            </div>
            <div class="empty-title">Tiada rekod pemeriksaan</div>
            <div class="empty-sub">Jadualkan pemeriksaan pertama menggunakan butang di atas.</div>
        </div>
    @else
        <div style="overflow-x:auto;">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>No. Pemeriksaan</th>
                        <th>Sasaran</th>
                        <th>Pemeriksa</th>
                        <th>Tarikh Dijadual</th>
                        <th>Penemuan</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inspections as $insp)
                    <tr>
                        <td><span class="app-chip">{{ $insp->inspection_no }}</span></td>
                        <td style="font-size:13px;color:var(--text-2);">{{ $insp->targetLabel() }}</td>
                        <td style="font-size:13px;color:var(--text-2);">{{ $insp->inspector?->name ?? '—' }}</td>
                        <td style="font-size:13px;color:var(--text-3);white-space:nowrap;">{{ $insp->scheduled_for?->format('d M Y') }}</td>
                        <td>
                            <span style="display:inline-flex;align-items:center;justify-content:center;min-width:24px;height:22px;padding:0 7px;background:var(--bg);border:1px solid var(--border);border-radius:9999px;font-size:11.5px;font-weight:600;color:var(--text-3);">
                                {{ $insp->findings_count }}
                            </span>
                        </td>
                        <td><span class="st {{ $insp->status->cssClass() }}">{{ $insp->status->label() }}</span></td>
                        <td><a href="{{ route('officer.pemeriksaan.show', $insp) }}" class="tbl-action">Lihat →</a></td>
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

</x-layouts.officer>
