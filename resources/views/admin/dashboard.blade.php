@section('header')
    <h1><i class="fa fa-fw fa-bar-chart"></i> {{ trans('blog::dashboard.titles.statistics') }} <small></small></h1>
@endsection

@section('content')
    @include('blog::admin._composers.dashboard')
@endsection

@section('scripts')

@endsection
