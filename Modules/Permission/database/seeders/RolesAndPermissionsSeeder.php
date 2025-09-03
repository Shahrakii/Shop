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
        // 1️⃣ Roles
        $roles = ['super admin', 'admin', 'moderator'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'admin']);
        }

        // 2️⃣ Permissions
        $permissions = [
            'view admin dashboard',
            'manage users',
            'manage products',
            'manage orders',
            'manage settings'
        ];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'admin']);
        }

        // 3️⃣ Assign permissions to roles
        Role::findByName('super admin', 'admin')->syncPermissions(Permission::all());
        Role::findByName('admin', 'admin')->syncPermissions([
            'view admin dashboard', 'manage users', 'manage products', 'manage orders'
        ]);
        Role::findByName('moderator', 'admin')->syncPermissions([
            'view admin dashboard', 'manage orders'
        ]);

        // 4️⃣ Seed Admins
        $admins = [
            [
                'name' => 'Ali',
                'email' => 'ali@example.com',
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

        // 5️⃣ Seed Customers (no permissions)
        $customers = [
            [
                'name' => 'Reza',
                'email' => 'reza@gmail.com',
                'phone_number' => '+989123456780',
                'password' => Hash::make('Reza12345'),
                'status' => 0
            ],
            [
                'name' => 'Sara',
                'email' => 'sara@gmail.com',
                'phone_number' => '+989123456781',
                'password' => Hash::make('Sara12345'),
                'status' => 0
            ]
        ];

        foreach ($customers as $data) {
            Customer::firstOrCreate(
                ['email' => $data['email']],
                $data
            );
        }

        $this->command->info('Roles, permissions, admins, and customers seeded successfully!');
    }
}
