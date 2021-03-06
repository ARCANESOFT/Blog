<?php /** @var  \Arcanesoft\Blog\Models\Category  $category */ ?>

@section('page-title')
    {{ $category->name }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-9">
                @forelse ($posts as $post)
                    <div class="card card-post">
                        <a href="{{ route('public::blog.posts.show', [$post->slug]) }}" class="card-thumbnail">
                            {{ Html::image('http://placehold.it/1400x450', $post->title, ['class' => 'card-img-top img-responsive']) }}
                        </a>
                        <div class="card-block">
                            <h4 class="card-title">
                                {{ link_to_route('public::blog.posts.show', $post->title, [$post->slug]) }}
                            </h4>
                            <div class="card-meta">
                                {{ link_to_route('public::blog.categories.show', $post->category->name, [$post->category->slug]) }} / {{ $post->published_at->formatLocalized('%d %B %Y') }}
                            </div>
                            <p class="card-text">{{ $post->excerpt }}</p>
                            {{ link_to_route('public::blog.posts.show', 'Read more&hellip;', [$post->slug]) }}
                        </div>
                    </div>
                @empty

                @endforelse

                {{ $posts->links() }}
            </div>
            <div class="col-md-4 col-lg-3">
                @include(Arcanesoft\Blog\ViewComposers\Front\Widgets\CategoriesWidgetComposer::VIEW)

                @include(Arcanesoft\Blog\ViewComposers\Front\Widgets\TagsWidgetComposer::VIEW)

                @include(Arcanesoft\Blog\ViewComposers\Front\Widgets\ArchivesWidgetComposer::VIEW)
            </div>
        </div>
    </div>
@endsection
