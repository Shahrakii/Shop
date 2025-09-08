<?php

namespace Modules\Permission\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Admin;
use App\Models\Customer;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Define roles with labels
        $roles = [
            ['name' => 'super admin', 'label' => 'سوپر ادمین', 'guard' => 'admin'],
            ['name' => 'admin', 'label' => 'ادمین', 'guard' => 'admin'],
        ];

        // Create roles
        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name'], 'guard_name' => $roleData['guard']],
                ['label' => $roleData['label']]
            );
        }

        // Define permissions with labels
        $permissions = [
            ['name' => 'view admin dashboard', 'label' => 'مشاهده داشبورد ادمین'],
            ['name' => 'view roles section', 'label' => 'مشاهده بخش نقش ها'],
            ['name' => 'make role', 'label' => 'ایجاد نقش'],
            ['name' => 'edit role', 'label' => 'ویرایش نقش'],
            ['name' => 'delete role', 'label' => 'حذف نقش'],
        ];

        // Create permissions
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm['name'], 'guard_name' => 'admin'],
                ['label' => $perm['label']]
            );
        }

        // Assign permissions to roles
        Role::findByName('super admin', 'admin')->syncPermissions(Permission::all());
        Role::findByName('admin', 'admin')->syncPermissions([
            'view admin dashboard',
        ]);

        // Seed Admins
        $admins = [
            [
                'name' => 'Ali',
                'email' => 'ali@gmail.com',
                'phone_number' => '+989123456789',
                'password' => Hash::make('Ali12345'),
                'role' => 'admin',
            ],
            [
                'name' => 'Shahryar',
                'email' => 'Shahryar.sky2014@gmail.com',
                'phone_number' => '+989113166055',
                'password' => Hash::make('Programming1985'),
                'role' => 'super admin',
            ],
        ];

        foreach ($admins as $data) {
            $admin = Admin::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'phone_number' => $data['phone_number'],
                    'password' => $data['password'],
                    'status' => 1
                ]
            );
            $admin->assignRole($data['role']);
        }

        $this->command->info('Roles, permissions, admins, and customers seeded successfully!');
    }
}
