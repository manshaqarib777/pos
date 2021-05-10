@extends('layouts.master')
@section('title')
{{__('manage.editPaymentMethod')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>route('payment.index'),'name' => __('manage.manage')],
['url' =>route('payment.show',$payment),'name' => __('manage.paymentDetails')],
['url' =>'','name' => __('manage.editPaymentMethod')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <p class="text-danger text-center">
                <strong>{{__('common.attention')}} : </strong> {{__('manage.attentionNoteP1')}} {{__('manage.attentionNoteP2')}}
            </p>
            <edit-payment v-bind:payment="{{$payment}}"></edit-payment>
        </div>
    </div>
</div>
@include('partials.pageUrl',['pageLink'=>route('payment.index')])
@endsection
