<?php

namespace Database\Seeders;

use App\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        $departmentNames = ['Kesehatan', 'Pelayanan Pelanggan', 'Keuangan', 'Marketing dan Promosi', 'Pengembangan Karyawan', 'Administrasi'];

        foreach ($departmentNames as $departmentName) {
            Department::create([
                'name' => $departmentName,
                'manager_name' => $faker->name(),
                'no_telp' => $faker->phoneNumber(),
                'email' => $faker->email(),
                'description' => $faker->word(),
            ]);
        }
    }
}
