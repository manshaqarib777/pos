@extends('layouts.master')
@section('title')
  {{__('entries.create.new.subcategory')}}
@endsection

@push('breadcrumbs')
@include('./partials.breadcrumbs',['group'=>__('entries.entries'),'links'=> [
['url' =>'','name' => __('entries.create.new.subcategory')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <new-subcategory v-bind:categories="{{$categories}}"></new-subcategory>
        </div>
    </div>
</div>
@endsection
