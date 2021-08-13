<x-arc:layout>
    @section('page-title')
        <i class="fas fa-fw fa-tags"></i> @lang('Tags')
    @endsection

    @push('content-nav')
        @include('blog::tags._partials.nav-actions')
    @endpush

    <v-datatable url="{{ route('admin::blog.tags.datatable') }}" name="tags-datatable"/>
</x-arc:layout>
