<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Tags ratios</h3>
    </div>
    <div class="box-body">
        <div class="chart-responsive">
            <canvas id="tagsChart" height="250"></canvas>
        </div>
    </div>
</div>

@section('scripts')
    @parent

    <script>
        $(function () {
            new Chart($("canvas#tagsChart"), {
                type: 'doughnut',
                data: {
                    labels: {!! $tagsRatios->pluck('label') !!},
                    datasets: [
                        {
                            data: {!! $tagsRatios->pluck('posts') !!},
                            backgroundColor: {!! $tagsRatios->pluck('color') !!},
                            hoverBackgroundColor: {!! $tagsRatios->pluck('color') !!}
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
        });
    </script>
@endsection
