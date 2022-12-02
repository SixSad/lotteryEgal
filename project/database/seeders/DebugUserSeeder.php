<?php

namespace Database\Seeders;

use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use App\Models\User;

use Illuminate\Database\Seeder;

class DebugUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(3)->create();

    }
}
