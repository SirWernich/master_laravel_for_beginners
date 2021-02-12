<div class="form-group">
    <label for="title">Title</label>
    <input class="form-control" type="text" name="title" value="{{ old('title', optional($post ?? null)->title) }}">
</div>

<div class="form-group">
    <label for="title">Content</label>
    <textarea class="form-control" name="content">{{ old('content', optional($post ?? null)->content) }}</textarea>
</div>

<div class="form-group">
    <label for="title">Thumbnail</label>
    <input class="form-control-file" type="file" name="thumbnail">
</div>

@errors()
@enderrors
