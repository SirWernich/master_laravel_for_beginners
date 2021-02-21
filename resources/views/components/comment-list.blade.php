@forelse ($comments as $comment)
    <p>{{ $comment->content }}</p>

    @tags(['tags' => $comment->tags])
    @endtags

    @updated([
        'date' => $comment->created_at,
        'name' => $comment->user->name,
        'userId' => $userId
    ])
    @endupdated

    @if (!$loop->last)
        <hr>
    @endif
@empty
    <p>No comments yet</p>
@endforelse
