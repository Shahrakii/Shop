<?php

namespace Modules\Permission\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Define roles
        $roles = ['super admin', 'admin', 'user'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Define users with their roles
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
            // Create or get the user
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                ]
            );

            // Assign Spatie role
            $user->assignRole($data['role']);

            // Optional: populate your custom user_roles table
            $role = Role::where('name', $data['role'])->first();
            if ($role) {
                DB::table('user_roles')->updateOrInsert(
                    ['user_id' => $user->id, 'role_id' => $role->id]
                );
            }
        }
    }
}
