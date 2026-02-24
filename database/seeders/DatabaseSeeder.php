<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            PostsTableSeeder::class,
            LikesTableSeeder::class,
        ]);

        $userIds = User::pluck('id');
        Post::all()->each(function ($post) use ($userIds) {
            $otherUserId = User::where('id', '!=', $post->user_id)
                ->inRandomOrder()
                ->value('id');

            Comment::factory(rand(1, 2))->create([
                'post_id' => $post->id,
                'user_id' => $otherUserId,
            ]);
        });
    }
}
