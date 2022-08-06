<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'role' => User::$employee | User::$admin | User::$super_admin,
            'password' => bcrypt('admin@123'),
        ]);
    }
}
