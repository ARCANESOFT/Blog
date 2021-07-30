<?php /** @var  Arcanesoft\Blog\Models\Author  $author */ ?>
<x-arc:layout>
    @section('page-title')
        <i class="fas fa-fw fa-user-edit"></i> @lang('Authors')
    @endsection

    <div class="row row-cols-md-2 g-3">
        <div class="col">
            <div class="row row-cols-1 g-3">
                <div class="col">
                    <x-arc:card>
                        <x-arc:card-header>@lang('Author')</x-arc:card-header>
                        <x-arc:card-table>
                            <tbody>
                            <tr>
                                <x-arc:table-th label="Username"/>
                                <td class="text-end">{{ $author->username }}</td>
                            </tr>
                            <tr>
                                <x-arc:table-th label="Slug"/>
                                <td class="text-end">{{ $author->slug }}</td>
                            </tr>
                            <tr>
                                <x-arc:table-th label="Created at"/>
                                <td class="text-end"><small class="text-muted">{{ $author->created_at }}</small></td>
                            </tr>
                            <tr>
                                <x-arc:table-th label="Updated at"/>
                                <td class="text-end"><small class="text-muted">{{ $author->updated_at }}</small></td>
                            </tr>
                            </tbody>
                        </x-arc:card-table>
                        <x-arc:card-footer class="d-flex justify-content-end">
                            @can(Arcanesoft\Blog\Policies\AuthorsPolicy::ability('update'), $author)
                                <x-arc:button-action
                                    type="edit" :action="route('admin::blog.authors.edit', [$author])"/>
                            @endcan

                            @can(Arcanesoft\Blog\Policies\AuthorsPolicy::ability('delete'), $author)
                                <x-arc:button-action
                                    type="delete" action="blog::authors.delete"/>
                            @endcan
                        </x-arc:card-footer>
                    </x-arc:card>
                </div>
                <div class="col">
                    <x-arc:card>
                        <x-arc:card-header>@lang('Bio')</x-arc:card-header>
                        <x-arc:card-body>{{ $author->bio }}</x-arc:card-body>
                    </x-arc:card>
                </div>
            </div>
        </div>
        <div class="col">
            @include('foundation::authorization._partials.admin-card-details', ['admin' => $author->creator])
        </div>
    </div>
</x-arc:layout>
