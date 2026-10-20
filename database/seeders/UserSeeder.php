<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator Kurikulum',
                'email' => 'admin@sekolah.sch.id',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Budi Santoso, S.Kom.',
                'email' => 'guru@sekolah.sch.id',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ],
            [
                'name' => 'Aditya Pratama',
                'email' => 'siswa@sekolah.sch.id',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}

