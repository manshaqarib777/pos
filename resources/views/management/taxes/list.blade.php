@extends('layouts.datatable')
@section('title')
{{__('manage.taxes.management')}}
@endsection


@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>'','name' => __('manage.manage')],
['url' =>'','name' => __('manage.taxes')],
]])
@endpush
