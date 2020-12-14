<div class="form-group">
    <label for="title">Title</label>
    <input class="form-control" type="text" name="title" value="{{ old('title', optional($post ?? null)->title) }}">
</div>
@error('title')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<div class="form-group">
    <label for="title">Content</label>
    <textarea class="form-control" name="content">{{ old('content', optional($post ?? null)->content) }}</textarea>
</div>
@if ($errors->any())
    <div>
        <ul class="list-group mb-3">
            @foreach ($errors->all() as $error)
                <li class="list-group-item list-group-item-danger">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
