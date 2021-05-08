@extends('layouts.master')
@section('title')
{{__('finance.annullayRefundChart')}}
@endsection
@push('breadcrumbs')
@include('./partials.breadcrumbs',['group'=>__('finance.finance'),'links'=> [
['url' =>'','name' => __('finance.refundChart')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="row row-card-no-pd bg-danger mb-1">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col col-stats">
                            <div class="numbers">
                                <p class="card-category">{{__('finance.refundOrders')}}</p>
                                <h4 class="card-title">{{$refundData['orders']}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col col-stats">
                            <div class="numbers">
                                <p class="card-category">{{__('finance.returnedItems')}}</p>
                                <h4 class="card-title">{{$refundData['items']}}</h4>
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
                        <div class="col col-stats">
                            <div class="numbers">
                                <p class="card-category">{{__('finance.taxFall')}}</p>
                                <h4 class="card-title">{{$setting->currency}}{{$refundData['tax_amount']}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-card-no-pd bg-danger mb-1">
        <div class="col-sm-6 col-md-6">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col col-stats">
                            <div class="numbers">
                                <p class="card-category">{{__('finance.refundCharges')}}</p>
                                <h4 class="card-title">{{$setting->currency}}{{$refundData['charge_amount']}}</h4>
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
                        <div class="col col-stats">
                            <div class="numbers">
                                <p class="card-category">{{__('finance.refundedAmount')}}</p>
                                <h4 class="card-title">{{$setting->currency}}{{$refundData['refundable']}}</h4>
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
                <a href="{{route('refund.detail')}}?type=bar" class="btn btn-xs">
                    <i class="fa fa-chart-bar" aria-hidden="true"></i> {{__('finance.barView')}}
                </a>
                <a href="{{route('refund.detail')}}?type=line" class="btn btn-xs">
                    <i class="fa fa-chart-line" aria-hidden="true"></i> {{__('finance.lineView')}}
                </a>
            </div>
            <h4 class="card-title text-danger">
                {{__('finance.refundChartYearFor')}}  {{date('Y')}}
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
                label               : "{{__('finance.refundOrders')}}",
                fillColor           : "rgba(255, 174, 0, 1)",
                strokeColor         : "rgba(255, 174, 0, 1)",
                pointColor          : "rgba(255, 174, 0, 1)",
                pointStrokeColor    : "#ffae00",
                pointHighlightFill  : "#ffae00",
                pointHighlightStroke: "rgba(255, 174, 0, 1)",
                data                : [{{$orders}}]
            },
            {
                label               : "{{__('finance.returnedItems')}}",
                fillColor           : "rgba(255, 13, 0, 1)",
                strokeColor         : "rgba(255, 13, 0, 1)",
                pointColor          : "rgba(255, 13, 0, 1)",
                pointStrokeColor    : "#ff0d00",
                pointHighlightFill  : "#ff0d00",
                pointHighlightStroke: "rgba(255, 13, 0, 1)",
                data                : [{{$items}}]
            },
            {
                label               : "{{__('finance.taxFall')}}",
                fillColor           : "rgba(72, 0, 255, 1)",
                strokeColor         : "rgba(72, 0, 255, 1)",
                pointColor          : "#4800ff",
                pointStrokeColor    : "rgba(72, 0, 255, 1)",
                pointHighlightFill  : "#4800ff",
                pointHighlightStroke: "rgba(72, 0, 255, 1)",
                data                :  [{{$tax_amount}}]
            },
            {
                label               : "{{__('finance.refundCharges')}}",
                fillColor           : "rgba(86, 11, 91, 1)",
                strokeColor         : "rgba(86, 11, 91, 1)",
                pointColor          : "#560b5b",
                pointStrokeColor    : "rgba(86, 11, 91, 1)",
                pointHighlightFill  : "#560b5b",
                pointHighlightStroke: "rgba(86, 11, 91, 1)",
                data                : [{{$charge_amount}}]
            },
            {
                label               : "{{__('finance.refundedAmount')}}",
                fillColor           : "rgb(191, 63, 127)",
                strokeColor         : "rgb(191, 63, 127)",
                pointColor          : "#BF3F7F",
                pointStrokeColor    : "rgb(191, 63, 127)",
                pointHighlightFill  : "#BF3F7F",
                pointHighlightStroke: "rgb(191, 63, 127)",
                data                : [{{$refundable}}]
            }
            ]
        };
        var barChartCanvas   = $("#barChart").get(0).getContext("2d");
        var barChart         = new Chart(barChartCanvas);
        var RefundChart                     = ChartData;
        RefundChart.datasets[1].fillColor   = "#00a65a";
        RefundChart.datasets[1].strokeColor = "#00a65a";
        RefundChart.datasets[1].pointColor  = "#00a65a";
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
barChart.{{isset($_GET['type'])? ucwords($_GET['type']):'Line' }}(RefundChart, barChartOptions);
});
</script>
@include('./partials.pageUrl',['pageLink'=>route('refund.detail')])
@endpush
