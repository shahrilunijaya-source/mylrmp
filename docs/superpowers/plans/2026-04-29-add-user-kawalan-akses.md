# Add User Modal + Kawalan Akses Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add a "Tambah Pengguna" modal to the users list page and implement the "Kawalan Akses" role-permission management page in the Admin module.

**Architecture:** Standard Laravel form POST with Blade views — no Livewire or Alpine.js. The Add User modal is toggled with a minimal inline `<script>` using `.open` class toggling (same pattern as `officer/login.blade.php`). The Kawalan Akses page uses a query param (`?role={id}`) to select the active role and a `PUT` form to sync permissions.

**Tech Stack:** Laravel 11, Blade, Spatie `laravel-permission` v7, `DatabaseTransactions` in tests, PHPUnit.

---

## File Map

| File | Action |
|---|---|
| `routes/web.php` | Add 3 new routes |
| `app/Http/Controllers/Officer/UserController.php` | Add `store()` method |
| `resources/views/officer/users/index.blade.php` | Add button + modal + flash message |
| `app/Http/Controllers/Officer/AccessControlController.php` | New controller |
| `resources/views/officer/access/index.blade.php` | New view |
| `resources/views/components/layouts/officer.blade.php` | Enable Kawalan Akses tab |
| `tests/Feature/AddUserTest.php` | New test file |
| `tests/Feature/KawalanAksesTest.php` | New test file |

---

## Task 1: Add Routes

**Files:**
- Modify: `routes/web.php` (around line 105, inside the `officer.` route group)

- [ ] **Step 1: Add the three new routes**

Open `routes/web.php`. After line 105 (`Route::get('/pengguna', ...)`), add:

```php
Route::post('/pengguna', [OfficerUserController::class, 'store'])->name('users.store');
Route::get('/kawalan-akses', [OfficerAccessController::class, 'index'])->name('access.index');
Route::put('/kawalan-akses/{role}', [OfficerAccessController::class, 'update'])->name('access.update');
```

- [ ] **Step 2: Add the import for AccessControlController**

At the top of `routes/web.php`, after the existing `OfficerUserController` import line, add:

```php
use App\Http\Controllers\Officer\AccessControlController as OfficerAccessController;
```

- [ ] **Step 3: Verify routes are registered**

```bash
cd /path/to/mylrmp && php artisan route:list --name=officer.users.store
php artisan route:list --name=officer.access.index
php artisan route:list --name=officer.access.update
```

Expected: Three rows showing the routes. No errors.

- [ ] **Step 4: Commit**

```bash
git add routes/web.php
git commit -m "feat: register add-user store and kawalan-akses routes"
```

---

## Task 2: Write Tests for Add User (failing first)

**Files:**
- Create: `tests/Feature/AddUserTest.php`

