@extends('layouts.print')
@section('title')
{{__('common.print')}} {{$sale->reference}}
@endsection
@section('content')
<div  class="col-md-auto col-sm-10 m-0">
    <div class="card">
        <div class="card-body">
            @include('./partials.orderInfo',['order'=>$sale,'a4'=>true])
            @include('./partials.sales.details',['sale'=> $sale])
            @include('./partials.orderFooter',['signature'=>true])
        </div>
    </div>
</div>
@endsection
