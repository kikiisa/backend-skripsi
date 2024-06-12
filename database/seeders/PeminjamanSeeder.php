<?php

namespace Database\Seeders;

use App\Models\Peminjaman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Assume you have 50 users and 50 books already in the database
        $userCount = 16;
        $bookCount = 20;
    
        for ($i = 1; $i <= 16; $i++) {
            $userId = $faker->numberBetween(1, $userCount);
            $bookId = $faker->numberBetween(1, $bookCount);

            $dates = $this->generateUniqueDates($i, 4);

            foreach ($dates as $date) {
                Peminjaman::create([
                    'uuid' => $faker->uuid,
                    'user_id' => $userId,
                    'buku_id' => $bookId,
                    'pinjam' => $date,
                    'kembali' => $faker->dateTimeBetween($date, '+7 days')->format('Y-m-d'),
                    'status' => 'pinjam',
                    'ket' => $faker->sentence,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }   
    }
    private function generateUniqueDates($index, $count)
    {
        $dates = [];
        $currentDate = now()->startOfYear()->addDays($index - 1);
        for ($i = 1; $i <= $count; $i++) {
            $dates[] = $currentDate->addDays($i)->format('Y-m-d');
        }
        return $dates;
    }
}
