<div class="container">
    <div class="row">
        @card([
            'title' => 'Most commented',
            'subtitle' => 'What people are currently talking about'
        ])
            @slot('items')
                @foreach ($most_commented as $post)
                    <li class="list-group-item">
                        <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                            {{ $post->title }}
                        </a>
                    </li>
                @endforeach
            @endslot
        @endcard
    </div>
    <div class="row mt-4">
        @card([
            'title' => 'Most Active',
        ])
            @slot('subtitle')
                Users with most posts written
            @endslot
            @slot('items', collect($most_active)->pluck('name'))
        @endcard
    </div>
    <div class="row mt-4">
        @card([
            'title' => 'Most Active Users In Last Month',
        ])
            @slot('subtitle')
                Users with most posts written in last month
            @endslot
            @slot('items', collect($most_active_last_month)->pluck('name'))
        @endcard
    </div>
</div>
