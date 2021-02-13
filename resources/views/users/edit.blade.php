@extends('layouts.app')

@section('content')

    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST" enctype="multipart/form-data"
        class="form-horizontal">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-4">
                <img src="{{ $user->image ? $user->image->url() : '' }}" class="img-thumbnail avatar" />
                <div class="card mt-4">
                    <h6>Upload a new photo</h6>
                    <input class="form-control-file" type="file" name="avatar">
                </div>
            </div>
            <div class="col-8">
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" name="name" class="form-control">
                </div>

                @errors
                @enderrors

                <div class="form-group">
                    <input type="submit" value="Save Changes" class="btn btn-primary">
                </div>
            </div>
        </div>
    </form>

@endsection
