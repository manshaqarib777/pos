@extends('layouts.master')

@section('title')
  {{__('entries.define.new.tax.method')}}
@endsection

@push('breadcrumbs')
@include('partials.breadcrumbs',['group'=>__('entries.entries'),'links'=> [
['url' =>'','name' => __('entries.define.tax.method')],
]])
@endpush

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <new-tax></new-tax>
        </div>
    </div>
</div>
@endsection
