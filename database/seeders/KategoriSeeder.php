<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kategori::create([
            'uuid' => Uuid::uuid4()->toString(),
            'judul' => 'Teknologi',
            'slug' => 'teknologi',
            'gambar' => 'https://cdn-icons-png.flaticon.com/128/3875/3875172.png',
        ]);
    }
}
