@extends('layouts.master')
@section('title')
{{__('entries.new.purchase.order')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['group'=>__('entries.entries'),'links'=> [
['url' =>'','name' => __('entries.make.Purchase')],
]])
@endpush
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <div class="">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{__('entries.bySupplierPurchase')}}</a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active p-3" id="home" role="tabpanel" aria-labelledby="home-tab">
            <new-purchase-std v-bind:suppliers="{{$suppliers}}" v-bind:taxes="{{$taxes}}"></new-purchase-std>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
