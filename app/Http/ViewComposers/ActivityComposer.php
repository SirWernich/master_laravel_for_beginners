<?php

namespace App\Http\ViewComposers;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ActivityComposer
{
    public function compose($view)
    {
        $mostCommented = Cache::tags(['blog-post'])->remember('blog-post-most-commented', now()->addMinutes(10), function () {
            return BlogPost::mostCommented()
                ->take(5)
                ->with(['user', 'tags'])
                ->get();
        });

        $mostActive = Cache::remember('blog-post-most-active', now()->addMinutes(10), function () {
            return User::withMostBlogPosts()->take(5)->get();
        });

        $mostActiveLastMonth = Cache::remember('blog-post-most-active-last-month', now()->addMinutes(10), function () {
            return User::withMostBlogPostsLastMonth()->take(5)->get();
        });

        $view->with('most_commented', $mostCommented);
        $view->with('most_active', $mostActive);
        $view->with('most_active_last_month', $mostActiveLastMonth);
    }
}

?>
