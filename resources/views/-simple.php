@extends('layouts.master')
@section('title')
 Saved Reports
@endsection

@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>route('customer.index'),'name' => 'Management'],
['url' =>'','name' => 'Customer'],
]])
@endpush
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-body text-default">

    </div>
  </div>
</div>
@include('partials.pageUrl',['pageLink'=>route('report.index')])
@endsection
