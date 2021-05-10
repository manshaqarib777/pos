@extends('layouts.master')
@section('title')
  {{__('manage.supplier.detail')}}
@endsection

@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>route('supplier.index'),'name' => __('manage.manage')],
['url' =>'','name' => __('manage.supplier.detail')],
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
              <a class="nav-item nav-link active" id="supplier-info-tab" data-toggle="tab" href="#supplier-info" role="tab" aria-controls="supplier-info" aria-selected="true">{{__('manage.information')}}</a>
              <a class="nav-item nav-link" id="supplier-orders-tab" data-toggle="tab" href="#supplier-orders" role="tab" aria-controls="supplier-orders" aria-selected="false">{{__('manage.purchases')}}</a>
              <a class="nav-item nav-link" id="supplier-products-tab" data-toggle="tab" href="#supplier-products" role="tab" aria-controls="supplier-products" aria-selected="false">{{__('manage.products')}}</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="supplier-info" role="tabpanel" aria-labelledby="supplier-info-tab">
              @include('partials.buttons',[
                  'allLink'=>route('supplier.index'),
                  'editLink'=>route('supplier.edit',$supplier->id),
                  'destroyLink' =>route('supplier.destroy',$supplier->id)
              ])
              <table class="table table-bordered table-striped" >
                <caption>Supplier information</caption>
                <tr>
                  <th scope="row" class="th-width-20">{{__('manage.created.on')}}</th>
                  <td>{{$supplier->created_at}}</td>
                </tr>
              </table>
              <table class="table table-bordered table-striped">
                <caption>Supplier details</caption>
                <tr>
                  <th scope="row" class="th-width-20">{{__('manage.name')}}</th>
                  <td>{{$supplier->name}}</td>
                </tr>
                <tr>
                  <th scope="row">{{__('manage.email')}}</th>
                  <td>{{$supplier->email}}
                    | <a href="{{route('dashboard')}}/?quick-mail={{$supplier->email}}" target="_blank">{{__('common.quickMail')}}</a>
                  </td>
                </tr>
                <tr>
                  <th scope="row">{{__('common.phone')}}</th>
                  <td>{{$supplier->phone}}</td>
                </tr>
                <tr>
                  <th scope="row"> {{__('common.company')}}</th>
                  <td>{{$supplier->company}}</td>
                </tr>
                <tr>
                  <th scope="row">{{__('manage.vat')}}</th>
                  <td>{{$supplier->vat}}</td>
                </tr>
                <tr>
                  <th scope="row"> {{__('common.address')}}</th>
                  <td>{{$supplier->address}}</td>
                </tr>
              </table>
            </div>
            <div class="tab-pane fade" id="supplier-orders" role="tabpanel" aria-labelledby="supplier-orders-tab">
              @include('partials.purchases.orders',['orders'=>$supplier->purchases])
            </div>
            <div class="tab-pane fade" id="supplier-products" role="tabpanel" aria-labelledby="supplier-products-tab">
              @include('partials.products.list',['products'=>$supplier->products])
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@include('partials.pageUrl',['pageLink'=>route('supplier.index')])
