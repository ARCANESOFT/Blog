<x-arc:layout>
    @section('page-title')
        <i class="far fa-fw fa-newspaper"></i> @lang('New Post')
    @endsection

    {{ form()->open(['route' => 'admin::blog.posts.store', 'method' => 'POST']) }}
        <div class="card card-borderless mb-3">
            <div class="card-header">@lang('Post')</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-lg-6">
                        <label for="title" class="form-label font-weight-light text-uppercase text-muted">@lang('Title')</label>
                        {{ form()->text('title', old('title'), ['class' => 'form-control'.$errors->first('title', ' is-invalid'), 'required']) }}
                        @error('title')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="slug" class="form-label font-weight-light text-uppercase text-muted">@lang('Slug')</label>
                        {{ form()->text('slug', old('slug'), ['class' => 'form-control'.$errors->first('slug', ' is-invalid')]) }}
                        @error('slug')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label for="excerpt" class="form-label font-weight-light text-uppercase text-muted">@lang('Excerpt')</label>
                        {{ form()->text('excerpt', old('excerpt'), ['class' => 'form-control'.$errors->first('excerpt', ' is-invalid'), 'required']) }}
                        @error('body')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label for="body" class="form-label font-weight-light text-uppercase text-muted">@lang('Body')</label>
                        <v-markdown-editor name="body" value="{{ old('body') }}"></v-markdown-editor>
                        @error('body')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label for="tags" class="form-label font-weight-light text-uppercase text-muted">@lang('Tags')</label>
                        {{ form()->select('tags[]', $tags, old('tags'), ['class' => 'form-control'.$errors->first('tags', ' is-invalid'), 'multiple']) }}
                        @error('tags')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin::blog.posts.index') }}" class="btn btn-sm btn-light">@lang('Cancel')</a>
                <button type="submit" class="btn btn-sm btn-primary">@lang('Save')</button>
            </div>
        </div>
    {{ form()->close() }}

    @push('scripts')
        <script defer>
            plugins.select2('select[name="tags[]"]')
        </script>
    @endpush
</x-arc:layout>
