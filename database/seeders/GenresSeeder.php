<?php

namespace Database\Seeders;

use App\Models\Genres;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            ['name' => 'Action'],
            ['name' => 'Comedy'],
            ['name' => 'Drama'],
            ['name' => 'Horror'],
            ['name' => 'Thriller'],
            ['name' => 'Romance'],
            ['name' => 'Fantasy'],
            ['name' => 'Science Fiction'],
            ['name' => 'Adventure'],
            ['name' => 'Mystery'],
        ];

        foreach ($genres as $genre) {

            $exists = Genres::query()
                ->where('name', $genre['name'])
                ->exists();

            if (!$exists) {
                Genres::query()
                    ->create([
                        'name' => $genre['name']
                    ]);
            }
        }
    }
}
