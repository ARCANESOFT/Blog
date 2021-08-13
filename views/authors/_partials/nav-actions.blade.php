<nav class="page-actions btn-separated">
    @can(Arcanesoft\Blog\Policies\AuthorsPolicy::ability('metrics'))
        <x-arc:button-action
            type="metrics" action="{{ route('admin::blog.authors.metrics') }}"/>
    @endcan

    @can(Arcanesoft\Blog\Policies\AuthorsPolicy::ability('index'))
        <x-arc:button-action
            type="list" action="{{ route('admin::blog.authors.index') }}"/>
    @endcan

    @can(Arcanesoft\Blog\Policies\AuthorsPolicy::ability('create'))
        <x-arc:button-action
            type="create" action="{{ route('admin::blog.authors.create') }}"/>
    @endcan
</nav>
