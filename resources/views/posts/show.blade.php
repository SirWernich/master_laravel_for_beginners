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

<div class="row">
    <div class="col-8">
        @if ($post->image)
            <div style="background-image: url(' {{ $post->image->url() }}'); min-height: 500px; color: white; text-align: center; background-attachment: fixed;">
                <h1 style="padding-top: 100px; text-shaddow: 1px solid #000;">
        @else
                <h1>
        @endif
                    {{ $post->title }}

                    @badge([
                        'type' => 'success',
                        'show' => now()->diffInMinutes($post->created_at) < 60
                    ])
                        New!
                    @endbadge


        @if ($post->image)
                </h1>
            </div>
        @else
            </h1>
        @endif

        <p>{{ $post->content }}</p>

        @updated([
            'date' => $post->created_at,
            'name' => $post->user->name,
            'userId' => $post->user->id
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

        @include('comments._form')

        @forelse ($post->comments as $comment)
            <p>{{ $comment->content }}</p>

            @updated([
                'date' => $comment->created_at,
                'name' => $comment->user->name,
                'userId' => $post->user->id
            ])
            @endupdated

            @if (!$loop->last)
                <hr>
            @endif
        @empty
            <p>No comments yet</p>
        @endforelse

    </div>
    <div class="col-4">
        @include('posts._activity')
    </div>
</div>
@endsection
