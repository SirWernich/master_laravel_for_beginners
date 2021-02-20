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
        return $this->morphMany(\App\Models\Comment::class, 'commentable')->latest();
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(\App\Models\Tag::class)
            ->withTimestamps()
            ->as('tagged');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function scopeLatest(Builder $builder)
    {
        return $builder->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public function scopeLatestsWithRelationships(Builder $query)
    {
        return $query->latest()
            ->withCount('comments')
            ->with(['user', 'tags']);
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
            Cache::tags('blog-post')->forget("blog-post-{$post->id}");
        });

        static::restoring(function (BlogPost $post) {
            $post->comments()
                ->restore();
        });

        static::updating(function (BlogPost $post) {
            Cache::tags('blog-post')->forget("blog-post-{$post->id}");
        });
    }
}
