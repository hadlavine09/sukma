<?php

namespace Database\Seeders;

use Laratrust\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Roles
        $roles = [
            ['name' => 'superadmin', 'display_name' => 'Super Administrator', 'description' => 'Full access'],
            ['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Limited access'],
            ['name' => 'user', 'display_name' => 'User', 'description' => 'Basic access'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }

        // Users
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'username' => 'superadmin',
                'no_hp' => '0811111111',
                'no_ktp' => '1234567890123456',
                'profile' => 'default.png',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'role' => 'superadmin',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'username' => 'admin',
                'no_hp' => '0812222222',
                'no_ktp' => '2345678901234567',
                'profile' => 'default.png',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'role' => 'admin',
            ],
            [
                'name' => 'Ikhsan',
                'email' => 'ikhsan@example.com',
                'username' => 'ikhsan',
                'no_hp' => '0813333333',
                'no_ktp' => '3456789012345678',
                'profile' => 'default.png',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'role' => 'user',
            ],
            [
                'name' => 'Sofyan',
                'email' => 'sofyan@example.com',
                'username' => 'sofyan',
                'no_hp' => '0814444444',
                'no_ktp' => '4567890123456789',
                'profile' => 'default.png',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'role' => 'user',
            ],
            [
                'name' => 'Haddad',
                'email' => 'haddad@example.com',
                'username' => 'haddad',
                'no_hp' => '0815555555',
                'no_ktp' => '5678901234567890',
                'profile' => 'default.png',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'role' => 'user',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'username' => $userData['username'],
                    'no_hp' => $userData['no_hp'],
                    'no_ktp' => $userData['no_ktp'],
                    'profile' => $userData['profile'],
                    'email_verified_at' => $userData['email_verified_at'],
                    'password' => $userData['password'],
                    'remember_token' => $userData['remember_token'],
                ]
            );

            $role = Role::where('name', $userData['role'])->first();
            if ($role) {
                $user->roles()->syncWithoutDetaching([$role->id]);
            }
        }
    }
}
