<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@test.com'],
            $this->adminAccount
        );
    }

    private $adminAccount = [
        'first_name' => 'Dev',
        'last_name' => 'Admin',
        'is_admin' => true,
        'email' => 'admin@test.com',
        'password' => 123456,
    ];
}
