@section('header')
    <h1><i class="fa fa-fw fa-bookmark-o"></i> Categories <small>New Category</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            {{ Form::open(['route' => 'blog::foundation.categories.store', 'method' => 'POST', 'id' => 'createCategoriesForm', 'class' => 'form form-loading']) }}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">New Category</h2>
                </div>
                <div class="box-body">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        {{ Form::label('name', 'Name :') }}
                        {{ Form::text('name', old('name'), ['class' => 'form-control']) }}
                        @if ($errors->has('name'))
                            <span class="text-red">{!! $errors->first('name') !!}</span>
                        @endif
                    </div>
                </div>
                <div class="box-footer">
                    <a href="{{ route('blog::foundation.categories.index') }}" class="btn btn-sm btn-default">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-sm btn-primary pull-right">
                        <i class="fa fa-fw fa-plus"></i> Add
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('scripts')
@endsection
