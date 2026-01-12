<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles if they don't exist
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create admin user if not exists
        $user = User::firstOrCreate(
            ['email' => 'admin@hashalpha.io'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('StrongPassword123!'),
            ]
        );

        // Assign role
        $user->assignRole($superAdminRole);
    }
}
