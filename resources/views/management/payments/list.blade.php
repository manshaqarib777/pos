@extends('layouts.datatable')
@section('title')
{{__('manage.paymentGatewaysManagement')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>'','name' => __('manage.manage')],
['url' =>'','name' => __('manage.paymentDetails')],
]])
@endpush
