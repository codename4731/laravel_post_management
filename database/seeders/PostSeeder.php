<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $user = User::where("role", "admin")->first();
        if ($user) {
            foreach (range(1, 20) as $index) {
                $imagePath = $faker->image(storage_path('app/public/uploads/posts'), 400, 300, null, false);

                Post::create([
                    'title'     => $faker->sentence,
                    'content'   => $faker->paragraph,
                    'image'     => 'uploads/posts/' . basename($imagePath),
                    'user_id'   => $user->id
                ]);
            }
        }
    }
}
