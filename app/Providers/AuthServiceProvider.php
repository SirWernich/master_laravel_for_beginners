<?php

namespace App\Providers;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        BlogPost::class => 'App\Policies\BlogPostPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('home.secret', function(User $user) {
            return $user->is_admin;
        });

        // Gate::define('update-post', function(User $user, BlogPost $post) {
        //     return $user->id === $post->user_id;
        // });

        // Gate::define('delete-post', function(User $user, BlogPost $post) {
        //     return $user->id === $post->user_id;
        // });

        // Gate::define('posts.update', '\App\Policies\BlogPostPolicy@update');
        // use default naming in policy
        // Gate::resource('posts', \App\Policies\BlogPostPolicy::class);

        // // "before" is always called before the others
        Gate::before(function(User $user, $ability) {
            if ($user->is_admin && in_array($ability, ['update'])) {
                return true;
            }

            // don't return anything, that way it goes to the other gates
        });

        // // "after" is always called after the others
        // Gate::after(function(User $user, $ability) {
        //     if ($user->is_admin) {
        //         return true;
        //     }

        //     // don't return anything, that way it goes to the other gates
        // });
    }
}
