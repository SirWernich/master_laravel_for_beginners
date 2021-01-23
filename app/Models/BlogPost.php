<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
// use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];

    use SoftDeletes;

    use HasFactory;

    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class)->latest();
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function scopeLatest(Builder $builder)
    {
        return $builder->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public static function boot()
    {
        // add before the boot method call to prevent "SoftDeletes" override
        static::addGlobalScope(new DeletedAdminScope());

        parent::boot();

        // static::addGlobalScope(new LatestScope());

        // available events:
        // retrieved, creating, created, updating, updated, saving, saved, deleting,
        // deleted, restoring, restored, and replicating.
        static::deleting(function (BlogPost $post) {
            $post->comments()
                ->delete();
        });

        static::restoring(function (BlogPost $post) {
            $post->comments()
                ->restore();
        });

        static::updating(function( BlogPost $post) {
            Cache::forget("blog-post-{$post->id}");
        });
    }
}
