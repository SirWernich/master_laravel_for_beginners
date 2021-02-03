@extends('layouts.app')

@section('title', 'Posts')

@section('content')
    <div class="row">
        <div class="col-8">
            @forelse ($posts as $key => $post)
                {{-- @break($key == 2) --}}
                {{-- @continue($key == 1) --}}
                @include('posts.partials.post')
            @empty
                <p>No posts yet</p>
            @endforelse
        </div>
        <div class="col-4">
            @include('posts._activity')
        </div>

    </div>
@endsection
