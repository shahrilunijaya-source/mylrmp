<x-layouts.officer title="Pengguna Sistem">

    {{-- Page heading --}}
    <div class="pg-head">
        <div>
            <div class="pg-title">Pengguna Sistem</div>
            <div class="pg-sub">Semua akaun pengguna berdaftar dalam sistem myLRMP</div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <span class="card-title">Senarai Pengguna</span>
            <span class="card-meta">{{ $users->total() }} pengguna</span>
        </div>

        @if($users->isEmpty())
            <div class="empty">
                <div class="empty-icon">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
                <div class="empty-title">Tiada pengguna dijumpai</div>
                <div class="empty-sub">Belum ada akaun pengguna dalam sistem.</div>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>E-mel</th>
                            <th>Peranan</th>
                            <th>Syarikat</th>
                            <th>Status</th>
                            <th style="width:80px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            @php
                                $isActive = $user->email_verified_at !== null;
                                $initials = implode('', array_map(fn($w) => strtoupper($w[0] ?? ''), array_slice(explode(' ', $user->name ?? 'U'), 0, 2)));
                            @endphp
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:9px;">
                                        <div style="width:30px;height:30px;border-radius:50%;background:var(--bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:10.5px;font-weight:700;color:var(--text-3);flex-shrink:0;">
                                            {{ $initials }}
                                        </div>
                                        <span style="font-weight:500;font-size:13.5px;color:var(--text);">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td style="font-size:13px;color:var(--text-3);">{{ $user->email }}</td>
                                <td>
                                    <div style="display:flex;flex-wrap:wrap;gap:4px;">
                                        @forelse($user->roles ?? [] as $role)
                                            @php
                                                $roleName = $role->name ?? $role;
                                                $isSuperAdmin = str_contains(strtolower($roleName), 'super') || str_contains(strtolower($roleName), 'admin');
                                                $isIndustri   = str_contains(strtolower($roleName), 'industri');
                                                if ($isSuperAdmin) {
                                                    $pillBg    = '#fef2f2';
                                                    $pillColor = '#b91c1c';
                                                } elseif ($isIndustri) {
                                                    $pillBg    = '#f0fdf4';
                                                    $pillColor = '#15803d';
                                                } else {
                                                    $pillBg    = '#f0f4f9';
                                                    $pillColor = '#061B31';
                                                }
                                            @endphp
                                            <span style="display:inline-block;font-size:10.5px;font-weight:500;padding:2px 8px;border-radius:4px;background:{{ $pillBg }};color:{{ $pillColor }};white-space:nowrap;">
                                                {{ $roleName }}
                                            </span>
                                        @empty
                                            <span style="font-size:12px;color:var(--text-4);">—</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td style="font-size:13px;color:var(--text-3);">{{ $user->company?->name ?? '—' }}</td>
                                <td>
                                    @if($isActive)
                                        <span class="st st-ok">Aktif</span>
                                    @else
                                        <span class="st st-drf">Belum Sahkan</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="app-chip" style="cursor:default;">{{ $user->id }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="pagination">
                    {{ $users->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.officer>
