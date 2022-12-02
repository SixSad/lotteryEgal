<?php

namespace Database\Seeders;

use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use App\Models\User;

use Illuminate\Database\Seeder;

class LotteryGameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LotteryGame::factory()
            ->count(2)
            ->has(LotteryGameMatch::factory()
                ->count(2)
            )
            ->create();

    }
}
