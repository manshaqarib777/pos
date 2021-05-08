@extends('layouts.report')
@section('cardTitle')
{{__('report.taxCalculatedFrom')}} {{$reportCard['time']}}
@endsection
@section('content')
<table class="table table-bordered">
    <caption>tax report</caption>
    <tr>
        <th scope="row" class="th-width-20">{{__('report.walkinSaleTax')}}</th>
        <td> {{$setting->currency}}{{$reportCard['walkin']}}</td>
    </tr>
    <tr>
        <th scope="row">{{__('report.walkinRefundTaxFall')}}</th>
        <td> {{$setting->currency}}{{$reportCard['walkinRefund']}}</td>
    </tr>
    <tr>
        <th scope="row">{{__('report.totalWalkinTax')}}</th>
        <td> {{$setting->currency}}{{$reportCard['walkinNet']}}</td>
    </tr>
</table>
<table class="table table-bordered">
    <caption>Customer Type</caption>
    <tr>
        <th scope="row" class="th-width-20">{{__('report.customerSaleTax')}}</th>
        <td> {{$setting->currency}}{{$reportCard['customer']}}</td>
    </tr>
    <tr>
        <th scope="row">{{__('report.customerRefundTaxFall')}}</th>
        <td> {{$setting->currency}}{{$reportCard['customerRefund']}}</td>
    </tr>
    <tr>
        <th scope="row">{{__('report.totalCustomerTax')}}</th>
        <td> {{$setting->currency}}{{$reportCard['customerNet']}}</td>
    </tr>
</table>
<table class="table table-bordered">
    <caption>Total tac</caption>
    <tr>
        <th scope="row" class="th-width-20">{{__('report.saleTaxCollection')}}</th>
        <td> {{$reportCard['saleTax']}}</td>
    </tr>
    <tr>
        <th scope="row">{{__('report.purchaseTax')}}</th>
        <td> {{$reportCard['purchase']}}</td>
    </tr>
</table>
@endsection
