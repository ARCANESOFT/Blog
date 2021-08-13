<nav class="page-actions btn-separated">
    @can(Arcanesoft\Blog\Policies\PostsPolicy::ability('metrics'))
        <x-arc:button-action
            type="metrics" action="{{ route('admin::blog.posts.metrics') }}"/>
    @endcan

    @can(Arcanesoft\Blog\Policies\PostsPolicy::ability('index'))
        <x-arc:button-action
            type="list" action="{{ route('admin::blog.posts.index') }}"/>
    @endcan

    @can(Arcanesoft\Blog\Policies\PostsPolicy::ability('create'))
        <x-arc:button-action
            type="create" action="{{ route('admin::blog.posts.create') }}"/>
    @endcan
</nav>
