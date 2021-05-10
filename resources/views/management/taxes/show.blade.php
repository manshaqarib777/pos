@extends('layouts.master')
@section('title')
 {{__('manage.tax.method.detail')}}
@endsection

@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>route('tax.index'),'name' => __('manage.manage')],
['url' =>'','name' => __('manage.tax.method.detail')],
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
              <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">{{__('manage.information')}}</a>
              <a class="nav-item nav-link" id="nav-orders-tab" data-toggle="tab" href="#nav-orders" role="tab" aria-controls="nav-orders" aria-selected="false">{{__('manage.purchases')}}</a>
              <a class="nav-item nav-link" id="nav-products-tab" data-toggle="tab" href="#nav-products" role="tab" aria-controls="nav-products" aria-selected="false">{{__('manage.products')}}</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
               @include('partials.buttons',[
                  'allLink'=>route('tax.index'),
                  'editLink'=>route('tax.edit',$tax->id),
                  'destroyLink' =>route('tax.destroy',$tax->id)
              ])
              <table class="table table-bordered table-striped" >
                <caption>Tax information </caption>
                <tr>
                  <th scope="row" class="th-width-20">{{__('manage.created.on')}}</th>
                  <td>{{$tax->created_at}}</td>
                </tr>
              </table>
              <table class="table table-bordered table-striped" >
                <caption>Tax detail </caption>
                <tr>
                  <th scope="row" class="th-width-20"> {{__('manage.title')}}</th>
                  <td>{{$tax->name}}</td>
                </tr>
                <tr>
                  <th scope="row">{{__('manage.short.code')}}</th>
                  <td>{{$tax->code}}</td>
                </tr>
                <tr>
                  <th scope="row">{{__('manage.rate')}}</th>
                  <td>{{$tax->rate}}</td>
                </tr>

              </table>
            </div>
            <div class="tab-pane fade" id="nav-orders" role="tabpanel" aria-labelledby="nav-orders-tab">
             @include('partials.purchases.orders',['orders'=>$tax->purchases])
            </div>
            <div class="tab-pane fade" id="nav-products" role="tabpanel" aria-labelledby="nav-products-tab">
             @include('partials.products.list',['products'=>$tax->products])
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@include('partials.pageUrl',['pageLink'=>route('tax.index')])
