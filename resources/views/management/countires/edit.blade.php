@extends('layouts.master')

@section('title')
{{__('manage.edit.country')}}
@endsection

@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>route('country.index'),'name' => __('manage.manage')],
['url' =>route('country.show',$country),'name' =>__('manage.country.detail')],
['url' =>'','name' => __('manage.edit.country')],
]])
@endpush

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <edit-country v-bind:country="{{$country}}"></edit-country>
        </div>
    </div>
</div>
@include('partials.pageUrl',['pageLink'=>route('country.index')])
@endsection
