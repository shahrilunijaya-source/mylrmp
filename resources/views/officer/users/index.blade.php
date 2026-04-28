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
            <div style="display:flex;align-items:center;gap:12px;margin-left:auto;">
                @if(session('success'))
                    <span style="font-size:12px;color:#15803d;display:flex;align-items:center;gap:5px;">
                        <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ session('success') }}
                    </span>
                @endif
                <span class="card-meta">{{ $users->total() }} pengguna</span>
                @can('users.create')
                <button class="btn-navy" onclick="openAddUser()">
                    <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                    Tambah Pengguna
                </button>
                @endcan
            </div>
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

    {{-- ── Add User Modal ─────────────────────────────── --}}
    <style>
        .modal-backdrop {
            position: fixed; inset: 0;
            background: rgba(6,27,49,0.55);
            display: flex; align-items: center; justify-content: center;
            z-index: 100;
            opacity: 0; pointer-events: none;
            transition: opacity 200ms ease;
        }
        .modal-backdrop.open { opacity: 1; pointer-events: auto; }
        .modal-box {
            background: #fff;
            border-radius: 10px;
            width: 92vw; max-width: 480px;
            overflow: hidden;
            display: flex; flex-direction: column;
            box-shadow: rgba(6,27,49,0.28) 0px 24px 64px -8px, rgba(0,0,0,0.12) 0px 8px 20px -4px;
            transform: scale(0.95) translateY(12px);
            transition: transform 200ms ease;
        }
        .modal-backdrop.open .modal-box { transform: scale(1) translateY(0); }
        .modal-hd {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px;
            background: var(--navy);
            flex-shrink: 0;
        }
        .modal-title { font-size: 14px; font-weight: 600; color: #fff; }
        .modal-cls {
            width: 28px; height: 28px;
            border-radius: 6px; border: none;
            background: rgba(255,255,255,0.15);
            color: #fff; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; transition: background .15s;
        }
        .modal-cls:hover { background: rgba(255,255,255,0.25); }
        .modal-bd { padding: 24px 20px; }
        .modal-fld { margin-bottom: 16px; }
        .modal-fld:last-child { margin-bottom: 0; }
    </style>

    <div class="modal-backdrop {{ $errors->any() ? 'open' : '' }}" id="addUserBackdrop" onclick="handleBackdrop(event)">
        <div class="modal-box" onclick="event.stopPropagation()">
            <div class="modal-hd">
                <span class="modal-title">Tambah Pengguna Baharu</span>
                <button class="modal-cls" type="button" onclick="closeAddUser()">✕</button>
            </div>
            <div class="modal-bd">
                <form method="POST" action="{{ route('officer.users.store') }}">
                    @csrf

                    <div class="modal-fld">
                        <label class="form-label">Nama Penuh <span style="color:var(--red)">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-input" placeholder="cth. Ahmad bin Ali">
                        @error('name')
                            <p style="font-size:12px;color:var(--red);margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="modal-fld">
                        <label class="form-label">Alamat E-mel <span style="color:var(--red)">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-input" placeholder="cth. ahmad@doa.gov.my">
                        @error('email')
                            <p style="font-size:12px;color:var(--red);margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="modal-fld">
                        <label class="form-label">Kata Laluan <span style="color:var(--red)">*</span></label>
                        <input type="password" name="password"
                               class="form-input" placeholder="Minimum 8 aksara">
                        @error('password')
                            <p style="font-size:12px;color:var(--red);margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="modal-fld">
                        <label class="form-label">Peranan <span style="color:var(--red)">*</span></label>
                        <select name="role" class="form-select">
                            <option value="">-- Pilih peranan --</option>
                            @foreach(\Spatie\Permission\Models\Role::orderBy('name')->get() as $role)
                                @if($role->name !== 'Industri')
                                    <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('role')
                            <p style="font-size:12px;color:var(--red);margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:24px;">
                        <button type="button" class="btn-ghost" onclick="closeAddUser()">Batal</button>
                        <button type="submit" class="btn-navy">Simpan Pengguna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openAddUser()  { document.getElementById('addUserBackdrop').classList.add('open'); }
        function closeAddUser() { document.getElementById('addUserBackdrop').classList.remove('open'); }
        function handleBackdrop(e) { if (e.target === document.getElementById('addUserBackdrop')) closeAddUser(); }
    </script>

</x-layouts.officer>
