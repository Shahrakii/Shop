<?php

namespace Modules\Permission\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use spatie\Permission\Models\Role;

class RolesController extends Controller
{
    // List all roles
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    // Create a new role
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        $role = Role::create(['name' => $request->name]);
        return response()->json($role, 201);
    }

    // Show a role
    public function show($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role);
    }

    // Update a role
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id
        ]);
        $role->update(['name' => $request->name]);
        return response()->json($role);
    }

    // Delete a role
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(null, 204);
    }
}
