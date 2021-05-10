@extends('layouts.master')

@section('title')
 {{__('manage.edit.warehouse.information')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>route('warehouse.index'),'name' => __('manage.manage')],
['url' =>route('warehouse.show',$warehouse),'name' => __('manage.warehouse.detail')],
['url' =>'','name' => __('manage.edit.warehouse')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <edit-warehouse v-bind:warehouse="{{$warehouse}}"></edit-warehouse>
        </div>
    </div>
</div>
@include('partials.pageUrl',['pageLink'=>route('warehouse.index')])
@endsection
