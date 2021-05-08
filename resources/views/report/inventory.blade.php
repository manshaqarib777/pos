@extends('layouts.master')
@section('title')
{{__('report.stockInventoryReport')}}
@endsection
@push('breadcrumbs')
@include('./partials.breadcrumbs',['group'=>__('report.reports'),'links'=> [
['url' =>'','name' => __('report.inventoryAlerts')],
]])
@endpush
@section('content')
<div class="col-md-12">
  <div class="row row-card-no-pd mb-1">
    <div class="col-sm-6 col-md-6">
      <div class="card card-stats card-round">
        <div class="card-body ">
          <div class="row">
            <div class="col-5">
              <div class="icon-big text-center">
                <i class="fa fa-box text-warning" aria-hidden="true"></i>
              </div>
            </div>
            <div class="col col-stats">
              <div class="numbers">
                <p class="card-category">{{__('report.outOfStockProducts')}}</p>
                <h4 class="card-title">
                  {{$products->count()}}
                </h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-md-6">
      <div class="card card-stats card-round">
        <div class="card-body ">
          <div class="row">
            <div class="col-5">
              <div class="icon-big text-center">
                <i class="fa fa-print text-success" aria-hidden="true"></i>
              </div>
            </div>
            <div class="col col-stats">
              <div class="numbers">
                <h4 class="card-title">
                  <a href="{{route('product.inventory')}}?print=yes" target="_blank">
                    {{__('common.print')}}
                  </a>
                </h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <h4 class="card-title text-danger">
        {{__('report.inventoryReport')}}
      </h4>
    </div>
    <div class="card-body">
      <a href="{{route('product.inventory')}}?print=yes" target="_blank">
        <i class="fa fa-print" aria-hidden="true"></i> {{__('common.print')}}
      </a>
      <div class="table-responsive">
        @include('./partials.reports.inventory',['products'=>$products])
      </div>
    </div>
  </div>
</div>
@endsection
