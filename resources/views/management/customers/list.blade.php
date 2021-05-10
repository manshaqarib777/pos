@extends('layouts.datatable')
@section('title')
 {{__('manage.customers.management')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>'','name' => __('manage.manage')],
['url' =>'','name' => __('manage.customer')],
]])
@endpush
