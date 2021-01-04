<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users_count =max((int)$this->command->ask('How many uses would you like?', 20), 1);

        \App\Models\User::factory()->johnDoe()->create();
        \App\Models\User::factory($users_count)->create();
    }
}
