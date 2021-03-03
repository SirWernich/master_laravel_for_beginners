<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];

    use SoftDeletes, HasFactory, Taggable;

    public function comments()
    {
        return $this->morphMany(\App\Models\Comment::class, 'commentable')->latest();
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
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
    }
}
