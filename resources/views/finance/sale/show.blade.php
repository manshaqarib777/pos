@extends('layouts.master')
@section('title')
{{__('pos.saleOrder')}} {{$sale->reference}}
@endsection
@push('breadcrumbs')
@include('./partials.breadcrumbs',['group'=>__('pos.pos'),'links'=> [
['url' =>route('sale.index'),'name' => __('pos.salesManagement')],
['url' =>'','name' => __('pos.saleOrderDetail')],
]])
@endpush
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-body text-default">
      <div class="row mb-3">
        <div class="col-md-12">
          <h1 class="text-success">
          <i class="fa fa-check-circle fa-fw" aria-hidden="true"></i>{{$sale->reference}}
          </h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="sale-info-tab" data-toggle="tab" href="#sale-info" role="tab" aria-controls="sale-info" aria-selected="true">{{__('pos.saleOrderInformation')}}</a>
              <a class="nav-item nav-link" id="nav-refund-tab" data-toggle="tab" href="#nav-refund" role="tab" aria-controls="nav-refund" aria-selected="true">{{__('pos.refunds')}}</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="sale-info" role="tabpanel" aria-labelledby="sale-info-tab">
              @section('buttons')
              <a class="btn btn-sm btn-default" title="{{__('common.print.a4')}}" href="{{route('printA4',$sale->id)}}" ><i class="fa fa-print fa-fw" aria-hidden="true"></i>{{__('common.print.a4')}}</a>
              <a class="btn btn-sm btn-default" title="{{__('common.print')}}" href="{{route('print',$sale->id)}}" ><i class="fa fa-print fa-fw" aria-hidden="true"></i>{{__('common.print')}}</a>
              @endsection
              @include('./partials.buttons',[
              'allLink'=>route('sale.index'),
              'destroyLink' =>route('sale.destroy',$sale)
              ])
              @include('./partials.orderInfo',['order'=>$sale])
              <table class="table table-bordered table-striped">
                <caption>Sale Order Profit</caption>
                <tr>
                  <th scope="row" class="th-width-20">{{__('pos.orderGain')}}: </th>
                  <td>
                    {{$sale->order_profit < 0 ? $sale->order_profit.' '.__('pos.loss'):$sale->order_profit.' '.__('pos.profit')}}
                  </td>
                </tr>
                <tr>
                  <th scope="row">{{__('pos.priceModified')}}</th>
                  <td>{{ucwords($sale->lowPricing > 0 ? __('common.yes'): __('common.no') )}} </td>
                </tr>
                <tr>
                  <th scope="row">{{__('pos.lpi')}}</th>
                  <td>{{$sale->lowPricing}} </td>
                </tr>
              </table>
              @include('./partials.sales.details',['sale'=>$sale,'links'=>true])
              <div class="alert-info p-2">
                <strong>{{__('pos.staffNote')}}</strong>
                <small>{{$sale->staff_note}}</small>
              </div>
            </div>
            <div class="tab-pane" id="nav-refund" role="tabpanel" aria-labelledby="nav-refund-tab">
              <table class="table mt-2">
                <caption>Refund Orders</caption>
                <thead class="bg-danger">
                  <tr>
                    <th scope="row" class="th-width-50">{{__('common.reference')}}</th>
                    <th scope="row" class="th-width-10">{{__('pos.returnItems')}} </th>
                    <th scope="row" class="th-width-10">{{__('pos.charge')}}</th>
                    <th scope="row" class="th-width-10">{{__('pos.action')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($sale->refunds as $refund)
                  <tr>
                    <td>{{$refund->reference}}</td>
                    <td>{{$refund->return_items}}</td>
                    <td>{{$refund->charge_amount}}</td>
                    <td>
                      <a href="{{route('refund.show',$refund->id)}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('./partials.pageUrl',['pageLink'=>route('sale.index')])

@endsection
