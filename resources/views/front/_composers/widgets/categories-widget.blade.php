<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Categories</h3>
    </div>
    <div class="list-group">
        @foreach($categoriesWidgetItems as $category)
        <a href="{{ route('public::blog.categories.show', [$category->slug]) }}" class="list-group-item">
            {{ $category->name }} <span class="badge">{{ $category->posts->count() }}</span>
        </a>
        @endforeach
    </div>
</div>
