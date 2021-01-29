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

    <h1>
        {{ $post->title }}

        @badge([
            'type' => 'success',
            'show' => now()->diffInMinutes($post->created_at) < 60
        ])
            New!
        @endbadge

    </h1>

    @updated([
        'date' => $post->created_at,
        'name' => $post->user->name
    ])
    @endupdated

    @updated([
        'date' => $post->updated_at,
    ])
        Updated
    @endupdated

    @tags(['tags' => $post->tags])
    @endtags

    <p>Currently read by {{ $counter }} people</p>

    <h4>Comments</h4>
    @forelse ($post->comments as $comment)
        <p>{{ $comment->content }}</p>

        @updated([
            'date' => $comment->created_at
        ])
        @endupdated

        @if (!$loop->last)
            <hr>
        @endif
    @empty
        <p>No comments yet</p>
    @endforelse

@endsection
