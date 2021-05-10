@extends('layouts.master')
@section('title')
{{__('finance.annuallySaleChartSummary')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['group'=>__('finance.finance'),'links'=> [
['url' =>'','name' => __('finance.saleChart')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="row row-card-no-pd bg-default mb-1">
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col col-stats">
                            <div class="numbers">
                                <p class="card-category">{{__('finance.saleChart')}}</p>
                                <h4 class="card-title">{{$saleData['orders']}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col col-stats" title="{{__('finance.lpi')}}">
                            <div class="numbers">
                                <p class="card-category">{{__('finance.lpi')}}</p>
                                <h4 class="card-title">{{$setting->currency}}{{$saleData['lowPricing']}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col col-stats">
                            <div class="numbers">
                                <p class="card-category">{{__('finance.netProfit')}}</p>
                                <h4 class="card-title">{{$setting->currency}}{{$saleData['profit']}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-card-no-pd bg-default mb-1">
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col col-stats">
                            <div class="numbers">
                                <p class="card-category"> {{__('finance.tax')}}</p>
                                <h4 class="card-title">{{$setting->currency}}{{$saleData['tax']}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col col-stats">
                            <div class="numbers">
                                <p class="card-category">{{__('finance.sales')}}</p>
                                <h4 class="card-title">{{$setting->currency}}{{$saleData['sale']}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col col-stats">
                            <div class="numbers">
                                <p class="card-category">{{__('finance.discount')}}</p>
                                <h4 class="card-title">{{$setting->currency}}{{$saleData['discount']}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card bg-default">
        <div class="card-header">
            <div class="btn-group float-right">
                <a href="{{route('sale.detail')}}?type=bar" class="btn btn-xs text-warning"><i class="fa fa-chart-bar" aria-hidden="true"></i> {{__('finance.barView')}}</a>
                <a href="{{route('sale.detail')}}?type=line" class="btn btn-xs text-warning"><i class="fa fa-chart-line" aria-hidden="true"></i> {{__('finance.lineView')}}</a>
            </div>
            <h4 class="card-title text-warning">
                {{__('finance.saleChartForYear')}} {{date('Y')}}
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
                fillColor           : "rgb(222, 222, 16)",
                strokeColor         : "rgb(222, 222, 16)",
                pointColor          : "rgb(222, 222, 16)",
                pointStrokeColor    : "#DEDE10",
                pointHighlightFill  : "#DEDE10",
                pointHighlightStroke: "rgb(222, 222, 16)",
                data                : [{{$orders}}]
            },
            {
                label               : "{{__('finance.profitInKilo')}}",
                fillColor           : "rgb(99, 222, 16)",
                strokeColor         : "rgb(99, 222, 16)",
                pointColor          : "rgb(99, 222, 16)",
                pointStrokeColor    : "#63DE10",
                pointHighlightFill  : "#63DE10",
                pointHighlightStroke: "rgb(99, 222, 16)",
                data                : [{{$profit}}]
            },
            {
                label               : "{{__('finance.taxInKilo')}}",
                fillColor           : "rgb(228, 53, 47)",
                strokeColor         : "rgb(228, 53, 47)",
                pointColor          : "#E4352F",
                pointStrokeColor    : "rgb(228, 53, 47)",
                pointHighlightFill  : "#E4352F",
                pointHighlightStroke: "rgb(228, 53, 47)",
                data                : [{{$tax_amount}}]
            },
            {
                label               : "{{__('finance.saleInKilo')}}",
                fillColor           : "rgb(47, 188, 228)",
                strokeColor         : "rgb(47, 188, 228)",
                pointColor          : "#2FBCE4",
                pointStrokeColor    : "rgb(47, 188, 228)",
                pointHighlightFill  : "#2FBCE4",
                pointHighlightStroke: "rgba(121, 107, 0, 1)",
                data                : [{{$sale}}]
            },
            {
                label               : "{{__('finance.discountInKilo')}}",
                fillColor           : "rgb(228, 47, 188)",
                strokeColor         : "rgb(228, 47, 188)",
                pointColor          : "#E42FBC",
                pointStrokeColor    : "rgb(228, 47, 188)",
                pointHighlightFill  : "#E42FBC",
                pointHighlightStroke: "rgb(228, 47, 188)",
                data                : [{{$discount}}]
            },
            ]
        };
        var barChartCanvas     = $("#barChart").get(0).getContext("2d");
        var barChart           = new Chart(barChartCanvas);
        var SaleChart                     = ChartData;
        SaleChart.datasets[1].fillColor   = "#00a65a";
        SaleChart.datasets[1].strokeColor = "#00a65a";
        SaleChart.datasets[1].pointColor  = "#00a65a";
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
barChart.{{isset($_GET['type'])? ucwords($_GET['type']):'Line' }}(SaleChart, barChartOptions);
});
</script>
@include('partials.pageUrl',['pageLink'=>route('sale.detail')])
@endpush
