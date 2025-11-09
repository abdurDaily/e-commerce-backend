<?php

namespace App\Http\Controllers\Backend\RolePermission;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RolePermissionController extends Controller
{
    //createRole
    public function createRole()
    {
        $roles = Role::latest()->simplePaginate(5);
        return view('backend.rolePermission.createRole', compact('roles'));
    }

    // store role
    public function storeRole(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|unique:roles,name',
        ]);

        Role::create(['name' => $request->role_name]);
        return response()->json(['message' => 'Role created successfully']);
    }
    // delete role
    public function deleteRole($id)
    {
        $role = Role::find($id)->delete();
        return response()->json([
            'message' => 'Role deleted successfully'
        ]);
    }

    //* EDIT ROLE 
    // Get role data for editing
    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        return response()->json([
            'success' => true,
            'role' => [
                'id' => $role->id,
                'name' => $role->name
            ]
        ]);
    }

    // Update the role
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role_name' => 'required|string|unique:roles,name,' . $id,
        ]);

        $role = Role::findOrFail($id);
        $role->update(['name' => $request->role_name]);

        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully'
        ]);
    }
}
