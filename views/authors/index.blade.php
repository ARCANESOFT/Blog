<x-arc:layout>
    @section('page-title')
        <i class="fas fa-fw fa-user-edit"></i> @lang('Authors')
    @endsection

    @push('content-nav')
        @include('blog::authors._partials.nav-actions')
    @endpush

    <v-datatable
        url="{{ route('admin::blog.authors.datatable') }}"
        name="authors-datatable"/>
</x-arc:layout>
