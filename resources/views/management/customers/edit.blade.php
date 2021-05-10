@extends('layouts.master')
@section('title')
   {{__('manage.edit.customer')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>route('customer.index'),'name' => __('manage.manage') ],
['url' =>route('customer.show',$customer->id),'name' => __('manage.category.detail')],
['url' =>'','name' => __('manage.edit.category')],
]])
@endpush

@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <edit-customer v-bind:customer="{{$customer}}"></edit-customer>
    </div>
  </div>
</div>
@include('partials.pageUrl',['pageLink'=>route('customer.index')])
@endsection
