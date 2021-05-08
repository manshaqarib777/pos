@extends('layouts.master')
@section('title')
  {{__('manage.customer.detail')}}
@endsection

@push('breadcrumbs')
@include('./partials.breadcrumbs',['links'=> [
['url' =>route('customer.index'),'name' => __('manage.manage')],
['url' =>'','name' => __('manage.customer')],
]])
@endpush
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-body text-default">
      <div class="row">
        <div class="col-md-12">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{__('manage.information')}}</a>
              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"> {{__('manage.orders')}}</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

               @include('./partials.buttons',[
                  'allLink'=>route('customer.index'),
                  'editLink'=>route('customer.edit',$customer->id),
                  'destroyLink' =>route('customer.destroy',$customer->id)
              ])

              <table class="table table-bordered table-striped" >
                <caption> {{__('manage.created.on')}}</caption>
                <tr>
                  <th scope="row" class="th-width-20">{{__('manage.created.on')}}</th>
                  <td>{{$customer->created_at}}</td>
                </tr>
              </table>
              <table class="table table-bordered table-striped">
                <caption> {{__('manage.customer.name')}}</caption>
                <tr>
                  <th scope="row" class="th-width-20">{{__('manage.name')}}</th>
                  <td>{{$customer->name}}</td>
                </tr>
                <tr>
                  <th scope="row"> {{__('common.email')}}</th>
                  <td>{{$customer->email}}
                    | <a href="{{route('dashboard')}}/?quick-mail={{$customer->email}}" target="_blank">{{__('common.quickMail')}}</a>
                  </td>
                </tr>
                <tr>
                  <th scope="row">{{__('common.phone')}}</th>
                  <td>{{$customer->phone}}</td>
                </tr>
                <tr>
                  <th scope="row">{{__('manage.vat')}}</th>
                  <td>{{$customer->vat}}</td>
                </tr>
                <tr>
                  <th scope="row"> {{ __('common.address')}}</th>
                  <td>{{$customer->address}}</td>
                </tr>
              </table>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
              <div class="table-responsive">
                <table class="table mt-3" >
                  <caption>Sale orders</caption>
                  <thead>
                    <tr class="bg-warning">
                      <th scope="row" class="th-width-50"> {{__('manage.name')}}</th>
                      <th scope="row" class="th-width-25">{{__('common.reference')}}</th>
                      <th scope="row">{{__('common.view')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($customer->sales as $sale)
                    <tr>
                      <td>{{$sale->created_at}}</td>
                      <td>
                        {{$sale->reference}}
                      </td>
                      <td>
                        <a href="{{route('sale.show',$sale->id)}}" title="View full details">
                          <i class="fa fa-print" aria-hidden="true" ></i> Slip
                        </a> |
                        <a href="{{route('printA4',$sale->id)}}" title="View full details">
                          <i class="fa fa-print" aria-hidden="true" ></i> Invoice A4
                        </a>
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
</div>
@include('./partials.pageUrl',['pageLink'=>route('customer.index')])
@endsection
