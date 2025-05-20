<?php

namespace Database\Seeders;

use Laratrust\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Insert roles using Laratrust
        $roles = [
            ['name' => 'superadmin', 'display_name' => 'Super Administrator', 'description' => 'Full access'],
            ['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Limited access'],
            ['name' => 'user', 'display_name' => 'User', 'description' => 'Basic access']
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }

        // Insert users and assign roles
        $users = [
            ['name' => 'Super Admin', 'email' => 'superadmin@example.com', 'password' => Hash::make('password'), 'role' => 'superadmin'],
            ['name' => 'Admin', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'role' => 'admin'],
            ['name' => 'Ikhsan', 'email' => 'ikhsan@example.com', 'password' => Hash::make('password'), 'role' => 'user'],
            ['name' => 'Sofyan', 'email' => 'sofyan@example.com', 'password' => Hash::make('password'), 'role' => 'user'],
            ['name' => 'Haddad', 'email' => 'haddad@example.com', 'password' => Hash::make('password'), 'role' => 'user']
        ];

        foreach ($users as $userData) {
            // Update or insert user
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                ['name' => $userData['name'], 'password' => $userData['password']]
            );

            // Assign role
            $role = Role::where('name', $userData['role'])->first();
            if ($role) {
                $user->roles()->syncWithoutDetaching([$role->id]);
            }
        }
    }
}
