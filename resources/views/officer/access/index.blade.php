<x-layouts.officer title="Kawalan Akses">

    <div class="pg-head">
        <div>
            <div class="pg-title">Kawalan Akses</div>
            <div class="pg-sub">Urus kebenaran bagi setiap peranan dalam sistem myLRMP</div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:220px 1fr;gap:20px;align-items:start;">

        {{-- Left: Role list --}}
        <div class="card" style="padding:8px;">
            @foreach($roles as $role)
                <a href="{{ route('officer.access.index', ['role' => $role->id]) }}"
                   style="display:flex;align-items:center;justify-content:space-between;padding:9px 12px;border-radius:6px;text-decoration:none;font-size:13px;font-weight:{{ $selectedRole?->id === $role->id ? '600' : '400' }};color:{{ $selectedRole?->id === $role->id ? '#fff' : 'var(--text)' }};background:{{ $selectedRole?->id === $role->id ? 'var(--navy)' : 'transparent' }};transition:background 150ms ease;"
                   @if($selectedRole?->id !== $role->id) onmouseover="this.style.background='var(--bg)'" onmouseout="this.style.background='transparent'" @endif>
                    <span>{{ $role->name }}</span>
                    <span style="font-size:11px;font-weight:500;padding:1px 6px;border-radius:9999px;background:{{ $selectedRole?->id === $role->id ? 'rgba(255,255,255,0.2)' : 'var(--bg)' }};color:{{ $selectedRole?->id === $role->id ? '#fff' : 'var(--text-3)' }};">
                        {{ $role->permissions->count() }}
                    </span>
                </a>
            @endforeach
        </div>

        {{-- Right: Permission editor --}}
        @if($selectedRole)
            <div class="card">
                <div class="card-head">
                    <span class="card-title">{{ $selectedRole->name }}</span>
                    <span class="card-meta">{{ $selectedRole->permissions->count() }} kebenaran aktif</span>
                </div>

                @if(session('success'))
                    <div style="margin:16px 20px 0;padding:10px 14px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px;font-size:13px;color:#15803d;display:flex;align-items:center;gap:8px;">
                        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('officer.access.update', $selectedRole) }}" style="padding:20px;">
                    @csrf
                    @method('PUT')

                    @foreach($permissionGroups as $group => $permissions)
                        <div style="margin-bottom:24px;">
                            <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--text-3);margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid var(--border);">
                                {{ $group }}
                            </div>
                            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:8px;">
                                @foreach($permissions as $permission)
                                    <label style="display:flex;align-items:center;gap:9px;padding:8px 10px;border-radius:6px;border:1px solid var(--border);cursor:pointer;transition:border-color 150ms ease;font-size:13px;color:var(--text);"
                                           onmouseover="this.style.borderColor='var(--navy)'" onmouseout="this.style.borderColor='var(--border)'">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                               {{ $selectedRole->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                               style="width:14px;height:14px;accent-color:var(--navy);cursor:pointer;">
                                        <span>{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    @error('permissions')
                        <p style="font-size:12px;color:var(--red);margin-bottom:12px;">{{ $message }}</p>
                    @enderror
                    @error('permissions.*')
                        <p style="font-size:12px;color:var(--red);margin-bottom:12px;">{{ $message }}</p>
                    @enderror

                    <div style="display:flex;justify-content:flex-end;padding-top:16px;border-top:1px solid var(--border);">
                        <button type="submit" class="btn-navy">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        @endif
    </div>

</x-layouts.officer>
