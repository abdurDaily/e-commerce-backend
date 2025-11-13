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
        // Create roles
        $roles = [
            ['name' => 'admin'],
            ['name' => 'editor'],
            ['name' => 'user'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        // Create permissions
        $permissions = [
            ['name' => 'create'],
            ['name' => 'edit'],
            ['name' => 'delete'],
            ['name' => 'view'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }


        // Give all permissions to admin
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->syncPermissions(Permission::all());


        // Assign admin role to the first user
        $user = User::first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
