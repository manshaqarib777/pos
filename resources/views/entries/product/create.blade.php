@extends('layouts.master')
@section('title')
    {{__('entries.add.new.product')}}
@endsection

@push('breadcrumbs')
@include('./partials.breadcrumbs',['group'=>__('entries.entries'),'links'=> [
['url' =>'','name' => __('entries.add.product')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body pt-0">
            <new-product  v-bind:taxes="{{$taxes}}" v-bind:categories="{{$categories}}" v-bind:suppliers="{{$suppliers}}" v-bind:warehouses="{{$warehouses}}"></new-product>
        </div>
    </div>
</div>
@endsection
