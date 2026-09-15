<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            CategoryWordSeeder::class,
        ]);

        $adminRole = Role::where('slug', 'admin')->firstOrFail();
        $penggunaRole = Role::where('slug', 'pengguna')->firstOrFail();

        User::updateOrCreate(
            ['email' => 'alwas.muis@umkendari.ac.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_id' => $adminRole->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'pengguna@example.com'],
            [
                'name' => 'Pengguna Demo',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_id' => $penggunaRole->id,
            ]
        );
    }
}
