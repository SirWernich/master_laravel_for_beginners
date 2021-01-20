{{-- @if ($loop->even) --}}
    {{-- <div style="background: grey">{{ $key }}.{{ $post['title'] }}</div>
    --}}
    {{-- <div style="background: grey">{{ $post['id'] }}.{{ $post['title'] }}</div>
    @else
    <div style="background: silver">{{ $post->id }}.{{ $post['title'] }}</div>
@endif --}}
<h3>
    @if ($post->trashed())
        <del>
    @endif

    <a class="{{ $post->trashed() ? 'text-muted' : '' }}" href="{{ route('posts.show', ['post' => $post->id]) }}">
        {{ $post->title }}
    </a>

    @if ($post->trashed())
        </del>
    @endif
</h3>

@updated([
'date' => $post->created_at,
'name' => $post->user->name
])
@endupdated

@if ($post->comments_count)
    <p>
        {{ $post->comments_count }} {{ $post->comments_count == 1 ? 'comment' : 'comments' }}
    </p>
@else
    <p>No comments</p>
@endif

<div class="mb-3">
    @auth
        @can('update', $post)
           <a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
        @endcan
    @endauth

    {{-- just the opposite of "can" --}}
    {{-- @cannot('delete', $post)
    <p>you cannot delete this post</p>
    @endcannot --}}

    @auth
        @if (!$post->trashed())
            @can('delete', $post)
                <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <input type="submit" value="delete" class="btn btn-primary">
                </form>
            @endcan
        @endif
    @endauth
</div>
