<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'uid' => config('test_users.user1_uid'),
                'name' => 'Test User1',
                'email' => 'test1@example.com',
            ],
            [
                'uid' => config('test_users.user2_uid'),
                'name' => 'Test User2',
                'email' => 'test2@example.com',
            ],
        ];

        foreach ($users as $user) {
            if (!$user['uid']) {
                throw new \Exception('Test user UID is not set in .env');
            }

            User::updateOrCreate(
                ['firebase_uid' => $user['uid']],
                [
                    'name' => $user['name'],
                    'email' => $user['email'],
                ]
            );
        }
    }
}
