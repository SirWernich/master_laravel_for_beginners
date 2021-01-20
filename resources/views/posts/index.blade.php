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
            <div class="container">
                <div class="row">
                    @card([
                        'title' => 'Most commented',
                        'subtitle' => 'What people are currently talking about'
                    ])
                        @slot('items')
                            @foreach ($most_commented as $post)
                                <li class="list-group-item">
                                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                        {{ $post->title }}
                                    </a>
                                </li>
                            @endforeach
                        @endslot
                    @endcard
                </div>
                <div class="row mt-4">
                    @card([
                        'title' => 'Most Active',
                    ])
                        @slot('subtitle')
                            Users with most posts written
                        @endslot
                        @slot('items', collect($most_active)->pluck('name'))
                    @endcard
                </div>
                <div class="row mt-4">
                    @card([
                        'title' => 'Most Active Users In Last Month',
                    ])
                        @slot('subtitle')
                            Users with most posts written in last month
                        @endslot
                        @slot('items', collect($most_active_last_month)->pluck('name'))
                    @endcard
                </div>
            </div>
        </div>

    </div>
@endsection
