@extends('layouts.master')

@section('title')
 {{__('manage.edit.subcategory')}}
@endsection

@push('breadcrumbs')
@include('./partials.breadcrumbs',['links'=> [
['url' =>route('subcategory.index'),'name' => __('manage.manage')],
['url' =>route('subcategory.show',$subcategory),'name' => __('manage.subcategory.detail')],
['url' =>'','name' => __('manage.edit.subcategory')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <edit-subcategory v-bind:categories="{{$categories}}" v-bind:subcategory="{{$subcategory}}"></edit-subcategory>
        </div>
    </div>
</div>
@include('./partials.pageUrl',['pageLink'=>route('subcategory.index')])
@endsection
