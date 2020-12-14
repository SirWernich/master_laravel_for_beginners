@extends('layouts.app')

@section('title', 'Create a post')

@section('content')
    <form action="{{ route('posts.store') }}" method="post">
        @csrf
        @include('posts.partials.form')
        <div><input type="submit" value="Create" class="btn btn-primary btn-block"></div>
    </form>
@endsection
