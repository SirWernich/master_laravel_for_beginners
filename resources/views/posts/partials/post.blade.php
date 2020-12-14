{{-- @if ($loop->even) --}}
    {{-- <div style="background: grey">{{ $key }}.{{ $post['title'] }}</div> --}}
    {{-- <div style="background: grey">{{ $post['id'] }}.{{ $post['title'] }}</div>
@else
    <div style="background: silver">{{ $post->id }}.{{ $post['title'] }}</div>
@endif --}}
<h3>
    <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
</h3>

@if ($post->comments_count)
    <p>
        {{ $post->comments_count }} {{ $post->comments_count == 1 ? 'comment' : 'comments' }}
    </p>
@else
    <p>No comments</p>
@endif

<div class="mb-3">
    <a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
    <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
        @csrf
        @method('delete')
        <input type="submit" value="delete" class="btn btn-primary">
    </form>
</div>
