<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 20; $i++) {
            Book::create([
                'kategori_id' => 1,
                'uuid' => Str::uuid(),
                'id_buku' => 'B' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'judul' => $faker->sentence,
                'slug' => Str::slug($faker->sentence),
                'pengarang' => $faker->name,
                'tahun_terbit' => $faker->year,
                'deskripsi' => $faker->paragraph,
                'cover' => "",
                'stock' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
