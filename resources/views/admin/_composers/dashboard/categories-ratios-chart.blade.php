<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('blog::dashboard.titles.categories-ratios') }}</h3>
    </div>
    <div class="box-body">
        <div class="chart-responsive">
            <canvas id="categoriesChart" height="250"></canvas>
        </div>
    </div>
</div>

@section('scripts')
    @parent

    <script>
        $(function () {
            new Chart($("canvas#categoriesChart"), {
                type: 'doughnut',
                data: {
                    labels: {!! $categoriesRatios->pluck('label') !!},
                    datasets: [
                        {
                            data: {!! $categoriesRatios->pluck('posts') !!},
                            backgroundColor: {!! $categoriesRatios->pluck('color') !!},
                            hoverBackgroundColor: {!! $categoriesRatios->pluck('color') !!}
                        }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'right'
                    }
                }
            });
        })
    </script>
@endsection
