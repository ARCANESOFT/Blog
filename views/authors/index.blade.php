<x-arc:layout>
    @section('page-title')
        <i class="fas fa-fw fa-user-edit"></i> @lang('Authors')
    @endsection

    @push('content-nav')
        <nav class="page-actions">
            @can(Arcanesoft\Blog\Policies\AuthorsPolicy::ability('create'))
                <x-arc:button-action
                    type="add" :action="route('admin::blog.authors.create')"/>
            @endcan
        </nav>
    @endpush

    <v-datatable
        url="{{ route('admin::blog.authors.datatable') }}"
        name="authors-datatable"/>
</x-arc:layout>
