<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::query()->where('email', 'admin@admin.com')->exists()) {
            User::factory()->create(
                [
                    'email' => 'admin@admin.com',
                    'password' => 'admin',
                    'is_admin' => true
                ]
            );
        }
    }
}
