@extends('layouts.master')

@section('title')
   {{__('manage.edit.tax.method')}}
@endsection

@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>route('tax.index'),'name' => __('manage.manage')],
['url' =>route('tax.show',$tax),'name' => __('manage.tax.method.detail')],
['url' =>'','name' => __('manage.edit.tax.method')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <edit-tax v-bind:tax="{{$tax}}"></edit-tax>
        </div>
    </div>
</div>
@include('partials.pageUrl',['pageLink'=>route('tax.index')])
@endsection
