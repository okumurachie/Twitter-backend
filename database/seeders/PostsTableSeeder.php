<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;


class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            config('test_users.user1_uid') => [
                'こんにちは!Test User1です。',
                'Laravel,Firebase 学習中です',
            ],
            config('test_users.user2_uid') => [
                'Test User2です!よろしくお願いします。',
                'いいね機能のテスト投稿です。',
            ],
        ];

        foreach ($users as $uid => $posts) {
            $user = User::where('firebase_uid', $uid)->first();

            if (!$user) {
                throw new \Exception("User with UID {$uid} not found.");
            }

            foreach ($posts as $index => $content) {
                Post::create([
                    'user_id' => $user->id,
                    'content' => $content,
                    'created_at' => now()->subMinutes(10 - $index),
                ]);
            }
        }
    }
}
