@component('mail::message')
# Comment posted on blog post

Hi, {{ $comment->commentable->user->name }}

Someone has commented on your blog post:<br>

{{ $comment->commentable->title }}

@component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable->id])])
View blog post
@endcomponent

@component('mail::button', ['url' => route('users.show', ['user' => $comment->user->id])])
View {{ $comment->user->name }} profile
@endcomponent

@component('mail::panel')
{{ $comment->content }}
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
