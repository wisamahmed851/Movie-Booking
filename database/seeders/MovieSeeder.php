<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use Illuminate\Support\Carbon;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $movies = [
            [
                'title' => 'Avengers Endgame',
                'description' => 'After the devastating events of Infinity War, the universe is in ruins...',
                'genre_ids' => [1, 2],
                'language_ids' => [1],
                'release_date' => '2019-04-26',
                'duration' => 182, // 3h 2m
            ],
            [
                'title' => 'Kgf Chapter 1',
                'description' => 'Rocky rises from poverty to become a legendary gangster in Bombay.',
                'genre_ids' => [2],
                'language_ids' => [2],
                'release_date' => '2018-12-21',
                'duration' => 155,
            ],
            [
                'title' => 'Shiddat',
                'description' => 'A romantic drama that explores the lengths one would go for love.',
                'genre_ids' => [1],
                'language_ids' => [1],
                'release_date' => '2021-10-01',
                'duration' => 146,
            ],
            [
                'title' => 'Inception',
                'description' => 'A thief who steals corporate secrets through dream-sharing technology.',
                'genre_ids' => [2],
                'language_ids' => [1],
                'release_date' => '2010-07-16',
                'duration' => 148,
            ],
            [
                'title' => 'Rampage',
                'description' => 'Primatologist Davis Okoye shares a bond with an intelligent gorilla...',
                'genre_ids' => [2],
                'language_ids' => [2],
                'release_date' => '2018-04-13',
                'duration' => 107,
            ],
            [
                'title' => 'Underground 6',
                'description' => 'Six individuals fake their deaths to form a vigilante squad.',
                'genre_ids' => [2],
                'language_ids' => [1],
                'release_date' => '2019-12-13',
                'duration' => 128,
            ],
            [
                'title' => 'Hello',
                'description' => 'A love story of childhood sweethearts reuniting as adults.',
                'genre_ids' => [1],
                'language_ids' => [2],
                'release_date' => '2017-12-22',
                'duration' => 131,
            ],
        ];

        foreach ($movies as $data) {
            Movie::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'genre_ids' => $data['genre_ids'],
                'language_ids' => $data['language_ids'],
                'cover_image_id' => 1,
                'banner_image_id' => 1,
                'slider_image_id' => 1,
                'status' => '1',
                'trailler' => 'https://www.youtube.com/watch?v=TcMBFSGVi1c',
                'isTrending' => true,
                'isExclusive' => false,
                'release_date' => Carbon::parse($data['release_date']),
                'duration' => $data['duration'],
            ]);
        }
    }
}
