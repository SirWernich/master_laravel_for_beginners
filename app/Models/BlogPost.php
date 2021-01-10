<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    protected $fillable = ['title', 'content'];

    use SoftDeletes;

    use HasFactory;

    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public static function boot()
    {
        parent::boot();

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
