<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts_count = (int)$this->command->ask('How many posts would you like?', 50);

        $users = \App\Models\User::all();

        \App\Models\BlogPost::factory($posts_count)
            ->make()
            ->each(function($post) use ($users) {
                $post->user_id = $users->random()->id;  // get random user
                $post->save();
            });
    }
}
