<x-arc:layout>
    @section('page-title')
        <i class="fas fa-fw fa-user-edit"></i> @lang('Authors') <small>@lang('Metrics')</small>
    @endsection

    @push('content-nav')
        @include('blog::authors._partials.nav-actions')
    @endpush
</x-arc:layout>
