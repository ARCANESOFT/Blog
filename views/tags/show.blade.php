<?php /** @var  \Arcanesoft\Blog\Models\Tag  $tag */ ?>
<x-arc:layout>
    @section('page-title')
        <i class="fas fa-fw fa-tag"></i> @lang("Tag's Details")
    @endsection

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-borderless shadow-sm">
                <div class="card-header px-2">@lang('Tag')</div>
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="font-weight-light text-uppercase text-muted">@lang('Name')</td>
                            <td class="text-right small">{{ $tag->name }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-light text-uppercase text-muted">@lang('Slug')</td>
                            <td class="text-right small">{{ $tag->slug }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-light text-uppercase text-muted">@lang('Created at')</td>
                            <td class="text-right small">{{ $tag->created_at }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-light text-uppercase text-muted">@lang('Updated at')</td>
                            <td class="text-right small">{{ $tag->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="card-footer text-right px-2">
                    @can(Arcanesoft\Blog\Policies\TagsPolicy::ability('update'), [$tag])
                        <a href="{{ route('admin::blog.tags.edit', [$tag]) }}" type="button" class="btn btn-sm btn-light">
                            <i class="far fa-fw fa-edit"></i> @lang('Edit')
                        </a>
                    @endcan

                    @can(Arcanesoft\Blog\Policies\TagsPolicy::ability('delete'), [$tag])
                        <button type="button" class="btn btn-sm btn-light text-danger">
                            <i class="far fa-fw fa-trash-alt"></i> @lang('Delete')
                        </button>
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-borderless shadow-sm">
                <div class="card-header px-2">@lang('Posts')</div>
                <table class="table table-borderless table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="font-weight-light text-uppercase text-muted">@lang('Title')</th>
                            <th class="font-weight-light text-uppercase text-muted text-right">@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tag->posts as $post)
                            <tr>
                                <td class="small">{{ $post->title }}</td>
                                <td class="text-right"></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">@lang('The list is empty !')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-arc:layout>