- [ ] **Step 1: Create the test file**

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AddUserTest extends TestCase
{
    use DatabaseTransactions;

    private function superAdmin(): User
    {
        return User::role('Super Admin')->firstOrFail();
    }

    public function test_super_admin_can_see_tambah_pengguna_button(): void
    {
        $response = $this->actingAs($this->superAdmin())
            ->get(route('officer.users.index'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Pengguna');
    }

    public function test_super_admin_can_create_user(): void
    {
        $response = $this->actingAs($this->superAdmin())
            ->post(route('officer.users.store'), [
                'name'     => 'Ujian Pengguna',
                'email'    => 'ujian.baru@doa.gov.my',
                'password' => 'password123',
                'role'     => 'Pendaftar',
            ]);

        $response->assertRedirect(route('officer.users.index'));
        $response->assertSessionHas('success', 'Pengguna berjaya ditambah');
        $this->assertDatabaseHas('users', ['email' => 'ujian.baru@doa.gov.my']);
    }

    public function test_duplicate_email_fails_validation(): void
    {
        $existing = User::first();

        $response = $this->actingAs($this->superAdmin())
            ->post(route('officer.users.store'), [
                'name'     => 'Duplikat',
                'email'    => $existing->email,
                'password' => 'password123',
                'role'     => 'Pendaftar',
            ]);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('users', User::count());
    }

    public function test_short_password_fails_validation(): void
    {
        $response = $this->actingAs($this->superAdmin())
            ->post(route('officer.users.store'), [
                'name'     => 'Pengguna Baharu',
                'email'    => 'baharu@doa.gov.my',
                'password' => 'short',
                'role'     => 'Pendaftar',
            ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_invalid_role_fails_validation(): void
    {
        $response = $this->actingAs($this->superAdmin())
            ->post(route('officer.users.store'), [
                'name'     => 'Pengguna Baharu',
                'email'    => 'baharu2@doa.gov.my',
                'password' => 'password123',
                'role'     => 'RoleYangTidakWujud',
            ]);

        $response->assertSessionHasErrors('role');
    }
}
```

- [ ] **Step 2: Run tests to confirm they fail**

```bash
php artisan test tests/Feature/AddUserTest.php
```

Expected: All tests FAIL with errors like "Route [officer.users.store] not defined" or 404/500. This confirms the tests are wired correctly before implementation.

---

## Task 3: Implement `UserController@store`

**Files:**
- Modify: `app/Http/Controllers/Officer/UserController.php`

- [ ] **Step 1: Add imports and the `store` method**

Replace the entire file with:

```php
<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'company'])->paginate(20);

        return view('officer.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validRoleNames = Role::pluck('name')->toArray();

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role'     => ['required', 'string', 'in:' . implode(',', $validRoleNames)],
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => $validated['password'],
            'is_active' => true,
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('officer.users.index')
            ->with('success', 'Pengguna berjaya ditambah');
    }
}
```

- [ ] **Step 2: Run the add-user tests**

```bash
php artisan test tests/Feature/AddUserTest.php
```

Expected: All 5 tests PASS.

- [ ] **Step 3: Commit**

```bash
git add app/Http/Controllers/Officer/UserController.php tests/Feature/AddUserTest.php
git commit -m "feat: add UserController store method with validation"
```

---

## Task 4: Add Modal + Button to Users Index View

**Files:**
- Modify: `resources/views/officer/users/index.blade.php`

- [ ] **Step 1: Replace the entire file**

The modal uses the same CSS pattern as `officer/login.blade.php` (`.modal-backdrop` + `.open` class toggle). The modal auto-reopens on validation errors by checking `$errors->any()`.

```blade
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
```

- [ ] **Step 2: Run add-user tests again to confirm the view tests pass**

```bash
php artisan test tests/Feature/AddUserTest.php
```

Expected: All 5 tests PASS.

- [ ] **Step 3: Commit**

```bash
git add resources/views/officer/users/index.blade.php
git commit -m "feat: add Tambah Pengguna modal to users list"
```

---

## Task 5: Write Tests for Kawalan Akses (failing first)

**Files:**
- Create: `tests/Feature/KawalanAksesTest.php`

- [ ] **Step 1: Create the test file**

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class KawalanAksesTest extends TestCase
{
    use DatabaseTransactions;

    private function superAdmin(): User
    {
        return User::role('Super Admin')->firstOrFail();
    }

    public function test_kawalan_akses_page_loads_for_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin())
            ->get(route('officer.access.index'));

        $response->assertStatus(200);
        $response->assertSee('Kawalan Akses');
    }

    public function test_kawalan_akses_defaults_to_first_role(): void
    {
        $firstRole = Role::orderBy('id')->first();

        $response = $this->actingAs($this->superAdmin())
            ->get(route('officer.access.index'));

        // Should redirect to ?role={first_role_id}
        $response->assertRedirect(route('officer.access.index') . '?role=' . $firstRole->id);
    }

    public function test_kawalan_akses_shows_permissions_for_selected_role(): void
    {
        $role = Role::where('name', 'Pendaftar')->firstOrFail();

        $response = $this->actingAs($this->superAdmin())
            ->get(route('officer.access.index') . '?role=' . $role->id);

        $response->assertStatus(200);
        $response->assertSee('applications.view_any');
    }

    public function test_super_admin_can_update_role_permissions(): void
    {
        $role = Role::where('name', 'Penilai Label')->firstOrFail();

        $response = $this->actingAs($this->superAdmin())
            ->put(route('officer.access.update', $role), [
                'permissions' => ['applications.view_any', 'audit.view'],
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertTrue($role->fresh()->hasPermissionTo('applications.view_any'));
        $this->assertTrue($role->fresh()->hasPermissionTo('audit.view'));
        $this->assertFalse($role->fresh()->hasPermissionTo('applications.review_label'));
    }

    public function test_invalid_permission_fails_validation(): void
    {
        $role = Role::where('name', 'Pendaftar')->firstOrFail();

        $response = $this->actingAs($this->superAdmin())
            ->put(route('officer.access.update', $role), [
                'permissions' => ['permission.yang.tidak.wujud'],
            ]);

        $response->assertSessionHasErrors('permissions.0');
    }
}
```

- [ ] **Step 2: Run tests to confirm they fail**

```bash
php artisan test tests/Feature/KawalanAksesTest.php
```

Expected: Tests FAIL (route not defined / controller not found). Confirms wiring is correct.

---

## Task 6: Implement `AccessControlController`

**Files:**
- Create: `app/Http/Controllers/Officer/AccessControlController.php`

- [ ] **Step 1: Create the controller**

```php
<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AccessControlController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::orderBy('id')->get();

        if ($roles->isEmpty()) {
            return view('officer.access.index', [
                'roles'            => $roles,
                'selectedRole'     => null,
                'permissionGroups' => collect(),
            ]);
        }

        $roleId = $request->query('role');

        if (!$roleId) {
            return redirect()->route('officer.access.index', ['role' => $roles->first()->id]);
        }

        $selectedRole = Role::findById((int) $roleId);

        if (!$selectedRole) {
            abort(404);
        }

        $permissionGroups = Permission::orderBy('name')->get()
            ->groupBy(fn($p) => explode('.', $p->name)[0]);

        return view('officer.access.index', compact('roles', 'selectedRole', 'permissionGroups'));
    }

    public function update(Request $request, Role $role)
    {
        $validPermissionNames = Permission::pluck('name')->toArray();

        $validated = $request->validate([
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['string', 'in:' . implode(',', $validPermissionNames)],
        ]);

        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()
            ->route('officer.access.index', ['role' => $role->id])
            ->with('success', "Kebenaran untuk {$role->name} berjaya dikemas kini");
    }
}
```

- [ ] **Step 2: Run kawalan akses tests**

```bash
php artisan test tests/Feature/KawalanAksesTest.php
```

Expected: All 5 tests PASS (the view doesn't exist yet, so the page-loads tests may still fail — that's fine, continue to Task 7).

---

## Task 7: Create Kawalan Akses View

**Files:**
- Create: `resources/views/officer/access/index.blade.php`

- [ ] **Step 1: Create the directory and view file**

```bash
mkdir -p resources/views/officer/access
```

Then create `resources/views/officer/access/index.blade.php`:

```blade
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
```

- [ ] **Step 2: Run all kawalan akses tests**

```bash
php artisan test tests/Feature/KawalanAksesTest.php
```

Expected: All 5 tests PASS.

- [ ] **Step 3: Commit**

```bash
git add app/Http/Controllers/Officer/AccessControlController.php \
        resources/views/officer/access/index.blade.php \
        tests/Feature/KawalanAksesTest.php
git commit -m "feat: implement Kawalan Akses role-permission management page"
```

---

## Task 8: Enable Kawalan Akses Tab in Layout

**Files:**
- Modify: `resources/views/components/layouts/officer.blade.php` (line 565)

- [ ] **Step 1: Replace the disabled span with a live link**

Find the line (around line 565):
```blade
<span class="mod-tab disabled" tabindex="-1" data-tip="Belum tersedia dalam prototaip ini">Kawalan Akses</span>
```

Replace it with:
```blade
<a href="{{ route('officer.access.index') }}" class="mod-tab {{ request()->routeIs('officer.access.*') ? 'active' : '' }}">Kawalan Akses</a>
```

- [ ] **Step 2: Run the full test suite to check for regressions**

```bash
php artisan test
```

Expected: All tests PASS, including the existing `AclTest.php`, `ApplicationWorkflowTest.php`, and `PublicSearchTest.php`.

- [ ] **Step 3: Commit**

```bash
git add resources/views/components/layouts/officer.blade.php
git commit -m "feat: enable Kawalan Akses tab in Admin module navigation"
```

---

## Task 9: Smoke Test in Browser

- [ ] **Step 1: Start the dev server**

```bash
php artisan serve
```

- [ ] **Step 2: Log in as Super Admin and verify Add User**

1. Go to `http://localhost:8000/pegawai/pengguna`
2. Confirm "Tambah Pengguna" button is visible
3. Click it — modal should slide in
4. Submit with empty fields — modal should stay open with validation errors
5. Submit with valid data — should redirect back with green success message
6. New user should appear in the list

- [ ] **Step 3: Verify Kawalan Akses tab**

1. "Kawalan Akses" tab in the Admin module bar should now be a clickable link
2. Click it — should land on `/pegawai/kawalan-akses` with a redirect to `?role=1`
3. Left column shows all roles; active role is highlighted
4. Right column shows permission checkboxes grouped by prefix
5. Uncheck a permission, click "Simpan Perubahan" — green flash message appears
6. Reload the page — the unchecked permission should remain unchecked

- [ ] **Step 4: Final commit (if any tweaks were needed)**

```bash
git add -p
git commit -m "fix: smoke test tweaks for add-user modal and kawalan akses"
```
