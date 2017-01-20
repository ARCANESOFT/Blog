@section('page-title')
    {{ $post->title }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-9">
                <div class="card card-post card-post-single">
                    <div class="card-thumbnail">
                        {{ Html::image('http://placehold.it/1400x450', $post->title, ['class' => 'card-img-top img-responsive']) }}
                    </div>
                    <div class="card-block">
                        <div class="card-meta">
                            {{ link_to_route('public::blog.categories.show', $post->category->name, [$post->category->slug]) }} / {{ $post->published_at->formatLocalized('%d %B %Y') }}
                        </div>
                        {{ $post->content }}
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                @include(Arcanesoft\Blog\ViewComposers\Front\Widgets\CategoriesWidgetComposer::VIEW)

                @include(Arcanesoft\Blog\ViewComposers\Front\Widgets\TagsWidgetComposer::VIEW)

                @include(Arcanesoft\Blog\ViewComposers\Front\Widgets\ArchivesWidgetComposer::VIEW)
            </div>
        </div>
    </div>
@endsection
