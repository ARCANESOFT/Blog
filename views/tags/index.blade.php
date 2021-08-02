<x-arc:layout>
    @section('page-title')
        <i class="fas fa-fw fa-tags"></i> @lang('Tags')
    @endsection

    @push('content-nav')
        <nav class="page-actions">
            <a href="{{ route('admin::blog.tags.metrics') }}"
               class="btn btn-sm btn-secondary {{ active(['admin::blog.tags.metrics']) }}">@lang('Metrics')</a>
            <a href="{{ route('admin::blog.tags.index') }}"
               class="btn btn-sm btn-secondary {{ active(['admin::blog.tags.index']) }}">@lang('List')</a>
            {{ arcanesoft\ui\action_link('add', route('admin::blog.tags.create'))->size('sm') }}
        </nav>
    @endpush

    <v-datatable url="{{ route('admin::blog.tags.datatable') }}" name="tags-datatable"/>
</x-arc:layout>
