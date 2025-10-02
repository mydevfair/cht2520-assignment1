<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_GB');

        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $sexes = ['Male', 'Female'];

        for ($i = 0; $i < 300; $i++) {
            $sex = $faker->randomElement($sexes);

            DB::table('patients')->insert([
                'name' => $faker->name($sex === 'Male' ? 'male' : 'female'),
                'age' => $faker->numberBetween(1, 90),
                'sex' => $sex,
                'blood_type' => $faker->randomElement($bloodTypes),
                'phone' => '07' . $faker->numerify('#########'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
