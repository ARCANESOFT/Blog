<x-arc:layout>
    @section('page-title')
        <i class="fas fa-fw fa-tags"></i> @lang('Tags') <small>@lang('Metrics')</small>
    @endsection

    @push('content-nav')
        @include('blog::tags._partials.nav-actions')
    @endpush
</x-arc:layout>
