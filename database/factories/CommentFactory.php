<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $comments = [
            'いいですね！',
            '参考になります！',
            '応援しています！',
            '素敵な投稿ですね!',
            '頑張ってください!',
            '共感しました！',
            'すごく分かります!',
        ];

        return [
            'content' => $this->faker->randomElement($comments),
        ];
    }
}
