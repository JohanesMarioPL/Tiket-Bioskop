<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $movies = Movie::all();

        $comments = [
            'Filmnya sangat bagus dan menarik.',
            'Visualnya keren banget.',
            'Alur cerita cukup seru.',
            'Recommended untuk ditonton bersama teman.',
            'Akting para pemain sangat bagus.',
            'Ceritanya menyentuh dan emosional.',
            'Soundtrack filmnya luar biasa.',
            'Lumayan menghibur untuk akhir pekan.',
            'Plot twist-nya tidak terduga.',
            'Salah satu film terbaik yang pernah saya tonton.',
            'Menurut saya masih bisa lebih baik.',
            'Filmnya cukup menarik walaupun agak lambat di awal.',
        ];

        foreach ($movies as $movie) {
            $reviewers = $users->random(
                min(rand(3, 6), $users->count())
            );

            foreach ($reviewers as $user) {
                Review::create([
                    'user_id' => $user->id,
                    'movie_id' => $movie->id,
                    'rating' => rand(3, 5),
                    'comment' => collect($comments)->random(),
                ]);
            }
        }
    }
}