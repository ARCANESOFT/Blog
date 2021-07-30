<x-arc:layout>
    @section('page-title')
        <i class="fas fa-fw fa-tag"></i> @lang('New Tag')
    @endsection

    {{ form()->open(['route' => 'admin::blog.tags.store', 'method' => 'POST']) }}
        <div class="row">
            <div class="col-md-6">
                <div class="card card-borderless shadow-sm mb-3">
                    <div class="card-header">@lang('Tag')</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label for="name" class="form-label font-weight-light text-uppercase text-muted">@lang('Name')</label>
                                {{ form()->text('name', old('name'), ['class' => 'form-control'.$errors->first('name', ' is-invalid'), 'required']) }}
                                @error('name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <label for="name" class="form-label font-weight-light text-uppercase text-muted">@lang('Slug')</label>
                                {{ form()->text('slug', old('slug'), ['class' => 'form-control'.$errors->first('slug', ' is-invalid')]) }}
                                @error('slug')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin::blog.tags.index') }}" class="btn btn-sm btn-light">@lang('Cancel')</a>
                        <button type="submit" class="btn btn-sm btn-primary">@lang('Save')</button>
                    </div>
                </div>
            </div>
        </div>
    {{ form()->close() }}
</x-arc:layout>
