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
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Most commented</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                What people are currently talking about
                            </h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($most_commented as $post)
                                <li class="list-group-item">
                                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                        {{ $post->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Most Active</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                Users with most posts written
                            </h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($most_active as $user)
                                <li class="list-group-item">
                                    {{ $user->name }} ({{ $user->blog_posts_count }})
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Most Active Users In Last Month</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                Users with most posts written in last month
                            </h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($most_active as $user)
                                <li class="list-group-item">
                                    {{ $user->name }} ({{ $user->blog_posts_count }})
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
