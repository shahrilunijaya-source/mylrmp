<x-layouts.officer title="Senarai Premis">

<div class="pg-head">
    <div>
        <div class="pg-title">Premis Berdaftar</div>
        <div class="pg-sub">Kedai dan premis pengedar racun perosak</div>
    </div>
    @can('premises.create')
    <a href="{{ route('officer.premis.create') }}" class="btn-navy">+ Daftar Premis</a>
    @endcan
</div>

<form method="GET" style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama / no. lesen..."
           class="form-input" style="flex:1;min-width:200px;max-width:320px;">
    <select name="state" class="form-select" style="min-width:180px;">
        <option value="">Semua Negeri</option>
        @foreach($states as $s)
            <option value="{{ $s->value }}" @selected($state === $s->value)>{{ $s->label() }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn-ghost">Tapis</button>
    @if($search || $state)
        <a href="{{ route('officer.premis.index') }}" class="btn-ghost">Padam Penapis</a>
    @endif
</form>

<div class="card">
    <div class="card-head">
        <span class="card-title">Premis</span>
        <span class="card-meta">{{ $premises->total() }} rekod</span>
    </div>

    @if($premises->isEmpty())
        <div class="empty">
            <div class="empty-icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm3 1h6v4H7V5zm8 8v2h1v1H4v-1h1v-2a1 1 0 011-1h8a1 1 0 011 1z" clip-rule="evenodd"/></svg>
            </div>
            <div class="empty-title">Tiada premis dijumpai</div>
            <div class="empty-sub">Cuba ubah penapis atau daftar premis baharu.</div>
        </div>
    @else
        <div style="overflow-x:auto;">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Nama Premis</th>
                        <th>No. Lesen</th>
                        <th>Daerah / Negeri</th>
                        <th>PIC</th>
                        <th>Pemeriksaan</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($premises as $p)
                    <tr>
                        <td>
                            <div class="prod-name">{{ $p->name }}</div>
                            @if($p->address_line1)
                                <div class="prod-ing">{{ $p->address_line1 }}</div>
                            @endif
                        </td>
                        <td><span class="app-chip">{{ $p->license_no ?? '—' }}</span></td>
                        <td style="font-size:13px;color:var(--text-3);">
                            {{ $p->district ? $p->district . ', ' : '' }}{{ $p->state?->label() ?? '—' }}
                        </td>
                        <td style="font-size:13px;color:var(--text-3);">{{ $p->pic_name ?? '—' }}</td>
                        <td>
                            <span style="display:inline-flex;align-items:center;justify-content:center;min-width:24px;height:22px;padding:0 7px;background:var(--bg);border:1px solid var(--border);border-radius:9999px;font-size:11.5px;font-weight:600;color:var(--text-3);">
                                {{ $p->inspections_count }}
                            </span>
                        </td>
                        <td>
                            @if($p->is_active)
                                <span class="st st-ok">Aktif</span>
                            @else
                                <span class="st st-drf">Tidak Aktif</span>
                            @endif
                        </td>
                        <td><a href="{{ route('officer.premis.show', $p) }}" class="tbl-action">Lihat →</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($premises->hasPages())
            <div class="pagination">{{ $premises->links() }}</div>
        @endif
    @endif
</div>

</x-layouts.officer>
