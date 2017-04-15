<?php /** @var  \Arcanesoft\Blog\Models\Post  $post */ ?>

@section('header')
    <h1><i class="fa fa-fw fa-files-o"></i> {{ trans('blog::posts.titles.posts') }} <small>{{ $post->title }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-5 col-lg-4">
            <div class="box">
                <div class="box-header">
                    <h2 class="box-title">{{ trans('blog::posts.titles.post-details') }}</h2>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed no-margin">
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <b>{{ trans('blog::posts.attributes.title') }}:</b><br>
                                        {{ $post->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>C{{ trans('blog::posts.attributes.category') }}:</th>
                                    <td class="text-right">
                                        <span class="label label-primary">{{ $post->category->name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('blog::posts.attributes.author') }}:</th>
                                    <td class="text-right">
                                        <span class="label label-inverse">{{ $post->author->full_name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>{{ trans('blog::posts.attributes.slug') }}:</b><br>
                                        {{ $post->slug }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>{{ trans('blog::posts.attributes.permalink') }}:</b><br>
                                        {{ route('public::blog.posts.show', [$post->slug]) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>{{ trans('blog::posts.attributes.excerpt') }}:</b><br>
                                        {{ $post->excerpt }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>{{ trans('blog::posts.attributes.tags') }}:</b><br>
                                        @foreach($post->tags as $tag)
                                            <span class="label label-info">{{ $tag->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('blog::posts.attributes.status') }}:</th>
                                    <td class="text-right">
                                        <span class="label label-{{ $post->isDraft() ? 'default' : 'success' }}">
                                            {{ $post->status_name }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('core::generals.created_at') }}:</th>
                                    <td class="text-right">
                                        <small>{{ $post->created_at }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('core::generals.updated_at') }}:</th>
                                    <td class="text-right">
                                        <small>{{ $post->created_at }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('blog::posts.attributes.published_at') }}:</th>
                                    <td class="text-right">
                                        <small>{{ $post->published_at }}</small>
                                    </td>
                                </tr>
                                @if ($post->trashed())
                                <tr>
                                    <th>{{ trans('core::generals.trashed_at') }}:</th>
                                    <td class="text-right">
                                        <small>{{ $post->deleted_at }}</small>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer text-right">
                    @can(\Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_UPDATE)
                        {{ ui_link('edit', route('admin::blog.posts.edit', [$post])) }}

                        @if ($post->trashed())
                            {{ ui_link('restore', '#restore-post-modal') }}
                        @endif
                    @endcan

                    @can(\Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_DELETE)
                        {{ ui_link('delete', '#delete-post-modal') }}
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-md-7 col-lg-8">
            <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ trans('blog::posts.attributes.content') }}</h2>
                    <div class="box-tools">
                        <ul class="nav nav-pills nav-sm" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#content_html" aria-controls="content_html" role="tab" data-toggle="tab">HTML</a>
                            </li>
                            <li role="presentation">
                                <a href="#content_raw" aria-controls="content_raw" role="tab" data-toggle="tab">RAW</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="box-body">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="content_html">
                            {{ $post->content }}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="content_raw">
                            <pre>{{ $post->content_raw }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @can(\Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_UPDATE)
        @if ($post->trashed())
            <script>
                $(function () {
                    // RESTORE MODAL
                });
            </script>
        @endif
    @endcan

    @can(\Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_DELETE)
        <script>
            $(function () {
                // DELETE MODAL
            });
        </script>
    @endcan
@endsection
