@extends('layouts.print')
@section('title')
 {{__('pos.printSaleSlip')}}
@endsection
@section('content')
<div  class="m-0">
    <div class="card slip-size">
        <div class="card-body">
            @include('./partials.orderInfo',['order'=>$sale])
            @include('./partials.sales.details',['sale'=>$sale])
            @include('./partials.orderFooter')
        </div>
    </div>
</div>
@endsection
