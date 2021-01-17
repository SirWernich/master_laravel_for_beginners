<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public static function boot()
    {
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
    }
}
