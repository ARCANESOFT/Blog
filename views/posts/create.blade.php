<x-arc:layout>
    @section('page-title')
        <i class="far fa-fw fa-newspaper"></i> @lang('Posts') <small>@lang('New Post')</small>
    @endsection

    <x-arc:form action="{{ route('admin::blog.posts.store') }}">
        <x-arc:card>
            <x-arc:card-header>@lang('Post')</x-arc:card-header>
            <x-arc:card-body>
                <div class="row g-3">
                    <div class="col-lg-6">
                        {{-- TITLE --}}
                        <x-arc:input-control type="text" name="title" label="Title" required/>
                    </div>
                    <div class="col-lg-6">
                        {{-- SLUG --}}
                        <x-arc:input-control type="text" name="slug" label="Slug" required/>
                    </div>
                    <div class="col-12">
                        {{-- Excerpt --}}
                        <x-arc:input-control type="text" name="excerpt" label="Excerpt" required/>
                    </div>
                    <div class="col-12">
                        <x-arc:vue-control use="v-markdown-editor" name="body" label="Body"/>
                    </div>
                    <div class="col-12">
                        {{-- Excerpt --}}
                        <x-arc:select-control id="tags" name="tags[]" :options="$tags" label="Tags"/>
                    </div>
                </div>
            </x-arc:card-body>
            <div class="card-footer d-flex justify-content-between">
                <x-arc:form-cancel-button to="{{ route('admin::blog.posts.index') }}"/>
                <x-arc:form-submit-button type="save"/>
            </div>
        </x-arc:card>
    </x-arc:form>

    @push('scripts')
        <script defer>
            // plugins.select2('select#tags')
        </script>
    @endpush
</x-arc:layout>
