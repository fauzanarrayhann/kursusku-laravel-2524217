<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kursusku.test'],
            [
                'name'        => 'Administrator KursusKu',
                'username'    => 'admin',
                'password'    => 'Admin#1234', // di-hash otomatis oleh cast "hashed"
                'role'        => 'admin',
                'position'    => 'Administrator Sistem',
                'institution' => 'KursusKu',
                'is_active'   => true,
            ]
        );
    }
}
