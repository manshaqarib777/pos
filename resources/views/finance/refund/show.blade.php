@extends('layouts.master')
@section('title')
{{__('pos.refundOrder')}} {{$refund->reference}}
@endsection
@push('breadcrumbs')
@include('./partials.breadcrumbs',['group'=>__('pos.pos'),'links'=> [
['url' =>route('refund.index'),'name' => __('pos.refundsManagement')],
['url' =>'','name' => __('pos.refundsOrderDetail')],
]])
@endpush
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{__('pos.info')}}</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
              @section('buttons')
              <a class="btn btn-sm btn-default" title="{{__('pos.checkToPrintA4Title')}}" href="{{route('refund.printA4',$refund->id)}}" ><i class="fa fa-print fa-fw" aria-hidden="true"></i>{{__('common.print.a4')}}</a>
              <a class="btn btn-sm btn-default" title="{{__('pos.refundRecpiantPrint')}}" href="{{route('refund.print',$refund->id)}}" ><i class="fa fa-print fa-fw" aria-hidden="true"></i>{{__('common.print')}}</a>
              @endsection
              @include('./partials.buttons',[
              'allLink'=>route('refund.index'),
              'destroyLink' =>route('refund.destroy',$refund)
              ])
              @include('./partials.orderInfo',['order'=>$refund])
              <table class="table table-bordered table-striped">
                <caption>Charges info</caption>
                <tr>
                  <th scope="row" class="th-width-20">{{__('pos.refundChargeRate')}} </th>
                  <td>{{$refund->charge_rate.' %'}}</td>
                </tr>
                <tr>
                  <th scope="row">{{__('pos.chargeAmount')}}</th>
                  <td>{{$refund->charge_amount}} </td>
                </tr>
              </table>
              <table class="table table-bordered table-striped">
                <caption>Order information</caption>
                <tr>
                  <th scope="row" class="th-width-20">{{__('pos.saleOrderReference')}}</th>
                  <td>{{$refund->sale->reference}}
                    |  <a href="{{route('sale.show',$refund->sale->id)}}" target="_blank">View</a>
                  </td>
                </tr>
                <tr>
                  <th scope="row">{{__('pos.createdAt')}}</th>
                  <td>{{$refund->sale->created_at}}</td>
                </tr>
                <tr>
                  <th scope="row">{{__('pos.taxRate')}}</th>
                  <td>{{$refund->sale->order_tax.' %'}}</td>
                </tr>
                <tr>
                  <th scope="row">{{__('pos.taxAmount')}}</th>
                  <td>{{$refund->sale->tax_amount}} | Sale Order Tax collection</td>
                </tr>
                <tr>
                  <th scope="row">{{__('pos.discountRate')}}</th>
                  <td>{{$refund->sale->discount_rate}}</td>
                </tr>
                <tr>
                  <th scope="row">{{__('pos.discountAmount')}}</th>
                  <td>{{$refund->sale->discount_amount}}</td>
                </tr>
                <tr>
                  <th scope="row">{{__('pos.payable')}}</th>
                  <td>{{$refund->sale->payable}}</td>
                </tr>
              </table>
              @include('./partials.refunds.details',['refund'=>$refund,'clickAble'=>true])
              <div class="alert alert-danger"><blockquote><strong>{{__('pos.staffNote')}}</strong> <small>{{$refund->staff_note}}</small></blockquote> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('./partials.pageUrl',['pageLink'=>route('refund.index')])
@endsection
