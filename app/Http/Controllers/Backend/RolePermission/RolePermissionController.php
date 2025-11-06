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
}
