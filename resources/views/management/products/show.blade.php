@extends('layouts.master')
@section('title')
 {{__('manage.product.detail')}} {{$product->code}}
@endsection

@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>route('product.index'),'name' => __('manage.manage')],
['url' =>'','name' => __('manage.product.detail')],
]])
@endpush
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-body text-default">
      <div class="row mb-3">
        <div class="col-md-12">
          <h1>
          {{__('manage.name')}} {{$product->name}}
          </h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 text-center">
          <div class="p-2">
            <img title="{{$product->code}}" src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->code,$product->barcode_symbology)}}" alt="barcode" class="barcode-200w-60h" /><br>
            <small>{{$product->code}}</small>
          </div>
          <hr>
          @include('partials.upload',[
          'routeLink'=>route('product.image'),
          'nameId'=>'product_id',
          'item'=> $product]
          )
          <h3>{{__('manage.product.description')}}</h3>
          <div class="text-justify p-2">
            {{$product->product_details}}
          </div>
          </div> <!-- product.label -->
          <div class="col-md-8">
            @section('buttons')
            @include('partials.products.labelModel',['item'=>$product])
            @endsection
            @include('partials.buttons',[
            'allLink'=>route('product.index'),
            'editLink'=>route('product.edit',$product->id),
            'destroyLink' =>route('product.destroy',$product->id)
            ])
            <table class="table table-bordered table-striped">
              <caption> {{__('manage.product.details')}}</caption>
              <tr>
                <th scope="row" class="th-width-25"> {{__('manage.added.on')}}</th>
                <td>{{$product->created_at}}</td>
              </tr>
              <tr>
                <th scope="row"> {{__('manage.sale.status')}}</th>
                <td>
                  @if($product->status == '0')
                  <i class="fa fa-times" aria-hidden="true"></i> {{__('common.deactivate')}}
                  @else
                  <i class="fa fa-check-circle" aria-hidden="true"></i> {{__('common.active')}}
                  @endif
                </td>
              </tr>
              <tr>
                <th scope="row"> {{__('manage.discount')}}</th>
                <td>
                  @if($product->discountable == '0')
                  <i class="fa fa-times" aria-hidden="true"></i>  {{__('common.disallow')}}
                  @else
                  <i class="fa fa-check-circle" aria-hidden="true"></i> {{__('common.allow')}}
                  @endif
                </td>
              </tr>
            </table>
            <table class="table table-bordered" >
              <caption>{{__('manage.pricing')}}</caption>
              <tr>
                <th scope="row" class="th-width-25"> {{__('manage.unit.cost')}}</th>
                <td>{{$product->cost}}</td>
                <th scope="row" class="th-width-25">{{__('manage.unit.price')}}</th>
                <td>{{$product->price}}</td>
              </tr>
            </table>
            <table class="table table-bordered table-striped">
              <caption>Stock</caption>
              <tr>
                <th scope="row" class="th-width-25"> {{__('manage.stock.quantity')}}</th>
                <td>{{$product->qty}}</td>
                <th scope="row" class="th-width-25"> {{__('manage.low.alert.quantity')}}</th>
                <td>{{$product->alert_quantity}}</td>
              </tr>
              <tr>
                <th scope="row">{{__('manage.unit')}}</th>
                <td>{{$product->unit}}</td>
                <th scope="row"> {{__('manage.sold.item')}}</th>
                <td>{{$product->sold_out}}</td>
              </tr>
            </table>
            <table class="table table-bordered table-striped" >
              <caption>Product info</caption>
              <tr>
                <th scope="row" class="th-width-25">{{__('manage.product.code')}}</th>
                <td>{{$product->code}}</td>
                <th scope="row" class="th-width-25">{{__('manage.symbology')}}</th>
                <td>{{$product->barcode_symbology}}</td>
              </tr>
              <tr>
                <th scope="row"> {{__('manage.expiry.date')}}</th>
                <td>{{$product->expiry_date}}</td>
                <th scope="row">{{__('manage.manufacturing.date')}}</th>
                <td>{{$product->manufacturing_date}}</td>
              </tr>
            </table>
            <table class="table table-bordered">
              <caption>Category & Sub category info</caption>
              <tr>
                <th scope="row" class="th-width-25">{{__('manage.main.category')}}</th>
                <td>{{$product->category->name}}
                  <a title="{{__('common.view.info')}}" href="{{route('category.show',$product->category->id)}}">
                    <i class="fa fa-link" aria-hidden="true"></i>
                  </a>
                </td>
              </tr>
              @if($product->subcategory)
              <tr>
                <th scope="row" class="th-width-25"> {{__('manage.subcategory')}}</th>
                <td>{{$product->subcategory->name}}
                  <a title="{{__('common.view.info')}}" href="{{route('category.show',$product->subcategory->id)}}">
                    <i class="fa fa-link" aria-hidden="true"></i>
                  </a>
                </td>
              </tr>
              @endif
            </table>
            <table class="table table-bordered table-striped">
              <caption>Supplier $ warehouse</caption>
              <tr>
                <th scope="row">{{__('manage.supplier')}}</th>
                <td>{{$product->supplier->name}}
                  <a title="{{__('common.view.info')}}" href="{{route('supplier.show',$product->supplier->id)}}">
                    <i class="fa fa-link" aria-hidden="true"></i>
                  </a>
                  | <a href="{{route('dashboard')}}/?quick-mail={{$product->supplier->email}}" target="_blank">{{__('common.quickMail')}}</a>
                </td>
              </tr>
              <tr>
                <th scope="row"> {{__('manage.warehouse')}}</th>
                <td>{{$product->warehouse->name}}
                  <a title="{{__('common.view.info')}}" href="{{route('warehouse.show',$product->warehouse->id)}}">
                    <i class="fa fa-link" aria-hidden="true"></i>
                  </a>
                  | <a href="{{route('dashboard')}}/?quick-mail={{$product->warehouse->email}}" target="_blank">{{__('common.quickMail')}}</a>
                </td>
              </tr>
            </table>
            <table class="table table-bordered table-striped">
              <caption>Product side effects</caption>
              <tr>
                <th scope="row">{{__('manage.side.effects')}}</th>
                <td>{{$product->side_effects}}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('partials.pageUrl',['pageLink'=>route('product.index')])
  @endsection
