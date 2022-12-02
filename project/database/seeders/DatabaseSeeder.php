<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DebugUserSeeder::class,
            LotteryGameSeeder::class,
            LotteryGameMatchUserSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
        ]);

    }
}
