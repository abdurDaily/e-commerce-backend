<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles
        $roles = ['super admin', 'editor', 'user'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(
                ['name' => $roleName],  // role name
                ['guard_name' => 'web'] // specify guard
            );
        }

        // Define permissions
        $permissions = ['create', 'edit', 'delete', 'view'];

        foreach ($permissions as $permName) {
            Permission::firstOrCreate(
                ['name' => $permName],   // permission name
                ['guard_name' => 'web']  // specify guard
            );
        }

        // Give all permissions to super admin
        $adminRole = Role::where('name', 'super admin')->first();
        if ($adminRole) {
            $adminRole->syncPermissions(Permission::all());
        }

        // Assign multiple roles to the first user safely
        $user = User::first();
        if ($user) {
            // Use firstOrCreate for roles already ensures they exist
            $user->syncRoles(['super admin', 'editor', 'user']); // clears old roles and assigns new
        }
    }
}
