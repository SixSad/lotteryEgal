<?php

namespace Database\Seeders;

use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use App\Models\User;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::query()->where('email', 'user@user.com')->exists()) {
            User::factory()->create(
                [
                    'email' => 'user@user.com',
                    'password' => 'user',
                    'is_admin' => false
                ]
            );
        }

    }
}
