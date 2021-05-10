@extends('layouts.master')

@section('title')
 {{__('entries.add.new.supplier')}}
@endsection

@push('breadcrumbs')
@include('partials.breadcrumbs',['group'=>__('entries.entries'),'links'=> [
['url' =>'','name' => __('entries.add.supplier')],
]])
@endpush

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <new-supplier></new-supplier>
        </div>
    </div>
</div>
@endsection
