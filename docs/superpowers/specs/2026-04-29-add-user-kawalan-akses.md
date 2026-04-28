# Spec: Add User Modal + Kawalan Akses Page

**Date:** 2026-04-29
**Scope:** Admin module — Pengguna & ACL and Kawalan Akses tabs
**Approach:** Standard form POST, plain Blade — no Alpine.js or Livewire

---

## 1. Add User Modal

### Goal
Allow Super Admin users to create new system accounts from the Pengguna & ACL page without leaving the page.

### UI Changes — `officer/users/index.blade.php`

- Add a "Tambah Pengguna" button to the `card-head` row (right side, next to the user count)
- Add a modal overlay `<div>` hidden by default (`display:none`)
- Modal contains a `<form method="POST" action="{{ route('officer.users.store') }}">` with:
  - Nama (text, required)
  - E-mel (email, required, unique in users table)
  - Kata Laluan (password, required, min:8)
  - Peranan (select, populated from `\Spatie\Permission\Models\Role::all()`, required)
- Modal toggle: inline `<script>` using `onclick` to set `style.display` on the overlay
- Close button (×) inside modal header, plus clicking the backdrop closes it
- Display validation errors inline if redirect back with `$errors`
- Display flash message `"Pengguna berjaya ditambah"` in the `card-head` area on success

### Backend Changes

**Route** (in `routes/web.php`, inside the officer auth group):
```
POST /pengguna  →  Officer\UserController@store   name: officer.users.store
```

**`UserController@store`**:
1. Validate: `name` required, `email` required|email|unique:users, `password` required|min:8, `role` required|exists in Spatie roles table
2. Create user: `User::create(['name', 'email', 'password' => bcrypt(...)])`
3. Assign role: `$user->assignRole($request->role)`
4. Redirect back with flash: `redirect()->route('officer.users.index')->with('success', 'Pengguna berjaya ditambah')`

---

## 2. Kawalan Akses Page

### Goal
Allow Super Admin users to view all system roles and toggle which permissions each role has. Changes take effect immediately on save.

### Navigation Change — `components/layouts/officer.blade.php`

Replace the disabled `<span>` for "Kawalan Akses" with a real `<a>` link:
```
<a href="{{ route('officer.access.index') }}" class="mod-tab {{ request()->routeIs('officer.access.*') ? 'active' : '' }}">Kawalan Akses</a>
```

### New View — `officer/access/index.blade.php`

**Layout**: Two-column within `<x-layouts.officer>`:

- **Left column** (~220px): vertical list of all Spatie roles as clickable links (`?role={role->id}`). Active role highlighted with navy background pill.
- **Right column**: permission editor for the selected role.
  - Page heading shows selected role name
  - Permissions grouped by prefix (e.g. `applications`, `inspections`, `users`, `companies`, `products`) as labelled sections
  - Each permission shown as a checkbox (checked if role currently has it)
  - Single `<form method="POST" action="{{ route('officer.access.update', $selectedRole) }}">` wrapping all checkboxes
  - `@csrf` + `@method('PUT')`
  - "Simpan Perubahan" button at bottom
  - Flash success/error message displayed above the form

- **Default state** (no `?role` param): select the first role automatically (redirect)

### Backend

**Routes** (inside officer auth group):
```
GET  /kawalan-akses              →  Officer\AccessControlController@index   name: officer.access.index
PUT  /kawalan-akses/{role}       →  Officer\AccessControlController@update  name: officer.access.update
```

**New file:** `app/Http/Controllers/Officer/AccessControlController.php`

**`index()`**:
1. Load all roles: `Role::all()`
2. Load all permissions: `Permission::all()` grouped by prefix (split on `.`)
3. Determine selected role from `?role=` query param (role ID); default to first role; 404 if not found
4. Pass to view: `$roles`, `$selectedRole`, `$permissionGroups`

**`update(Role $role)`**:
1. Validate: `permissions` nullable|array, each item must exist in `permissions` table
2. Sync permissions: `$role->syncPermissions($request->permissions ?? [])`
3. Redirect back with flash: `"Kebenaran untuk {$role->name} berjaya dikemas kini"`

### Permission Grouping Logic

```php
$permissionGroups = Permission::all()
    ->groupBy(fn($p) => explode('.', $p->name)[0]);
```

Groups like: `applications`, `inspections`, `users`, `companies`, `products`, `reports`, etc.

---

## Files Touched

| File | Change |
|---|---|
| `resources/views/officer/users/index.blade.php` | Add modal + "Tambah Pengguna" button + flash message |
| `app/Http/Controllers/Officer/UserController.php` | Add `store()` method |
| `routes/web.php` | Add `POST /pengguna` and two `/kawalan-akses` routes |
| `resources/views/components/layouts/officer.blade.php` | Enable Kawalan Akses tab |
| `resources/views/officer/access/index.blade.php` | New view |
| `app/Http/Controllers/Officer/AccessControlController.php` | New controller |

---

## Out of Scope

- Email verification on user creation (not needed for prototype)
- Editing or deleting users
- Per-user permission overrides (only role-level permissions)
- Audit logging of permission changes
