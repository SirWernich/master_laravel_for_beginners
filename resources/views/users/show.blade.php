@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-4">
            <img src="{{ $user->image ? $user->image->url() : '' }}" class="img-thumbnail avatar" />
        </div>
        <div class="col-8">
            <h3>{{ $user->name }}</h3>

            <p>Currently viewed by {{ $counter }} other user(s)</p>

            @commentForm([
                'route' => route('users.comments.store', [ 'user' => $user->id ])
            ])
            @endcommentForm

            @commentList([
                'comments' => $user->commentsOn,
                'userId' => $user->id
            ])
            @endcommentList
        </div>

    </div>

@endsection
