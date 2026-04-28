<x-layouts.officer title="Profil Saya">

<div class="pg-head">
    <div>
        <h1 class="pg-title">Profil Saya</h1>
        <p class="pg-sub">Kemaskini maklumat peribadi dan kata laluan akaun anda.</p>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;align-items:start;">

    {{-- ── Left: Personal info ── --}}
    <div>

        {{-- Avatar + role card --}}
        <div class="card" style="margin-bottom:20px;">
            <div style="padding:28px 24px;display:flex;align-items:center;gap:18px;">
                <div style="width:64px;height:64px;background:var(--gold);color:var(--navy);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;flex-shrink:0;letter-spacing:-1px;">
                    {{ strtoupper(substr($user->name ?? 'P', 0, 2)) }}
                </div>
                <div>
                    <div style="font-size:17px;font-weight:700;color:var(--text);letter-spacing:-0.02em;line-height:1.2;">
                        {{ $user->name }}
                    </div>
                    <div style="font-size:12px;color:var(--text-3);margin-top:4px;">
                        {{ $user->email }}
                    </div>
                    <div style="margin-top:8px;">
                        <span style="display:inline-flex;align-items:center;gap:5px;background:var(--navy);color:#fff;font-size:11px;font-weight:600;padding:3px 10px;border-radius:4px;letter-spacing:0.03em;">
                            {{ $user->roles->first()?->name ?? 'Pegawai' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit name / phone --}}
        <div class="card">
            <div class="card-head">
                <span class="card-title">Maklumat Peribadi</span>
            </div>
            <div style="padding:20px 24px;">

                @if(session('success'))
                    <div style="margin-bottom:16px;padding:10px 14px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px;font-size:13px;color:#15803d;display:flex;align-items:center;gap:8px;">
                        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('officer.profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div style="margin-bottom:16px;">
                        <label class="form-label">Nama Penuh <span style="color:var(--red)">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="form-input @error('name') is-invalid @enderror"
                               placeholder="Nama penuh">
                        @error('name')
                            <p style="font-size:12px;color:var(--red);margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="margin-bottom:16px;">
                        <label class="form-label">Alamat E-mel</label>
                        <input type="email" value="{{ $user->email }}" class="form-input"
                               style="background:var(--bg);cursor:not-allowed;color:var(--text-3);" disabled>
                        <p style="font-size:11.5px;color:var(--text-4);margin-top:4px;">E-mel tidak boleh diubah. Hubungi pentadbir sistem.</p>
                    </div>

                    <div style="margin-bottom:20px;">
                        <label class="form-label">No. Telefon</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                               class="form-input"
                               placeholder="cth: 0123456789">
                    </div>

                    <button type="submit" class="btn-navy">
                        <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/>
                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Right: Change password ── --}}
    <div>
        <div class="card">
            <div class="card-head">
                <span class="card-title">Tukar Kata Laluan</span>
            </div>
            <div style="padding:20px 24px;">

                @if(session('password_success'))
                    <div style="margin-bottom:16px;padding:10px 14px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px;font-size:13px;color:#15803d;display:flex;align-items:center;gap:8px;">
                        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ session('password_success') }}
                    </div>
                @endif

                @if($errors->has('current_password'))
                    <div style="margin-bottom:16px;padding:10px 14px;background:var(--red-bg);border:1px solid #fecaca;border-radius:6px;font-size:13px;color:var(--red);">
                        {{ $errors->first('current_password') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('officer.profile.password') }}">
                    @csrf
                    @method('PATCH')

                    <div style="margin-bottom:16px;">
                        <label class="form-label">Kata Laluan Semasa <span style="color:var(--red)">*</span></label>
                        <input type="password" name="current_password"
                               class="form-input @error('current_password') is-invalid @enderror"
                               autocomplete="current-password"
                               placeholder="Kata laluan semasa anda">
                    </div>

                    <div style="margin-bottom:16px;">
                        <label class="form-label">Kata Laluan Baharu <span style="color:var(--red)">*</span></label>
                        <input type="password" name="password"
                               class="form-input @error('password') is-invalid @enderror"
                               autocomplete="new-password"
                               placeholder="Sekurang-kurangnya 8 aksara">
                        @error('password')
                            <p style="font-size:12px;color:var(--red);margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="margin-bottom:24px;">
                        <label class="form-label">Sahkan Kata Laluan Baharu <span style="color:var(--red)">*</span></label>
                        <input type="password" name="password_confirmation"
                               class="form-input"
                               autocomplete="new-password"
                               placeholder="Ulangi kata laluan baharu">
                    </div>

                    <button type="submit" class="btn-navy">
                        <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                        Tukar Kata Laluan
                    </button>
                </form>
            </div>
        </div>

        {{-- Account info --}}
        <div class="card">
            <div class="card-head">
                <span class="card-title">Maklumat Akaun</span>
            </div>
            <div style="padding:0;">
                <dl style="margin:0;">
                    <div style="display:flex;align-items:baseline;justify-content:space-between;padding:12px 20px;border-bottom:1px solid var(--border);">
                        <dt style="font-size:12px;color:var(--text-4);font-weight:500;">Peranan</dt>
                        <dd style="font-size:13px;font-weight:600;color:var(--text);text-align:right;">{{ $user->roles->first()?->name ?? '—' }}</dd>
                    </div>
                    <div style="display:flex;align-items:baseline;justify-content:space-between;padding:12px 20px;border-bottom:1px solid var(--border);">
                        <dt style="font-size:12px;color:var(--text-4);font-weight:500;">Status Akaun</dt>
                        <dd style="font-size:13px;">
                            <span class="st st-ok">Aktif</span>
                        </dd>
                    </div>
                    <div style="display:flex;align-items:baseline;justify-content:space-between;padding:12px 20px;">
                        <dt style="font-size:12px;color:var(--text-4);font-weight:500;">Log Masuk Terakhir</dt>
                        <dd style="font-size:13px;color:var(--text-3);">
                            {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : '—' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

    </div>
</div>

</x-layouts.officer>
