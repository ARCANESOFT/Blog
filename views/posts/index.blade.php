<x-arc:layout>
    @section('page-title')
        <i class="far fa-fw fa-newspaper"></i> @lang('Posts')
    @endsection

    @push('content-nav')
        <nav class="page-actions">
            <a href="{{ route('admin::blog.posts.metrics') }}"
               class="btn btn-sm btn-secondary {{ active(['admin::blog.posts.metrics']) }}">@lang('Metrics')</a>

            <a href="{{ route('admin::blog.posts.index') }}"
               class="btn btn-sm btn-secondary {{ active(['admin::blog.posts.index']) }}">@lang('List')</a>

            @can(Arcanesoft\Blog\Policies\PostsPolicy::ability('create'))
                <x-arc:button-action
                    type="add" :action="route('admin::blog.posts.create')"/>
            @endcan
        </nav>
    @endpush

    <v-datatable url="{{ route('admin::blog.posts.datatable') }}" name="posts-datatable"/>
</x-arc:layout>
