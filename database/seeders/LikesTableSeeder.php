<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;


class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $likes = [
            [
                'user_uid' => config('test_users.user2_uid'),
                'post_content' => 'こんにちは!Test User1です。',
            ],
            [
                'user_uid' => config('test_users.user1_uid'),
                'post_content' => 'いいね機能のテスト投稿です。',
            ],
        ];

        foreach ($likes as $like) {
            $user = User::where('firebase_uid', $like['user_uid'])->firstOrFail();

            $post = Post::where('content', $like['post_content'])->firstOrFail();

            $post->likes()->firstOrCreate([
                'user_id' => $user->id,
            ]);
        }
    }
}
