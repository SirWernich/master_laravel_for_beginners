@component('mail::message')
# Comment posted on post you're watching

Hi, {{ $user->name }}

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
