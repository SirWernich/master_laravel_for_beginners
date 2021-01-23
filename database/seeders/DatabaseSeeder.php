<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // -n option runs commands without prompts
        // if ($this->command->confirm('Do you want to refresh the DB?', true)) {   <-- default value is 'yes'
        if ($this->command->confirm('Do you want to refresh the DB?')) {
            $this->command->call('migrate:refresh');
            $this->command->info('DB was refreshed');
        }

        Cache::tags(['blog-post'])->flush();

        $this->call([
            UsersTableSeeder::class,
            BlogPostsTableSeeder::class,
            CommentsTableSeeder::class
        ]);
    }
}
