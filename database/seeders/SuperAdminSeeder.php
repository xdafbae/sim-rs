<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $password = env('SUPERADMIN_PASSWORD');

        if (! is_string($password) || $password === '') {
            throw new RuntimeException('SUPERADMIN_PASSWORD must be configured before running this seeder.');
        }

        $user = User::query()
            ->where('email', 'superadmin@gmail.com')
            ->orWhere('email', 'superadmin@sim-rs.local')
            ->first() ?? new User();

        $user->fill([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'role' => 'superadmin',
            'password' => $password,
        ]);
        $user->email_verified_at = now();
        $user->save();
    }
}
