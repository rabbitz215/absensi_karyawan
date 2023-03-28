<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
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

        for ($i = 0; $i < 100; $i++) {
            $karyawan = User::create([
                'name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->email(),
                'email_verified_at' => now(),
                'password' => Hash::make('ljtjdhgb21'),
                'jabatan' => $faker->randomElement(['SPV', 'HRD', 'IT', 'CFO']),
                'no_telp' => $faker->randomElement(['082233492283', '082233491124', '082233499182', '082233491263']),
                'department_id' => $faker->randomElement([1, 2, 3, 4, 5, 6]),
            ]);
            $karyawan->assignRole('karyawan');
        }
    }
}
