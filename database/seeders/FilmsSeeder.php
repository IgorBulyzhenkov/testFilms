<?php

namespace Database\Seeders;

use App\Models\FilmGenre;
use App\Models\Films;
use App\Models\Genres;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $films = [
            [
                'name'              => 'Inception',
                'status_published'  => '1',
                'link_poster'       => '/img/default_poster_min.webp',
            ],
            [
                'name'              => 'The Dark Knight',
                'status_published'  => '1',
                'link_poster'       => '/img/default_poster_min.webp',
            ],
            [
                'name'              => 'Interstellar',
                'status_published'  => '1',
                'link_poster'       => '/img/default_poster_min.webp',
            ],
            [
                'name'              => 'Pulp Fiction',
                'status_published'  => '1',
                'link_poster'       => '/img/default_poster_min.webp',
            ],
            [
                'name'              => 'The Matrix',
                'status_published'  => '1',
                'link_poster'       => '/img/default_poster_min.webp',
            ],
            [
                'name'              => 'Fight Club',
                'status_published'  => '1',
                'link_poster'       => '/img/default_poster_min.webp',
            ],
            [
                'name' => 'Forrest Gump',
                'status_published' => '1',
                'link_poster' => '/img/default_poster_min.webp',
            ],
            [
                'name'              => 'The Shawshank Redemption',
                'status_published'  => '1',
                'link_poster'       => '/img/default_poster_min.webp',
            ],
            [
                'name'              => 'The Godfather',
                'status_published'  => '1',
                'link_poster'       => '/img/default_poster_min.webp',
            ],
            [
                'name'              => 'Gladiator',
                'status_published'  => '1',
                'link_poster'       => '/img/default_poster_min.webp',
            ],
        ];

        foreach ($films as $film) {
            $exist = Films::query()->where([
                'name' => $film['name']
            ])->exists();

            if (!$exist) {

                $res    = Films::query()->insertGetId([
                    'name'              => $film['name'],
                    'status_published'  => $film['status_published'],
                    'link_poster'       => $film['link_poster']
                ]);

                $genre  = Genres::query()
                    ->select('id')
                    ->inRandomOrder()
                    ->first();

                FilmGenre::query()->insert([
                        'fk_film'   => $res,
                        'fk_genre'  => $genre['id']
                    ]);
            }
        }
    }
}
