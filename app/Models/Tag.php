<?php

namespace App\Models;

use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory, Taggable;

    public function blogPosts()
    {
        return $this->morphedByMany(\App\Models\BlogPost::class, 'taggable')
            ->withTimestamps()
            ->as('tagged');
    }

    public function comments()
    {
        return $this->morphedByMany(\App\Models\Comment::class, 'taggable')
            ->withTimestamps()
            ->as('tagged');
    }

}
