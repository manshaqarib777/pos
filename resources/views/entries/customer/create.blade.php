@extends('layouts.master')
@section('title')
    {{__('entries.add.new.customer')}}
@endsection
@push('breadcrumbs')
@include('./partials.breadcrumbs',['group'=>__('entries.entries'),'links'=> [
['url' =>'','name' => __('entries.add.customer')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <new-customer></new-customer>
        </div>
    </div>
</div>
@endsection
