@extends('layouts.master')

@section('title')
   {{__('entries.create.country')}}
@endsection

@push('breadcrumbs')
@include('partials.breadcrumbs',['group'=>__('entries.entries'),'links'=> [
['url' =>'','name' => __('entries.create.country')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <new-country></new-country>
        </div>
    </div>
</div>
@endsection
