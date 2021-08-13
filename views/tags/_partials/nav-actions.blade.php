<nav class="page-actions btn-separated">
    @can(Arcanesoft\Blog\Policies\TagsPolicy::ability('metrics'))
        <x-arc:button-action
            type="metrics" action="{{ route('admin::blog.tags.metrics') }}"/>
    @endcan

    @can(Arcanesoft\Blog\Policies\TagsPolicy::ability('index'))
        <x-arc:button-action
            type="list" action="{{ route('admin::blog.tags.index') }}"/>
    @endcan

    @can(Arcanesoft\Blog\Policies\TagsPolicy::ability('create'))
        <x-arc:button-action
            type="create" action="{{ route('admin::blog.tags.create') }}"/>
    @endcan
</nav>
