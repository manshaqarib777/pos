@extends('layouts.datatable')

@section('title')
Refunds Management
@endsection

@push('breadcrumbs')
@include('./partials.breadcrumbs',['group'=>'Finance','links'=> [
['url' =>'','name' => 'Refunds Management'],
]])
@endpush
