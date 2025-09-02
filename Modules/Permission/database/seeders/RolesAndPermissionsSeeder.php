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
         * Step 1: Define all permissions with Persian labels
         */
        $permissions = [
            // dashboards
            ['name' => 'view admin dashboard', 'label' => 'مشاهده داشبورد ادمین'],
            ['name' => 'view user dashboard', 'label' => 'مشاهده داشبورد کاربر'],

            // brand
            ['name' => 'create brand', 'label' => 'ایجاد برند'],
            ['name' => 'delete brand', 'label' => 'حذف برند'],
            ['name' => 'view brand', 'label' => 'مشاهده برند'],
            ['name' => 'edit brand', 'label' => 'ویرایش برند'],

            // category
            ['name' => 'create category', 'label' => 'ایجاد دسته‌بندی'],
            ['name' => 'edit category', 'label' => 'ویرایش دسته‌بندی'],
            ['name' => 'delete category', 'label' => 'حذف دسته‌بندی'],
            ['name' => 'view category', 'label' => 'مشاهده دسته‌بندی'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm['name']],
                ['label' => $perm['label']] // make sure your permissions table has a 'label' column
            );
        }

        /**
         * Step 2: Define roles with labels and assign permissions
         */
        $roles = [
            ['name' => 'super admin', 'label' => 'مدیر کل', 'permissions' => array_column($permissions, 'name')],
            ['name' => 'admin', 'label' => 'ادمین', 'permissions' => [
                'view admin dashboard',
                'view user dashboard',
                'create brand',
                'delete brand',
                'view brand',
                'edit brand',
                'create category',
                'edit category',
                'delete category',
                'view category',
            ]],
            ['name' => 'user', 'label' => 'کاربر', 'permissions' => ['view user dashboard']],
        ];

        foreach ($roles as $roleData) {
            $role = Role::firstOrCreate(
                ['name' => $roleData['name']],
                ['label' => $roleData['label']] // make sure your roles table has a 'label' column
            );
            $role->syncPermissions($roleData['permissions']);
        }

        /**
         * Step 3: Define users and assign roles
         */
        $users = [
            ['name' => 'Shahryar', 'email' => 'Shahryar.sky2014@gmail.com', 'password' => 'Programming1985', 'role' => 'super admin'],
            ['name' => 'Ali', 'email' => 'Ali@gmail.com', 'password' => 'Ali1234', 'role' => 'admin'],
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

            // Optional: sync with custom pivot table `user_roles`
            $role = Role::where('name', $data['role'])->first();
            if ($role) {
                DB::table('user_roles')->updateOrInsert(
                    ['user_id' => $user->id, 'role_id' => $role->id]
                );
            }
        }
    }
}
