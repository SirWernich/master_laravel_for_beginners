<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = \App\Models\BlogPost::all();

        if ($posts->count() === 0) {
            $this->command->info('There are no posts, so no comments will be added');
            return;
        }

        $comments_count = (int)$this->command->ask('How many comments would you like?', 150);

        \App\Models\Comment::factory($comments_count)
            ->make()
            ->each(function ($comment) use ($posts) {
                $comment->blog_post_id = $posts->random()->id;
                $comment->save();
            });
    }
}
