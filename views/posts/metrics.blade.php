<x-arc:layout>
    @section('page-title')
        <i class="far fa-fw fa-newspaper"></i> @lang('Posts') <small>@lang('Metrics')</small>
    @endsection

    @push('content-nav')
        @include('blog::posts._partials.nav-actions')
    @endpush
</x-arc:layout>
