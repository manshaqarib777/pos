@extends('layouts.datatable')
@section('title')
{{__('manage.expenses.management')}}
@endsection
@push('breadcrumbs')
@include('./partials.breadcrumbs',['links'=> [
['url' =>'','name' => __('manage.manage')],
['url' =>'','name' => __('manage.expenses')],
]])
@endpush
