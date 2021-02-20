<div class="mb-2 mt-2">
    @auth
        <form action="{{ $route }}" method="post">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="content"></textarea>
            </div>
            <div>
                <input type="submit" value="Add Comment" class="btn btn-primary btn-block">
            </div>
        </form>
        @errors
        @enderrors
    @else
        <a href="{{ route('login') }}">Sign in to post comments</p>
    @endauth
</div>
<hr />
