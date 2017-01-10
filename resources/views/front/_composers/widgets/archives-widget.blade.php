<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Archives</h3>
    </div>
    <div class="list-group">
        @foreach($archivesWidgetItems as $year => $posts)
        <a href="{{ route('public::blog.posts.archive', [$year]) }}" class="list-group-item">
            {{ $year }} <span class="badge">{{ $posts->count() }}</span>
        </a>
        @endforeach
    </div>
</div>
