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
