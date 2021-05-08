@extends('layouts.datatable')
@section('title')
 {{__('pos.salesManagement')}}
@endsection
@push('breadcrumbs')
@include('./partials.breadcrumbs',['group'=>'Finance','links'=> [
['url' =>'','name' => __('pos.salesManagement')],
]])
@endpush
