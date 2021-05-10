@extends('layouts.master')
@section('title')
{{__('manage.edit.product')}} {{$product->code}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>route('product.index'),'name' => __('manage.manage')],
['url' =>route('product.show',$product),'name' => __('manage.product.detail')],
['url' =>'','name' => __('manage.edit.product')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <edit-product  v-bind:taxes="{{$taxes}}" v-bind:product="{{$product}}" v-bind:categories="{{$categories}}" v-bind:suppliers="{{$suppliers}}" v-bind:warehouses="{{$warehouses}}"></edit-product>
        </div>
    </div>
</div>
@include('partials.pageUrl',['pageLink'=>route('product.index')])
@endsection
