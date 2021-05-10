@extends('layouts.master')
@section('title')
   {{__('manage.warehouse.detail')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>route('warehouse.index'),'name' => __('manage.manage')],
['url' =>'','name' => __('manage.warehouse.detail')],
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
              <a class="nav-item nav-link active" id="wh-info-tab" data-toggle="tab" href="#wh-info" role="tab" aria-controls="wh-info" aria-selected="true">{{__('manage.information')}}</a>
              <a class="nav-item nav-link" id="warehouse-products-tab" data-toggle="tab" href="#warehouse-products" role="tab" aria-controls="warehouse-products" aria-selected="false">{{__('manage.products')}}</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="wh-info" role="tabpanel" aria-labelledby="wh-info-tab">
              @include('partials.buttons',[
                  'allLink'=>route('warehouse.index'),
                  'editLink'=>route('warehouse.edit',$warehouse->id),
                  'destroyLink' =>route('warehouse.destroy',$warehouse->id)
              ])
              <table class="table table-bordered table-striped" >
                <caption>Registered at</caption>
                <tr>
                  <th scope="row" class="th-width-10">{{__('manage.created.on')}}</th>
                  <td>{{$warehouse->created_at}}</td>
                </tr>
              </table>
              <table class="table table-bordered table-striped" >
                <caption>Warehouse details</caption>
                <tr>
                  <th scope="row" class="th-width-10">{{__('manage.name')}}</th>
                  <td>{{$warehouse->name}}</td>
                </tr>
                <tr>
                  <th scope="row">{{__('manage.code')}}</th>
                  <td>{{$warehouse->code}}</td>
                </tr>
                <tr>
                  <th scope="row"> {{__('common.email')}}</th>
                  <td>{{$warehouse->email}}
                    | <a href="{{route('dashboard')}}/?quick-mail={{$warehouse->email}}" target="_blank">{{__('common.quickMail')}}</a>
                  </td>
                </tr>
                <tr>
                  <th scope="row">{{__('common.phone')}}</th>
                  <td>{{$warehouse->phone}}</td>
                </tr>
                <tr>
                  <th scope="row">{{__('common.address')}}</th>
                  <td>{{$warehouse->address}}</td>
                </tr>
              </table>
            </div>
            <div class="tab-pane fade" id="warehouse-products" role="tabpanel" aria-labelledby="warehouse-products-tab">
                 @include('partials.products.list',['products'=>$warehouse->products])
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('partials.pageUrl',['pageLink'=>route('warehouse.index')])
@endsection
