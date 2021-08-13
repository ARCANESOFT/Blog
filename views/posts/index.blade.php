<x-arc:layout>
    @section('page-title')
        <i class="far fa-fw fa-newspaper"></i> @lang('Posts')
    @endsection

    @push('content-nav')
        @include('blog::posts._partials.nav-actions')
    @endpush

    <v-datatable url="{{ route('admin::blog.posts.datatable') }}" name="posts-datatable"/>
</x-arc:layout>
