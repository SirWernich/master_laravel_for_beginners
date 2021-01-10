@extends('layouts.app')

{{-- @section('title', $post['title'])

@section('content')

@if ($post['is_new'])
    <div>a new blog post... using 'if'</div>
    @else
    <div>blog post is old... using 'else'</div>
@endif

@unless($post['is_new'])
<div>it is an old post... using 'unless'
    @endunless

    <h1>{{ $post['title'] }}</h1>
    <p>{{ $post['content'] }}</p>

    @isset($post['has_posts'])
    <div>this post has comments... using 'isset'
        @endisset

        @endsection --}}

@section('title', $post->title)

@section('content')

    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <p>Added {{ $post->created_at->diffForHumans() }}</p>

    @if (now()->diffInMinutes($post->created_at) < 5)

        <div class="alert alert-info">New!</div>

    @endif

    <h4>Comments</h4>
    @forelse ($post->comments as $comment)
        <p>{{ $comment->content }}</p>
        <p class="text-muted">added {{ $comment->created_at->diffForHumans() }}</p>
        @if (!$loop->last)
            <hr>
        @endif
    @empty
        <p>No comments yet</p>
    @endforelse

@endsection
