@extends('layouts.app')

@section('title', 'Posts')

@section('content')

        @forelse ($posts as $key => $post)
            {{-- @break($key == 2) --}}
            {{-- @continue($key == 1) --}}
            @include('posts.partials.post')
        @empty
            <p>No posts yet</p>
        @endforelse
@endsection
