<?php

namespace App\Http\Controllers\Backend\RolePermission;

use App\Models\User;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RolePermissionController extends Controller
{
    //CREATE USER 
    public function createUser()
    {
        return view('backend.rolePermission.createUser');
    }

    // STORE USER 
    public function storeUser(Request $request)
    {
        $request->validate([
            'user_name' => 'required',
            'user_email' => 'required|unique:table,column,except,id',
            'user_password' => 'required',
        ]);

        if ($request->user_password != $request->confirm_password) {
            return back()->with('pass_err', 'confirm password not match!');
        }

        $userInfo = new User();

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $uniName = 'profile-' . time() . '-' . $image->getClientOriginalName();
            $image->storeAs('profile_images/', $uniName, 'public');
            $userInfo->profile_image = $uniName;
        }

        $userInfo->name = $request->user_name;
        $userInfo->email = $request->user_email;
        $userInfo->password = Hash::make($request->user_password);
        $userInfo->save();
        Swal::toast([
            'title' => 'new user created successfully!',
        ]);
        return back();
    }


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
