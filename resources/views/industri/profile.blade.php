<x-layouts.industri title="Profil Saya">

    {{-- Page heading --}}
    <div class="pg-head">
        <div>
            <div class="pg-title">Profil Saya</div>
            <div class="pg-sub">Maklumat akaun dan syarikat anda</div>
        </div>
    </div>

    {{-- Success banners --}}
    @if (session('success'))
        <div style="margin-bottom:16px;padding:12px 16px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px;font-size:13px;color:var(--brand);display:flex;align-items:center;gap:8px;max-width:900px;">
            <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if (session('password_success'))
        <div style="margin-bottom:16px;padding:12px 16px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px;font-size:13px;color:var(--brand);display:flex;align-items:center;gap:8px;max-width:900px;">
            <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('password_success') }}
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;max-width:900px;">

        {{-- User info --}}
        <div class="card" style="overflow:visible;">
            <div class="card-head">
                <span class="card-title">Maklumat Pengguna</span>
                @if($user->is_active)
                    <span class="st st-ok">Aktif</span>
                @else
                    <span class="st st-rej">Tidak Aktif</span>
                @endif
            </div>
            <div style="padding:20px;">

                {{-- Avatar --}}
                <div style="display:flex;align-items:center;gap:14px;padding-bottom:18px;border-bottom:1px solid var(--border);margin-bottom:18px;">
                    <div style="width:52px;height:52px;border-radius:50%;background:var(--brand);color:#fff;font-size:18px;font-weight:600;display:flex;align-items:center;justify-content:center;flex-shrink:0;letter-spacing:-0.5px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:15px;font-weight:600;color:var(--text);margin-bottom:2px;">{{ $user->name }}</div>
                        <div style="font-size:12.5px;color:var(--text-3);">{{ $user->email }}</div>
                    </div>
                </div>

                <dl style="display:flex;flex-direction:column;gap:14px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <dt style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-4);">Nama</dt>
                        <dd style="font-size:13.5px;font-weight:500;color:var(--text);">{{ $user->name }}</dd>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <dt style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-4);">E-mel</dt>
                        <dd style="font-size:13px;color:var(--text-2);">{{ $user->email }}</dd>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <dt style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-4);">No. Telefon</dt>
                        <dd style="font-size:13px;color:{{ $user->phone ? 'var(--text-2)' : 'var(--text-4)' }};">{{ $user->phone ?? '—' }}</dd>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <dt style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-4);">Peranan</dt>
                        <dd style="font-size:13px;color:var(--text-2);">Industri</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Company info --}}
        @if ($company)
            <div class="card" style="overflow:visible;">
                <div class="card-head">
                    <span class="card-title">Maklumat Syarikat</span>
                    <span class="st st-ok">{{ ucfirst($company->status->value) }}</span>
                </div>
                <div style="padding:20px;">

                    <div style="padding-bottom:18px;border-bottom:1px solid var(--border);margin-bottom:18px;">
                        <div style="font-size:15px;font-weight:600;color:var(--text);margin-bottom:3px;">{{ $company->name }}</div>
                        <div style="font-size:12px;font-family:var(--mono);color:var(--text-3);">SSM: {{ $company->ssm_no }}</div>
                    </div>

                    <dl style="display:flex;flex-direction:column;gap:14px;">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;">
                            <dt style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-4);flex-shrink:0;">Alamat</dt>
                            <dd style="font-size:13px;color:var(--text-2);text-align:right;">{{ $company->address ?? '—' }}</dd>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
                            <dt style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-4);flex-shrink:0;">Orang Hubungi</dt>
                            <dd style="font-size:13px;color:var(--text-2);">{{ $company->contact_person ?? '—' }}</dd>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
                            <dt style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-4);flex-shrink:0;">Telefon</dt>
                            <dd style="font-size:13px;color:{{ $company->phone ? 'var(--text-2)' : 'var(--text-4)' }};">{{ $company->phone ?? '—' }}</dd>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
                            <dt style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-4);flex-shrink:0;">E-mel</dt>
                            <dd style="font-size:13px;color:var(--text-2);">{{ $company->email ?? '—' }}</dd>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
                            <dt style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-4);flex-shrink:0;">Tarikh Daftar</dt>
                            <dd style="font-size:13px;color:var(--text-2);">{{ $company->registered_at?->format('d M Y') ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        @else
            <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:20px;">
                <div style="font-size:13.5px;font-weight:600;color:#92400e;margin-bottom:6px;">Tiada Syarikat Dikaitkan</div>
                <div style="font-size:13px;color:#a16207;">Akaun anda belum dikaitkan dengan mana-mana syarikat. Sila hubungi pentadbir sistem.</div>
            </div>
        @endif

    </div>

    {{-- Edit forms --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;max-width:900px;margin-top:20px;">

        {{-- Edit Profile --}}
        <div class="card" x-data="{ open: {{ $errors->has('name') || $errors->has('phone') ? 'true' : 'false' }} }">
            <div class="card-head" style="cursor:pointer;" @click="open = !open">
                <span class="card-title">Kemaskini Profil</span>
                <svg :style="open ? 'transform:rotate(180deg);' : ''" style="transition:transform .2s;color:var(--text-4);flex-shrink:0;" width="14" height="14" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div x-show="open" x-cloak style="padding:20px;">
                <form method="POST" action="{{ route('industri.profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <div style="display:flex;flex-direction:column;gap:14px;">
                        <div>
                            <label style="display:block;font-size:12px;font-weight:600;color:var(--text);margin-bottom:6px;letter-spacing:0.2px;">
                                Nama Penuh <span style="color:#dc2626;">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   style="width:100%;border:1px solid {{ $errors->has('name') ? '#fca5a5' : 'var(--border)' }};border-radius:6px;padding:9px 12px;font-family:var(--font);font-size:13.5px;color:var(--text);background:#fff;outline:none;transition:border-color .15s,box-shadow .15s;"
                                   onfocus="this.style.borderColor='var(--brand)';this.style.boxShadow='0 0 0 3px rgba(0,104,55,.12)'"
                                   onblur="this.style.borderColor='{{ $errors->has('name') ? '#fca5a5' : 'var(--border)' }}';this.style.boxShadow='none'">
                            @error('name')
                                <div style="font-size:12px;color:#dc2626;margin-top:4px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label style="display:block;font-size:12px;font-weight:600;color:var(--text);margin-bottom:6px;letter-spacing:0.2px;">No. Telefon</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   placeholder="cth: 0123456789"
                                   style="width:100%;border:1px solid var(--border);border-radius:6px;padding:9px 12px;font-family:var(--font);font-size:13.5px;color:var(--text);background:#fff;outline:none;transition:border-color .15s,box-shadow .15s;"
                                   onfocus="this.style.borderColor='var(--brand)';this.style.boxShadow='0 0 0 3px rgba(0,104,55,.12)'"
                                   onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                        </div>
                        <button type="submit"
                                style="padding:9px 20px;background:var(--brand);color:#fff;border:none;border-radius:4px;font-family:var(--font);font-size:13px;font-weight:500;cursor:pointer;transition:background 150ms ease;align-self:flex-start;"
                                onmouseover="this.style.background='var(--brand-dark)'"
                                onmouseout="this.style.background='var(--brand)'">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Change Password --}}
        <div class="card" x-data="{ open: {{ $errors->has('current_password') || $errors->has('password') ? 'true' : 'false' }} }">
            <div class="card-head" style="cursor:pointer;" @click="open = !open">
                <span class="card-title">Tukar Kata Laluan</span>
                <svg :style="open ? 'transform:rotate(180deg);' : ''" style="transition:transform .2s;color:var(--text-4);flex-shrink:0;" width="14" height="14" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div x-show="open" x-cloak style="padding:20px;">
                <form method="POST" action="{{ route('industri.profile.password') }}">
                    @csrf
                    @method('PATCH')
                    <div style="display:flex;flex-direction:column;gap:14px;">
                        <div>
                            <label style="display:block;font-size:12px;font-weight:600;color:var(--text);margin-bottom:6px;letter-spacing:0.2px;">
                                Kata Laluan Semasa <span style="color:#dc2626;">*</span>
                            </label>
                            <input type="password" name="current_password"
                                   style="width:100%;border:1px solid {{ $errors->has('current_password') ? '#fca5a5' : 'var(--border)' }};border-radius:6px;padding:9px 12px;font-family:var(--font);font-size:13.5px;color:var(--text);background:#fff;outline:none;transition:border-color .15s,box-shadow .15s;"
                                   onfocus="this.style.borderColor='var(--brand)';this.style.boxShadow='0 0 0 3px rgba(0,104,55,.12)'"
                                   onblur="this.style.borderColor='{{ $errors->has('current_password') ? '#fca5a5' : 'var(--border)' }}';this.style.boxShadow='none'">
                            @error('current_password')
                                <div style="font-size:12px;color:#dc2626;margin-top:4px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label style="display:block;font-size:12px;font-weight:600;color:var(--text);margin-bottom:6px;letter-spacing:0.2px;">
                                Kata Laluan Baharu <span style="color:#dc2626;">*</span>
                            </label>
                            <input type="password" name="password"
                                   style="width:100%;border:1px solid {{ $errors->has('password') ? '#fca5a5' : 'var(--border)' }};border-radius:6px;padding:9px 12px;font-family:var(--font);font-size:13.5px;color:var(--text);background:#fff;outline:none;transition:border-color .15s,box-shadow .15s;"
                                   onfocus="this.style.borderColor='var(--brand)';this.style.boxShadow='0 0 0 3px rgba(0,104,55,.12)'"
                                   onblur="this.style.borderColor='{{ $errors->has('password') ? '#fca5a5' : 'var(--border)' }}';this.style.boxShadow='none'">
                            @error('password')
                                <div style="font-size:12px;color:#dc2626;margin-top:4px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label style="display:block;font-size:12px;font-weight:600;color:var(--text);margin-bottom:6px;letter-spacing:0.2px;">
                                Sahkan Kata Laluan Baharu <span style="color:#dc2626;">*</span>
                            </label>
                            <input type="password" name="password_confirmation"
                                   style="width:100%;border:1px solid var(--border);border-radius:6px;padding:9px 12px;font-family:var(--font);font-size:13.5px;color:var(--text);background:#fff;outline:none;transition:border-color .15s,box-shadow .15s;"
                                   onfocus="this.style.borderColor='var(--brand)';this.style.boxShadow='0 0 0 3px rgba(0,104,55,.12)'"
                                   onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                        </div>
                        <button type="submit"
                                style="padding:9px 20px;background:var(--brand);color:#fff;border:none;border-radius:4px;font-family:var(--font);font-size:13px;font-weight:500;cursor:pointer;transition:background 150ms ease;align-self:flex-start;"
                                onmouseover="this.style.background='var(--brand-dark)'"
                                onmouseout="this.style.background='var(--brand)'">
                            Tukar Kata Laluan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</x-layouts.industri>
