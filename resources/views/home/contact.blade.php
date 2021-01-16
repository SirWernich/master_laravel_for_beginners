@extends('layouts.app')

@section('title', 'Contact Page')

@section('content')

<h1>Contact Page</h1>
<p>Hello, this is contact</p>

@can('home.secret')
    <p>Special contact information</p>
    <a href="{{ route('secret') }}">go to secret contact details</a>
@endcan


@endsection
