<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class BlogPostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagCount = Tag::all()->count();

        if ($tagCount === 0) {
            $this->command->info('No tags found, skipping assigning tags to blog posts');

            return;
        }

        $howManyMin = max((int)$this->command->ask('Minimum tags on blogPost?', 0), 0);
        $howManyMax = min((int)$this->command->ask('Maximum tags on blogPost?', $tagCount), $tagCount);

        BlogPost::all()->each(function(BlogPost $post) use ($howManyMax, $howManyMin) {
            $take = random_int($howManyMin, $howManyMax);
            $tags = Tag::inRandomOrder()->take($take)->get()->pluck('id');

            $post->tags()->sync($tags);
        });
    }
}
