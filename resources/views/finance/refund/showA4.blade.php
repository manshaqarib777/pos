@extends('layouts.print')
@section('content')
<div  class="col-sm-12 m-0">
  <div class="card">
    <div class="card-body">
     @include('partials.orderInfo',['a4'=>true ,'order'=>$refund])
     @include('partials.refunds.details',['refund'=>$refund])
     @include('partials.orderFooter',['signature' => true ])
    </div>
  </div>
</div>
@endsection

