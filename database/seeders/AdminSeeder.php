<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            ['email' => 'abdolahei@gmail.com', 'name' => 'Behrooz'],
            ['email' => 'salehrezaeipoor123@gmail.com', 'name' => 'Saleh'],
            ['email' => 'aminkhanzadehomran@gmail.com', 'name' => 'Amin'],
            ['email' => 'mehdimuhammadi3@gmail.com', 'name' => 'Agha Mehdi'],
        ];

        foreach ($admins as $admin) {
            Admin::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => Hash::make('112233'),
                ]
            );
        }
    }
}