@extends('layouts.print')
@section('title')
Print Refund Slip
@endsection
@section('content')
<div  class="m-0">
    <div class="card slip-size">
        <div class="card-body">
            @include('partials.orderInfo',['order'=>$refund])
            @include('partials.refunds.details',['refund'=>$refund])
            @include('partials.orderFooter')
        </div>
    </div>
</div>
@endsection
