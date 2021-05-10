@extends('layouts.master')
@section('title')
{{__('manage.edit.expense.voucher')}}
@endsection

@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>route('expense.index'),'name' => __('manage.manage')],
['url' =>route('expense.show',$expense),'name' => __('manage.expense.detail')],
['url' =>'','name' => __('manage.edit.expense')],
]])
@endpush

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <edit-expense v-bind:expense="{{$expense}}"></edit-expense>
        </div>
    </div>
</div>
@include('partials.pageUrl',['pageLink'=>route('expense.index')])
@endsection
