@extends('layouts.master')
@section('title')
{{__('finance.annuallyExpenseChartSummary')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['group'=>__('finance.finance'),'links'=> [
['url' =>'','name' => __('finance.expenseChart')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="row row-card-no-pd bg-success mb-1">
        <div class="col-sm-6 col-md-6">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-chart-pie text-warning" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="col col-stats">
                            <div class="numbers">
                                <p class="card-category">{{__('finance.totalVouchers')}}</p>
                                <h4 class="card-title">
                                    {{$expenseData['orders']}}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-coins text-success" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="col col-stats">
                            <div class="numbers">
                                <p class="card-category">{{__('finance.totalAmount')}} </p>
                                <h4 class="card-title">
                                    {{$setting->currency}}{{$expenseData['amount']}}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="btn-group float-right">
                <a href="{{route('expense.detail')}}?type=bar" class="btn btn-xs"><i class="fa fa-chart-bar" aria-hidden="true"></i> {{__('finance.barView')}}</a>
                <a href="{{route('expense.detail')}}?type=line" class="btn btn-xs"><i class="fa fa-chart-line" aria-hidden="true"></i> {{__('finance.lineView')}}</a>
            </div>
            <h4 class="card-title">
                {{__('finance.expenseChartFor')}} {{date('Y')}}
            </h4>
        </div>
        <div class="card-body">
            <canvas id="barChart" ></canvas>
        </div>
    </div>
</div>
@endsection
@push('script')
<script  src="{{asset('js/plugin/chart.js/chart.min.js')}}"></script>
<script>
    $(function () {
        "use strict";
        var ChartData = {
            labels  : ["{{__('months.jan')}}", "{{__('months.feb')}}", "{{__('months.mar')}}", "{{__('months.apr')}}",
            "{{__('months.may')}}", "{{__('months.jun')}}", "{{__('months.jul')}}" ,"{{__('months.aug')}}",
            "{{__('months.sep')}}","{{__('months.oct')}}","{{__('months.nov')}}","{{__('months.dec')}}"],
            datasets: [
            {
                label               : "{{__('finance.orders')}}",
                fillColor           : "rgb(63, 10, 8)",
                strokeColor         : "rgb(63, 10, 8)",
                pointColor          : "#3F0A08",
                pointStrokeColor    : "rgb(63, 10, 8)",
                pointHighlightFill  : "#3F0A08",
                pointHighlightStroke: "rgb(63, 10, 8)",
                data                :  [{{$orders}}]
            },
            {
                label               : "{{__('finance.amountInKilo')}}",
                fillColor           : "rgb(32, 232, 105)",
                strokeColor         : "rgb(32, 232, 105)",
                pointColor          : "#20E869",
                pointStrokeColor    : "rgb(32, 232, 105)",
                pointHighlightFill  : "#20E869",
                pointHighlightStroke: "rgb(32, 232, 105)",
                data                :  [{{$amount}}]
            }
            ]
        };
        var barChartCanvas     = $("#barChart").get(0).getContext("2d");
        var barChart           = new Chart(barChartCanvas);
        var ExpenseChart                     = ChartData;
        ExpenseChart.datasets[1].fillColor   = "#00a65a";
        ExpenseChart.datasets[1].strokeColor = "#00a65a";
        ExpenseChart.datasets[1].pointColor  = "#00a65a";
        var barChartOptions                  = {
            scaleBeginAtZero        : true,
//Boolean - Whether grid lines are shown across the chart
scaleShowGridLines      : true,
//String - Colour  $(function () {
    scaleGridLineColor      : "rgba(0,0,0,.05)",
//Number - Width of the grid lines
scaleGridLineWidth      : 1,
//Boolean - Whether to show horizontal lines (except X axis)
scaleShowHorizontalLines: true,
//Boolean - Whether to show vertical lines (except Y axis)
scaleShowVerticalLines  : true,
//Boolean - If there is a stroke on each bar
barShowStroke           : true,
//Number - Pixel width of the bar stroke
barStrokeWidth          : 2,
//Number - Spacing between each of the X value sets
barValueSpacing         : 5,
//Number - Spacing between data sets within X values
barDatasetSpacing       : 1,
//Boolean - whether to make the chart responsive
responsive              : true,
maintainAspectRatio     : true
};
barChartOptions.datasetFill = false;
barChart.{{isset($_GET['type'])? ucwords($_GET['type']):'Line' }}(ExpenseChart, barChartOptions);
});
</script>
@include('partials.pageUrl',['pageLink'=>route('expense.detail')])
@endpush
