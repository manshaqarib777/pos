@extends('layouts.master')
@section('title')
{{__('dash.dashboard')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>'','name' => __('dash.dashboard')],
]])
@endpush
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row row-card-no-pd mb-1 bg-default">
                @include('partials.dashboard',['title' => $dashboard['products'], 'heading'=>__('dash.totalProducts')])
                @include('partials.dashboard',['title' => $dashboard['Items'], 'heading'=>__('dash.totalItems')])
                @include('partials.dashboard',['title' => $dashboard['sales'], 'heading'=>__('dash.totalSales')])
                @include('partials.dashboard',['title' => $dashboard['refunds'], 'heading'=>__('dash.totalRefunds')])
            </div>
        </div>
    </div>
    <div class="card mb-1">
        <div class="card-header p-1 bg-default">
           <h4 class="card-title text-center text-white">
            {{__('dash.dailySaleChartFor')}} <strong>{{Date('M Y')}}</strong>
        </h4>
    </div>
    <div class="card-header p-1 pl-3">

        <div class="btn-group" data-toggle="tooltip" title="{{__('dash.YearlyChartsSummaries')}}">
            <a href="{{route('sale.detail')}}" class="btn-sm btn-link">{{__('dash.sales')}}</a>
            <a href="{{route('purchase.detail')}}" class="btn-sm btn-link">{{__('dash.cost')}}</a>
            <a href="{{route('expense.detail')}}" class="btn-sm btn-link"> {{__('dash.expenses')}}</a>
            <a href="{{route('tax.detail')}}" class="btn-sm btn-link">{{__('dash.taxes')}}</a>
            <a href="{{route('refund.detail')}}" class="btn-sm btn-link">{{__('dash.refunds')}}</a>
        </div>
        <div class="btn-group float-right" data-toggle="tooltip" title="{{__('dash.toggleChartType')}}">
            <a href="{{route('dashboard')}}?type=bar" class="btn btn-xs">
                <i class="fa fa-chart-bar" aria-hidden="true"></i> {{__('dash.barChartView')}}
            </a>
            <a href="{{route('dashboard')}}?type=line" class="btn btn-xs">
                <i class="fa fa-chart-line" aria-hidden="true"></i> {{__('dash.lineChartView')}}
            </a>
        </div>

    </div>
    <div class="card-body" data-toggle="tooltip" title="{{__('dash.dailySaleOrderAndSaleAmountInkillo')}}">
        <canvas id="barChart" ></canvas>
    </div>
    <div class="card-footer p-1" data-toggle="tooltip" title="{{__('dash.quickLinks')}}">
        <div class="p-0">
            <a href="{{route('product.create')}}" class="btn btn-sm">{{__('dash.addProduct')}}</a>
            <a href="{{route('supplier.create')}}" class="btn btn-sm">{{__('dash.newSupplier')}}</a>
            <a href="{{route('customer.create')}}" class="btn btn-sm">{{__('dash.newCustomer')}}</a>
            <a href="{{route('tax.create')}}" class="btn btn-sm">{{__('dash.defineNewTax')}}</a>
            <a href="{{route('expense.create')}}" class="btn btn-sm">{{__('dash.addExpense')}}</a>
            <a href="{{route('purchase.create')}}" class="btn btn-sm">{{__('dash.makePurchase')}}</a>
            <a href="{{route('payment.create')}}" class="btn btn-sm">{{__('dash.newPaymentGateway')}}</a>
            <a href="{{route('warehouse.create')}}" class="btn btn-sm">{{__('dash.newWarehouse')}}</a>
            <a href="{{route('register')}}" class="btn btn-sm">{{__('dash.createNewUser')}}</a>
        </div>
    </div>
</div>
<div class="row row-card-no-pd mt-0 mb-1" data-toggle="tooltip" title="{{__('dash.clickOnValuesForMoreInformation')}}">
    @include('partials.dashboard',['link'=>route('customer.index'),
    'title' => $dashboard['customers'], 'heading'=>__('dash.customers'),'class'=>'col-md-2'])

    @include('partials.dashboard',['link'=>route('supplier.index'),
    'title' => $dashboard['suppliers'], 'heading'=>__('dash.suppliers'),'class'=>'col-md-2'])

    @include('partials.dashboard',['link'=>route('purchase.index'),
    'title' => $dashboard['purchases'], 'heading'=>__('dash.purchases'),'class'=>'col-md-2'])

    @include('partials.dashboard',['link'=>route('expense.index'),
    'title' => $dashboard['expenses'], 'heading'=>__('dash.expenses'),'class'=>'col-md-2'])

    @include('partials.dashboard',['link'=>route('warehouse.index'),
    'title' => $dashboard['warehouses'], 'heading'=>__('dash.warehouses'),'class'=>'col-md-2'])

    @include('partials.dashboard',['link'=>route('user.index'),
    'title' => $dashboard['users'], 'heading'=>__('dash.users'),'class'=>'col-md-2'])

