@extends('layouts.datatable')
@section('title')
 {{__('pos.registersManagement')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>'','name' => __('pos.pos')],
['url' =>'','name' => __('pos.manageRegisters')],
]])
@endpush
