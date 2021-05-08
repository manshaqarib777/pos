@extends('layouts.master')
@section('title')
{{__('entries.definePaymentMethod')}}
@endsection
@push('breadcrumbs')
@include('./partials.breadcrumbs',['group'=>__('entries.entries'),'links'=> [
['url' =>'','name' => __('entries.definePaymentMethod')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <new-payment></new-payment>
        </div>
    </div>
</div>
@endsection
