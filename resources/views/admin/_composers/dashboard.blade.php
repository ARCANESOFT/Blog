<div class="row">
    <div class="col-sm-6 col-md-3">
        @include(\Arcanesoft\Blog\ViewComposers\Admin\Dashboard\PostsCountComposer::VIEW)
    </div>
    <div class="col-sm-6 col-md-3">
        @include(\Arcanesoft\Blog\ViewComposers\Admin\Dashboard\CategoriesCountComposer::VIEW)
    </div>
    <div class="col-sm-6 col-md-3">
        @include(\Arcanesoft\Blog\ViewComposers\Admin\Dashboard\TagsCountComposer::VIEW)
    </div>
    <div class="col-sm-6 col-md-3">
        @include(\Arcanesoft\Blog\ViewComposers\Admin\Dashboard\CommentsCountComposer::VIEW)
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @include(\Arcanesoft\Blog\ViewComposers\Admin\Dashboard\CategoriesRatiosComposer::VIEW)
    </div>
    <div class="col-md-6">
        @include(\Arcanesoft\Blog\ViewComposers\Admin\Dashboard\TagsRatiosComposer::VIEW)
    </div>
</div>

@section('scripts')
    @parent
@endsection
