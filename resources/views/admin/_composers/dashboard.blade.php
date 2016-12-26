<div class="row">
    <div class="col-sm-6 col-md-3">
        <div class="info-box">
                <span class="info-box-icon bg-blue">
                    <i class="fa fa-fw fa-files-o"></i>
                </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Posts</span>
                <span class="info-box-number">{{ rand(200, 500) }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="info-box">
                <span class="info-box-icon bg-yellow">
                    <i class="fa fa-fw fa-bookmark-o"></i>
                </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Categories</span>
                <span class="info-box-number">{{ rand(10, 20) }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="info-box">
                <span class="info-box-icon bg-green">
                    <i class="fa fa-fw fa-tags"></i>
                </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Tags</span>
                <span class="info-box-number">{{ rand(10, 20) }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="info-box">
                <span class="info-box-icon bg-purple">
                    <i class="fa fa-fw fa-comments-o"></i>
                </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Comments</span>
                <span class="info-box-number">{{ rand(1000, 2000) }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Categories chart</h3>
            </div>
            <div class="box-body">
                <div class="chart-responsive">
                    <canvas id="categoriesPieChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Tags chart</h3>
            </div>
            <div class="box-body">
                <div class="chart-responsive">
                    <canvas id="tagsPieChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @parent

    <script>
        $(function () {
            var categoriesPieChart = new Chart($("#categoriesPieChart").get(0).getContext("2d"));
            var categoriesPieData  = [
                {
                    value:     321,
                    color:     "#F56954",
                    highlight: "#F56954",
                    label:     "Category 1"
                },{
                    value:     123,
                    color:     "#00A65A",
                    highlight: "#00A65A",
                    label:     "Category 2"
                },{
                    value:     234,
                    color:     "#F39C12",
                    highlight: "#F39C12",
                    label:     "Category 3"
                },{
                    value:     43,
                    color:     "#00C0EF",
                    highlight: "#00C0EF",
                    label:     "Category 4"
                },{
                    value:     21,
                    color:     "#3C8DBC",
                    highlight: "#3C8DBC",
                    label:     "Category 5"
                },{
                    value:     546,
                    color:     "#D2D6DE",
                    highlight: "#D2D6DE",
                    label:     "Others categories"
                }
            ];

            categoriesPieChart.Doughnut(categoriesPieData, {
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 1,
                percentageInnerCutout: 50,
                animationSteps: 100,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false,
                responsive: true,
                maintainAspectRatio: false
            });

            var tagsPieChart = new Chart($("#tagsPieChart").get(0).getContext("2d"));
            var tagsPieData  = [
                {
                    value:     123,
                    color:     "#F56954",
                    highlight: "#F56954",
                    label:     "Tag 1"
                },{
                    value:     321,
                    color:     "#00A65A",
                    highlight: "#00A65A",
                    label:     "Tag 2"
                },{
                    value:     21,
                    color:     "#F39C12",
                    highlight: "#F39C12",
                    label:     "Tag 3"
                },{
                    value:     43,
                    color:     "#00C0EF",
                    highlight: "#00C0EF",
                    label:     "Tag 4"
                },{
                    value:     546,
                    color:     "#3C8DBC",
                    highlight: "#3C8DBC",
                    label:     "Tag 5"
                },{
                    value:     234,
                    color:     "#D2D6DE",
                    highlight: "#D2D6DE",
                    label:     "Others tags"
                }
            ];

            tagsPieChart.Doughnut(tagsPieData, {
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 1,
                percentageInnerCutout: 50,
                animationSteps: 100,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false,
                responsive: true,
                maintainAspectRatio: false
            });
        });
    </script>
@endsection
