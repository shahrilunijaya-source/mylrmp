<x-layouts.officer title="Peti Masuk Permohonan">

    {{-- Page heading --}}
    <div class="pg-head">
        <div>
            <div class="pg-title">Peti Masuk Permohonan</div>
            <div class="pg-sub">
                {{ $applications->total() }} permohonan
                @if($stage)
                    &nbsp;·&nbsp; Menapis: <strong>{{ \App\Enums\ApplicationStage::from($stage)->label() }}</strong>
                @endif
                @if($search)
                    &nbsp;·&nbsp; Carian: <strong>"{{ $search }}"</strong>
                @endif
            </div>
        </div>
    </div>

    {{-- Filter row --}}
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;flex-wrap:wrap;">

        {{-- Search --}}
        <form method="GET" action="{{ route('officer.applications.index') }}" style="display:flex;align-items:center;gap:8px;">
            @if($stage)
                <input type="hidden" name="stage" value="{{ $stage }}">
            @endif
            <div style="display:flex;align-items:center;gap:8px;background:#fff;border:1px solid var(--border);border-radius:6px;padding:7px 12px;">
                <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor" style="color:var(--text-4);flex-shrink:0;">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                </svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari no. permohonan, syarikat, produk..."
                       style="border:none;outline:none;font-family:var(--font);font-size:13px;color:var(--text);background:none;width:240px;">
            </div>
            <button type="submit" class="btn-navy" style="padding:8px 14px;font-size:13px;">Cari</button>
            @if($search || $stage)
                <a href="{{ route('officer.applications.index') }}" class="btn-ghost">Kosongkan</a>
            @endif
        </form>

        {{-- Stage filter pills --}}
        <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;margin-left:auto;">
            <a href="{{ route('officer.applications.index', array_filter(['search' => $search])) }}"
               class="st {{ !$stage ? 'st-sub' : 'st-drf' }}"
               style="text-decoration:none;cursor:pointer;">
                Semua
            </a>
            @foreach($stages as $stageCase)
                @php
                    $stClass = match($stageCase->value) {
                        'approved'        => 'st-ok',
                        'rejected'        => 'st-rej',
                        'submitted'       => 'st-sub',
                        'tech_review'     => 'st-tec',
                        'label_review'    => 'st-lbl',
                        'decision'        => 'st-dec',
                        'needs_revision'  => 'st-nds',
                        default           => 'st-drf',
                    };
                    $isActive = $stage === $stageCase->value;
                @endphp
                <a href="{{ route('officer.applications.index', array_filter(['stage' => $stageCase->value, 'search' => $search])) }}"
                   class="st {{ $isActive ? $stClass : 'st-drf' }}"
                   style="text-decoration:none;cursor:pointer;{{ $isActive ? '' : 'opacity:0.7;' }}">
                    {{ $stageCase->label() }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Applications table --}}
    <div class="card">
        <div class="card-head">
            <span class="card-title">Senarai Permohonan</span>
            <span class="card-meta">{{ $applications->total() }} rekod</span>
        </div>

        @if($applications->isEmpty())
            <div class="empty">
                <div class="empty-icon">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="empty-title">Tiada permohonan dijumpai</div>
                <div class="empty-sub">
                    @if($search || $stage)
                        Cuba ubah penapis atau carian anda.
                    @else
                        Tiada permohonan dalam sistem buat masa ini.
                    @endif
                </div>
                @if($search || $stage)
                    <a href="{{ route('officer.applications.index') }}" class="btn-ghost">Paparkan Semua</a>
                @endif
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>No. Permohonan</th>
                            <th>Syarikat</th>
                            <th>Produk</th>
                            <th>Peringkat</th>
                            <th>Tarikh Hantar</th>
                            <th>Hari Berlalu</th>
                            <th style="width:80px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $app)
                            @php
                                $stClass = match($app->current_stage->value) {
                                    'approved'        => 'st-ok',
                                    'rejected'        => 'st-rej',
                                    'submitted'       => 'st-sub',
                                    'tech_review'     => 'st-tec',
                                    'label_review'    => 'st-lbl',
                                    'decision'        => 'st-dec',
                                    'needs_revision'  => 'st-nds',
                                    default           => 'st-drf',
                                };
                                $daysSince = $app->submitted_at ? (int) $app->submitted_at->diffInDays(now()) : null;
                            @endphp
                            <tr>
                                <td><span class="app-chip">{{ $app->application_no }}</span></td>
                                <td style="font-size:13px;color:var(--text-2);">{{ $app->company?->name ?? '—' }}</td>
                                <td>
                                    <div class="prod-name">{{ $app->product?->name ?? '—' }}</div>
                                    @if($app->product?->activeIngredients?->first())
                                        <div class="prod-ing">{{ $app->product->activeIngredients->first()->name }}</div>
                                    @endif
                                </td>
                                <td><span class="st {{ $stClass }}">{{ $app->current_stage->label() }}</span></td>
                                <td style="font-size:12px;color:var(--text-4);white-space:nowrap;">
                                    {{ $app->submitted_at?->format('d M Y') ?? '—' }}
                                </td>
                                <td style="font-size:12px;white-space:nowrap;">
                                    @if($daysSince !== null)
                                        <span style="color:{{ $daysSince > 45 ? 'var(--red)' : ($daysSince > 30 ? 'var(--amber)' : 'var(--text-3)') }}">
                                            {{ $daysSince }} hari
                                        </span>
                                    @else
                                        <span style="color:var(--text-4)">—</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('officer.applications.show', $app) }}" class="tbl-action">Semak →</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($applications->hasPages())
                <div class="pagination">
                    {{ $applications->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.officer>
