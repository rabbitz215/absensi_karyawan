<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Galang',
            'last_name' => 'Putra',
            'email' => 'galangputra376@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('ljtjdhgb21'),
            'jabatan' => 'HRD',
            'no_telp' => '082233492280',
            'department_id' => 1,
        ]);

        $user->assignRole('admin');

        $karyawan = User::create([
            'name' => 'Galang',
            'last_name' => 'Ananda',
            'email' => 'galangananda@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('ljtjdhgb21'),
            'jabatan' => 'SPV',
            'no_telp' => '082233492281',
            'department_id' => 2,
        ]);

        $karyawan->assignRole('karyawan');
    }
}
