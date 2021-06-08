<?php
/**
 * @var  Arcanesoft\Blog\Models\Post[]|Illuminate\Pagination\LengthAwarePaginator  $posts
 * @var  array                                                                     $fields
 */
?>
<div class="card card-borderless shadow-sm">
    @if ($posts->isNotEmpty())
        <div class="card-header px-2">
            @include('foundation::_components.datatable.datatable-header')
        </div>
        <div class="table-responsive">
            <table id="posts-table" class="table table-borderless table-hover mb-0">
                <thead>
                    <tr>
                        <th class="font-weight-light text-uppercase text-muted">{{ $fields['title'] }}</th>
                        <th class="font-weight-light text-uppercase text-muted text-center">{{ $fields['created_at'] }}</th>
                        <th class="font-weight-light text-uppercase text-muted text-center">{{ $fields['published'] }}</th>
                        <th class="font-weight-light text-uppercase text-muted text-right">{{ $fields['actions'] }}</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="card-footer px-2">
            @include('foundation::_components.datatable.datatable-footer', ['paginator' => $posts])
        </div>
    @else
        @include('foundation::_partials.no-data-found')
    @endif
</div>
