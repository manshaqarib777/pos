@extends('layouts.report')
@section('cardTitle')
{{__('report.saleReportForm')}} {{$reportCard['time']}}
@endsection
@section('content')
<table class="table table-bordered">
    <caption>Sale Report</caption>
    <tr>
        <th scope="row" class="th-width-20"> {{__('report.soldItems')}} </th>
        <td> {{$reportCard['total_items']}}</td>
    </tr>
    <tr>
        <th scope="row">{{__('report.orders')}} </th>
        <td> {{count($reportCard['list'])}}</td>
    </tr>
    <tr>
        <th scope="row">  {{__('report.tax')}} </th>
        <td> {{$setting->currency}}{{$reportCard['tax_amount']}}</td>
    </tr>
    <tr>
        <th scope="row">  {{__('report.discount')}} </th>
        <td> {{$setting->currency}}{{$reportCard['discount']}}</td>
    </tr>
    <tr>
        <th scope="row">   {{__('report.totalSale')}} </th>
        <td>   {{$setting->currency}}{{$reportCard['total_price']}}</td>
    </tr>
    <tr>
        <th scope="row">  {{__('report.totalCashAfterDiscount')}}  </th>
        <td>  {{$setting->currency}}{{$reportCard['payable']}}</td>
    </tr>
    <tr>
        <th scope="row">  {{__('report.totalProfit')}} </th>
        <td>  {{$setting->currency}}{{$reportCard['profit']}}</td>
    </tr>
</table>
@include('partials.reports.sale',['orders'=>$reportCard['list']])
@endsection
