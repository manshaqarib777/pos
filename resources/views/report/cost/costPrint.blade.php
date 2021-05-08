@extends('layouts.report')
@section('cardTitle')
{{__('report.costCalculatedFrom')}} {{$reportCard['time']}}
@endsection
@section('content')
<table class="table table-bordered" >
    <caption>Cost report</caption>
    <tr>
        <th scope="row" class="th-width-20"> {{__('report.netCost')}}</th>
        <td>{{$setting->currency}}{{$reportCard['total_cost']}}</td>
        <th scope="row">{{__('report.qtyPurchased')}}:</th>
        <td>{{$reportCard['total_qty']}}</td>
    </tr>
    <tr>
        <th scope="row">  {{__('report.shippingAmount')}}</th>
        <td>{{$setting->currency}}{{$reportCard['shipping']}}</td>
        <th scope="row"> {{__('report.includedTax')}}:</th>
        <td>{{$setting->currency}}{{$reportCard['tax_amount']}}</td>
    </tr>
    <tr>
        <th scope="row"> {{__('report.discount')}}</th>
        <td>{{$setting->currency}}{{$reportCard['off_amount']}}</td>
        <th scope="row">{{__('report.taxAmountExcludedShipping')}}</th>
        <td>{{$setting->currency}}{{$reportCard['total_payment']}}</td>
    </tr>
</table>
@include('./partials.reports.cost',['purchaseOrders'=>$reportCard['list']])
@endsection
