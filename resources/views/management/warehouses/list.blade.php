@extends('layouts.datatable')
@section('title')
 {{__('manage.warehouses.management')}}
@endsection
@push('breadcrumbs')
@include('./partials.breadcrumbs',['links'=> [
['url' =>'','name' => __('manage.manage')],
['url' =>'','name' => __('manage.warehouses')],
]])
@endpush
