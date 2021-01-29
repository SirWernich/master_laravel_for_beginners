<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostTagController extends Controller
{
    public function index($tagId)
    {
        $tag = Tag::findOrFail($tagId);

        return view('posts.index', [
            'posts' => $tag->blogPosts,
            'most_commented' => [],
            'most_active' => [],
            'most_active_last_month' => [],
        ]);
    }
}
