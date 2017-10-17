<?php /** @var  Arcanesoft\Blog\Models\Category  $category */ ?>

@inject('blog', 'Arcanesoft\Blog\Blog')

@section('header')
    <h1><i class="fa fa-fw fa-bookmark-o"></i> {{ trans('blog::categories.titles.categories') }} <small>{{ $category->name }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('blog::categories.titles.category-details') }}</h3>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed no-margin">
                            <tbody>
                                <tr>
                                    <th>{{ trans('blog::categories.attributes.name') }} :</th>
                                    <td>
                                        @if ($blog->isTranslatable())
                                            @foreach ($category->getTranslations('name') as $name)
                                                <span class="label label-inverse">{{ $name }}</span>
                                            @endforeach
                                        @else
                                            <span class="label label-inverse">{{ $category->name }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('blog::categories.attributes.slug') }} :</th>
                                    <td>
                                        @if ($blog->isTranslatable())
                                            @foreach ($category->getTranslations('slug') as $slug)
                                                <span class="label label-primary">{{ $slug }}</span>
                                            @endforeach
                                        @else
                                            <span class="label label-primary">{{ $category->slug }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('blog::posts.titles.posts') }} :</th>
                                    <td>
                                        {{ label_count($category->posts->count()) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('core::generals.created_at') }} :</th>
                                    <td>
                                        <small>{{ $category->created_at }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('core::generals.updated_at') }} :</th>
                                    <td>
                                        <small>{{ $category->updated_at }}</small>
                                    </td>
                                </tr>
                                @if ($category->trashed())
                                    <tr>
                                        <th>{{ trans('core::generals.deleted_at') }} :</th>
                                        <td>
                                            <small>{{ $category->deleted_at }}</small>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer text-right">
                    @can(Arcanesoft\Blog\Policies\CategoriesPolicy::PERMISSION_UPDATE)
                        {{ ui_link('edit', route('admin::blog.categories.edit', [$category])) }}

                        @if ($category->trashed())
                            {{ ui_link('restore', '#restore-category-modal') }}
                        @endif
                    @endcan

                    @can(Arcanesoft\Blog\Policies\CategoriesPolicy::PERMISSION_DELETE)
                        {{ ui_link('delete', '#delete-category-modal', [], ! $category->isDeletable()) }}
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-md-8">
            {{-- POSTS --}}
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{ trans('blog::posts.titles.posts') }}</h3>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed table-hover no-margin">
                            <thead>
                                <tr>
                                    <th>{{ trans('blog::posts.attributes.locale') }}</th>
                                    <th>{{ trans('blog::posts.attributes.title') }}</th>
                                    <th>{{ trans('blog::posts.attributes.slug') }}</th>
                                    <th class="text-right" style="width: 80px;">{{ trans('core::generals.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($category->posts as $post)
                                    <tr>
                                        <td style="width: 60px;">
                                            <span class="label label-inverse">{{ strtoupper($post->locale) }}</span>
                                        </td>
                                        <td>{{ $post->title }}</td>
                                        <td>
                                            <span class="label label-primary">{{ $post->slug }}</span>
                                        </td>
                                        <td class="text-right">
                                            @can(Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_SHOW)
                                                {{ ui_link_icon('show', route('admin::blog.posts.show', [$post])) }}
                                            @endcan

                                            @can(Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_UPDATE)
                                                {{ ui_link_icon('edit', route('admin::blog.posts.edit', [$post])) }}
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <span class="label label-default">{{ trans('blog::categories.has-no-posts') }}</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @can(Arcanesoft\Blog\Policies\CategoriesPolicy::PERMISSION_UPDATE)
        @if ($category->trashed())
            {{-- RESTORE MODAL --}}
            <div id="restore-category-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    {{ Form::open(['route' => ['admin::blog.categories.restore', $category], 'method' => 'PUT', 'id' => 'restore-category-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">{{ trans('blog::categories.modals.restore.title') }}</h4>
                            </div>
                            <div class="modal-body">
                                <p>{!! trans('blog::categories.modals.restore.message', ['name' => $category->name]) !!}</p>
                            </div>
                            <div class="modal-footer">
                                {{ ui_button('cancel')->appendClass('pull-left')->setAttribute('data-dismiss', 'modal') }}
                                {{ ui_button('restore', 'submit')->withLoadingText() }}
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        @endif
    @endcan

    @can(Arcanesoft\Blog\Policies\CategoriesPolicy::PERMISSION_DELETE)
        {{-- DELETE MODAL --}}
        <div id="delete-category-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                {{ Form::open(['route' => ['admin::blog.categories.delete', $category], 'method' => 'DELETE', 'id' => 'delete-category-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">{{ trans('blog::categories.modals.delete.title') }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>{!! trans('blog::categories.modals.delete.message', ['name' => $category->name]) !!}</p>
                        </div>
                        <div class="modal-footer">
                            {{ ui_button('cancel')->appendClass('pull-left')->setAttribute('data-dismiss', 'modal') }}
                            {{ ui_button('delete', 'submit')->withLoadingText() }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    @endcan
@endsection

@section('scripts')
    {{-- RESTORE SCRIPT --}}
    @can(Arcanesoft\Blog\Policies\CategoriesPolicy::PERMISSION_UPDATE)
        @if ($category->trashed())
            <script>
                $(function () {
                    var $restoreCategoryModal = $('div#restore-category-modal'),
                        $restoreCategoryForm  = $('form#restore-category-form');

                    $('a[href="#restore-category-modal"]').on('click', function (e) {
                        e.preventDefault();

                        $restoreCategoryModal.modal('show');
                    });

                    $restoreCategoryForm.on('submit', function (e) {
                        e.preventDefault();

                        var submitBtn = $restoreCategoryForm.find('button[type="submit"]');
                            submitBtn.button('loading');

                        axios.put($restoreCategoryForm.attr('action'))
                             .then(function (response) {
                                 if (response.data.code === 'success') {
                                     $restoreCategoryModal.modal('hide');
                                     location.reload();
                                 }
                             })
                             .catch(function (error) {
                                 alert('AJAX ERROR ! Check the console !');
                                 console.log(error);
                                 submitBtn.button('reset');
                             });

                        return false;
                    });
                });
            </script>
        @endif
    @endcan

    {{-- DELETE SCRIPT --}}
    @can(Arcanesoft\Blog\Policies\CategoriesPolicy::PERMISSION_DELETE)
        @if ($category->isDeletable())
            <script>
                $(function () {
                    var $deleteCategoryModal = $('div#delete-category-modal'),
                        $deleteCategoryForm  = $('form#delete-category-form');

                    $('a[href="#delete-category-modal"]').on('click', function (e) {
                        e.preventDefault();

                        $deleteCategoryModal.modal('show');
                    });

                    $deleteCategoryForm.on('submit', function(e) {
                        e.preventDefault();

                        var submitBtn = $deleteCategoryForm.find('button[type="submit"]');
                            submitBtn.button('loading');

                        axios.delete($deleteCategoryForm.attr('action'))
                             .then(function (response) {
                                 if (response.data.code === 'success') {
                                     $deleteCategoryModal.modal('hide');
                                     @if ($category->trashed())
                                         location.replace("{{ route('admin::blog.categories.index') }}");
                                     @else
                                         location.reload();
                                     @endif
                                 }
                             })
                             .catch(function (error) {
                                 alert('AJAX ERROR ! Check the console !');
                                 console.log(error);
                                 submitBtn.button('reset');
                             });

                        return false;
                    });
                });
            </script>
        @endif
    @endcan
@endsection
