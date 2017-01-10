<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Tags</h3>
    </div>
    <div class="list-group">
        @foreach($tagsWidgetItems as $tag)
        <a href="{{ route('public::blog.tags.show', [$tag->slug]) }}" class="list-group-item">
            {{ $tag->name }}
        </a>
        @endforeach
    </div>
</div>