</div>
<div class="card mb-1">
    <div class="row p-2">
        <div class="col-md-6 text-success pr-0">
            <h2>{{__('dash.Last10Sales')}}</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <caption>Sale Order</caption>
                    <thead class="bg-success">
                        <tr>
                            <th scope="row" class="th-width-25">{{__('dash.timeReference')}}</th>
                            <th scope="row" class="th-width-25">{{__('dash.saleReference')}}</th>
                            <th scope="row" class="th-width-10">{{__('dash.Qty')}}</th>
                            <th scope="row" class="th-width-35">{{__('dash.amount')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dashboard['lastSales'] as $sale)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($sale->created_at)->diffForHumans() }}<h6>{{$sale->reference}}</h6>
                            </td>
                            <td>
                                <img title="{{$sale->reference}}" src="data:image/png;base64,{{DNS1D::getBarcodePNG($sale->reference, 'C128A')}}" alt="barcode" class="barcode-150w-20h" />
                            </td>
                            <td>
                                {{$sale->total_items}}
                            </td>
                            <td>
                                {{round($sale->payable,2)}}
                                <sub data-toggle="tooltip" title="{{__('dash.lowPriceIndex')}}">{{$sale->lowPricing}}</sub>
                                @if($sale->order_profit > 0)
                                <sup class="text-success" data-toggle="tooltip" title="{{__('dash.orderProfit')}}">P: {{$sale->order_profit}}</sup>
                                @else
                                <sup class="text-danger" data-toggle="tooltip" title="{{__('dash.orderInLoss')}}" >L: {{$sale->order_profit}}</sup>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6 text-danger pl-1">
            <h2>{{__('dash.last10Refunds')}}</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <caption>Refund Orders</caption>
                    <thead class="bg-danger">
                        <tr>
                            <th scope="row" class="th-width-25">{{__('dash.timeReference')}}</th>
                            <th scope="row" class="th-width-25">{{__('dash.refundReference')}}</th>
                            <th scope="row" class="th-width-10">{{__('dash.Qty')}}</th>
                            <th scope="row" class="th-width-35">{{__('dash.refunded')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dashboard['lastRefunds'] as $refund)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($refund->created_at)->diffForHumans() }}<h6>{{$refund->reference}}</h6>
                            </td>
                            <td>
                                <img title="{{$refund->reference}}" src="data:image/png;base64,{{DNS1D::getBarcodePNG($refund->reference, 'C128A')}}" alt="barcode" class="barcode-150w-20h" />
                            </td>
                            <td>
                                {{$refund->return_items}}
                            </td>
                            <td>
                                {{round($refund->refundable,2)}}
                                <sup title="{{__('dash.refundPlantyCharges')}}">{{$refund->charge_amount}}</sup>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card card-default">
    <div class="card-body">
        <div class="col-md-12">
            @if($dashboard['opendChapters']->count())
            <table class="table">
                <caption>Chapter Information</caption>
                <thead class="bg-warning">
                    <tr>
                        <th scope="row" class="text-white">{{__('dash.openedChapters')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dashboard['opendChapters'] as $key => $chapter)
                    <tr>
                        <td class="text-white">
                         {{$key+1}} <strong> - {{$chapter->key}}</strong>  | {{$chapter->user->name}} | {{__('dash.saleOrders')}} : {{$chapter->sale_orders}} | {{__('dash.refundedOrders')}} : {{$chapter->refund_orders}} | <a href="{{route('chapter.show',$chapter)}}" class="p-0 btn-sm btn-link">{{__('common.view')}}</a>
                     </td>
                 </tr>
                 @endforeach
             </tbody>
         </table>
         @else
         <div class="text-center p-5">
            <h1 class="text-white">{{__('dash.notFoundOpenedChapter')}}</h1>
            <p> {{__('dash.click')}} <a href="{{route('chapter.create')}}">{{__('dash.here')}}</a> {{__('dash.toOpenNewChapter')}}.</p>
        </div>
        @endif
    </div>
</div>
</div>
</div>
@endsection
@push('script')
<script  src="{{asset('js/plugin/chart.js/chart.min.js')}}"></script>
<script>
    "use strict";
    $(function () {
        var ChartData = {
            labels  : [{{$days}}],
            datasets: [
            {
                label               : "{{__('dash.orders')}}",
                fillColor           : "rgb(191, 127, 63)",
                strokeColor         : "rgb(191, 127, 63)",
                pointColor          : "#BF7F3F",
                pointStrokeColor    : "rgb(191, 127, 63)",
                pointHighlightFill  : "#BF7F3F",
                pointHighlightStroke: "rgb(191, 127, 63)",
                data                :  [{{$orders}}]
            },
            {
                label               : "{{__('dash.amountInKilo')}}",
                fillColor           : "rgb(63, 191, 127)",
                strokeColor         : "rgb(63, 191, 127)",
                pointColor          : "#3FBF7F",
                pointStrokeColor    : "rgb(63, 191, 127)",
                pointHighlightFill  : "#3FBF7F",
                pointHighlightStroke: "rgb(63, 191, 127)",
                data                :  [{{$payable}}]
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
scaleShowHorizontalLines: false,
//Boolean - Whether to show vertical lines (except Y axis)
scaleShowVerticalLines  : false,
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
maintainAspectRatio     : false
};
barChartOptions.datasetFill = false;
barChart.{{isset($_GET['type'])? ucwords($_GET['type']):'Line' }}(ExpenseChart, barChartOptions);
});
</script>
@include('partials.pageUrl',['pageLink'=>route('dashboard')])
@endpush
