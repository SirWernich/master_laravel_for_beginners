<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'content'];

    public function blogPost()
    {
        return $this->belongsTo('App\Models\BlogPost');
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

        static::creating(function (Comment $comment) {
            Cache::tags('blog-post')->forget("blog-post-{$comment->blog_post_id}");
            Cache::tags('blog-post')->forget('blog-post-most-commented');
        });
    }
}
