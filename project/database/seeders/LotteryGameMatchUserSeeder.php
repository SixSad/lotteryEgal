<?php

namespace Database\Seeders;

use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use App\Models\User;

use Illuminate\Database\Seeder;

class LotteryGameMatchUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $lotteryMatches = LotteryGameMatch::all();

        $users->each(function ($user) use ($lotteryMatches) {
            $user->lotteryGameMatches()->attach(
                $lotteryMatches->pluck('id')
            );
        });

    }
}
