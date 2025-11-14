<?php

namespace App\Http\Controllers\Backend\RolePermission;

use App\Models\User;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    //CREATE USER 
    public function createUser()
    {
        return view('backend.rolePermission.createUser');
    }

    // LIST USER'S
    public function listUser()
    {
        $users = User::latest()->get();
        return view('backend.rolePermission.listUser', compact('users'));
    }

    // assignRole
    public function assignRole($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::get();
        return view('backend.rolePermission.assignRole', compact('roles', 'user'));
    }


    // assignRoleStore
    public function assignRoleStore(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->syncRoles($request->role);
        Swal::toast([
            'title' => 'Roles assigned successfully!',
        ]);
        return back()->with('success', 'Roles assigned successfully!');
    }

    // EDIT USER 
    public function editUser($id)
    {
        $editUser = User::find($id);
        return view('backend.rolePermission.editUser', compact('editUser'));
    }

    // STORE USER 
    public function storeUser(Request $request)
    {
        $request->validate([
            'user_name' => 'required',
            'user_email' => 'required|email|unique:users,email',
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

        return back()->with('success', 'New user created successfully!');
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

    //permission
    public function permission()
    {
        $permissions = Permission::get();
        $roles = Role::get();
        return view('.rolePermission.permission', compact('permissions', 'roles'));
    }

    //create permission
    public function createPermission(Request $request)
    {
        $request->validate([
            'role' => 'required|exists:roles,id',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($request->role);
        $permissions = Permission::whereIn('id', $request->permissions)->get();

        $role->syncPermissions($permissions);

        return back()->with('success', 'Permissions assigned to role successfully!');
    }

    public function createRole()
    {
        $roles = Role::paginate(10);
        $permissions = Permission::all();
        return view('backend.rolePermission.createRole', compact('roles', 'permissions'));
    }

    //* ASSIGN PERMISSION GET 
    public function assignPermission($roleId)
    {
        $permissions = Permission::all();
        $selectedRole = Role::findOrFail($roleId);
        $rolePermissions = $selectedRole->permissions->pluck('id')->toArray();
        return view('backend.rolePermission.assignPermission', compact('permissions', 'selectedRole', 'rolePermissions'));
    }

    //* STORE PERMISSION
    public function storePermission(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($request->role_id);

        // If no permissions selected, remove all permissions
        if (empty($request->permissions)) {
            $role->syncPermissions([]);
        } else {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        }

        return redirect()
            ->route('dashboard.role.permission.assign.permission', $request->role_id)
            ->with('success', 'Permissions assigned successfully!');
    }

    //* GET ROLE PERMISSIONS (for viewing)
    public function getRolePermissions($id)
    {
        $role = Role::findOrFail($id);
        $permissions = $role->permissions;

        return response()->json([
            'success' => true,
            'role' => $role->name,
            'permissions' => $permissions
        ]);
    }
}
