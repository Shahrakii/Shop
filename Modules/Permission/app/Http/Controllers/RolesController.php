<?php

namespace Modules\Permission\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Modules\Permission\Http\Requests\RoleRequest;

class RolesController extends Controller
{
    // List all roles
    public function index(Request $request)
    {
        $roles = Role::paginate(10);

        if ($request->wantsJson()) {
            return response()->json($roles);
        }

        return view('Permission::roles.index', compact('roles'));
    }

    // Show the create form
    public function create()
    {
        $permissions = Permission::all();
        return view('Permission::roles.create', compact('permissions'));
    }

    // Store a new role
    public function store(RoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'label' => $request->label,
            'guard_name' => 'admin',
        ]);

        if ($request->has('permissions')) {
            // Convert permission IDs to names
            $permissionNames = Permission::whereIn('id', $request->permissions)
                                        ->pluck('name')
                                        ->toArray();
            $role->syncPermissions($permissionNames);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'نقش با موفقیت ایجاد شد!');
    }

    // Show edit form
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('Permission::roles.edit', compact('role', 'permissions'));
    }

    // Update role
    public function update(Request $request, Role $role)
    {
        // Prevent editing Super Admin by anyone except himself
        if ($role->name === 'super admin' && !auth()->user()->hasRole('super admin')) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'شما اجازه ویرایش نقش سوپر ادمین را ندارید!');
        }

        $role->update($request->only('name', 'label'));

        if ($request->has('permissions')) {
            // Convert IDs to permission names
            $permissionNames = Permission::whereIn('id', $request->permissions)
                                        ->pluck('name')
                                        ->toArray();
            $role->syncPermissions($permissionNames);
        }

        return redirect()->route('admin.roles.index')
                        ->with('success', 'نقش با موفقیت بروزرسانی شد!');
    }

    // Delete role
    public function destroy(Request $request, Role $role)
    {
        // Prevent deletion of protected roles
        $protectedRoles = ['super admin', 'admin'];
        if (in_array($role->name, $protectedRoles)) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'این نقش قابل حذف نیست!');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'نقش با موفقیت حذف شد!');
    }
}
