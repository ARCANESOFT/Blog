@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fas fa-fw fa-user-edit"></i> {{ __('Authors') }}
@endsection

<?php
/** @var  Arcanesoft\Blog\Models\Author  $author */
?>

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-borderless shadow-sm mb-3">
                <div class="card-header">{{ __('Author') }}</div>
                <table class="table table-md table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th class="table-th">@lang('Username') :</th>
                            <td class="text-right">{{ $author->username }}</td>
                        </tr>
                        <tr>
                            <th class="table-th">@lang('Slug') :</th>
                            <td class="text-right">{{ $author->slug }}</td>
                        </tr>
                        <tr>
                            <th class="table-th">@lang('Created at') :</th>
                            <td class="text-right"><small class="text-muted">{{ $author->created_at }}</small></td>
                        </tr>
                        <tr>
                            <th class="table-th">@lang('Updated at') :</th>
                            <td class="text-right"><small class="text-muted">{{ $author->updated_at }}</small></td>
                        </tr>
                    </tbody>
                </table>
                <div class="card-footer p-2 text-right">
                    @can(Arcanesoft\Blog\Policies\AuthorsPolicy::ability('update'), $author)
                        {{ arcanesoft\ui\action_link('edit', route('admin::blog.authors.edit', [$author]))->size('sm') }}
                    @endcan

                    @can(Arcanesoft\Blog\Policies\AuthorsPolicy::ability('delete'), $author)
                        {{ arcanesoft\ui\action_button('delete')->attribute('onclick', "window.Foundation.\$emit('blog::authors.delete')")->size('sm')->setDisabled($author->isNotDeletable()) }}
                    @endcan
                </div>
            </div>
            <div class="card card-borderless shadow-sm mb-3">
                <div class="card-header">@lang('Bio')</div>
                <div class="card-body">
                    {{ $author->bio }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            @include('foundation::authorization._partials.admin-card-details', ['admin' => $author->creator])
        </div>
    </div>
@endsection

@push('modals')
@endpush

@push('scripts')
@endpush
