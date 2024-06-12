<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        User::create([
            'uuid' => 'c4a8b0c0-5f7f-11ed-9b6a-0242ac120002',
            'name' => 'Mohamad Rizky Isa',
            'nim' => '21120119130046',
            'email' => 'kikiisa89@gmail.com',
            'phone' => '081234567890',
            'profile' => 'default',
            'password' => bcrypt('kikiisaipk4'),
        ]);
        for ($i = 1; $i <= 15; $i++) {
            User::create([
                'uuid' => Str::uuid(),
                'name' => $faker->name,
                'nim' => $faker->randomNumber(8),
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'profile' => 'default',
                'password' => bcrypt('kikiisaipk4'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
