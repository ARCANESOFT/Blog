@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fas fa-fw fa-user-edit"></i> @lang('Authors')
@endsection

@push('content-nav')
    <nav class="page-actions">
        {{ arcanesoft\ui\action_link('add', route('admin::blog.authors.create'))->size('sm') }}
    </nav>
@endpush

@section('content')
    <v-datatable url="{{ route('admin::blog.authors.datatable') }}"
                 name="authors-datatable"/>
@endsection

@push('scripts')
    <script>
    </script>
@endpush
