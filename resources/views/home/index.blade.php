@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

<h1>{{ __('messages.welcome') }}</h1>
{{-- <h1>@lang('messages.welcome')</h1> --}}

<p>{{ __('messages.example_with_value', ['name' => 'john']) }}</p>

<p>{{ trans_choice('messages.plural', 0) }}</p>
<p>{{ trans_choice('messages.plural', 1) }}</p>
<p>{{ trans_choice('messages.plural', 2) }}</p>

<p>Using JSON here: {{ __('Welcome to Laravel!') }}</p>

<p>{{ __('Hello :name', ['name' => 'john']) }}</p>

<p>this is the content of the main page</p>
@endsection
