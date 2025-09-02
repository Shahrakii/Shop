<?php

namespace Modules\Permission\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        /**
         * Step 1: Define all permissions
         */
        $permissions = [
            // dashboards
            'view admin dashboard',
            'view user dashboard',

            // brand
            'create brand',
            'delete brand',
            'view brand',
            'edit brand',

            // category
            'create category',
            'edit category',
            'delete category',
            'view category',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        /**
         * Step 2: Define roles and their permissions
         */
        $roles = [
            'super admin' => $permissions, // gets all permissions
            'admin' => [
                'view admin dashboard',
                'view user dashboard',

                // brand
                'create brand',
                'delete brand',
                'view brand',
                'edit brand',

                // category
                'create category',
                'edit category',
                'delete category',
                'view category',
            ],
            'user' => [
                'view user dashboard',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        /**
         * Step 3: Define users and assign roles
         */
        $users = [
            [
                'name' => 'Shahryar',
                'email' => 'Shahryar.sky2014@gmail.com',
                'password' => 'Programming1985',
                'role' => 'super admin',
            ],
            [
                'name' => 'Ali',
                'email' => 'Ali@gmail.com',
                'password' => 'Ali1234',
                'role' => 'admin',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                ]
            );

            // Assign role
            $user->assignRole($data['role']);

            // Optional: sync with custom pivot `user_roles`
            $role = Role::where('name', $data['role'])->first();
            if ($role) {
                DB::table('user_roles')->updateOrInsert(
                    ['user_id' => $user->id, 'role_id' => $role->id]
                );
            }
        }
    }
}
