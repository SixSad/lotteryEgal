<?php

namespace Database\Factories;

use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class LotteryGameMatchFactory extends Factory
{
    protected $model = LotteryGameMatch::class;

    public function definition(): array
    {
        return [
            'lottery_game_id' => LotteryGame::factory(),
            'start_date' => Carbon::parse($this->faker->dateTimeBetween('+ 1 day', '+ 1 month'))->format('Y-m-d'),
            'start_time' => $this->faker->time('H:i'),
        ];
    }

}
