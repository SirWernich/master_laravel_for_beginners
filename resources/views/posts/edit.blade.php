@extends('layouts.app')

@section('title', 'Update a post')

@section('content')
    <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="post">
        @csrf
        @method('put')
        @include('posts.partials.form')
        <div><input type="submit" value="Update" class="btn btn-primary btn-block"></div>
    </form>
@endsection
