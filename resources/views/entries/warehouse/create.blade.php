@extends('layouts.master')

@section('title')
 {{__('entries.register.new.warehouse')}}
@endsection

@push('breadcrumbs')
@include('./partials.breadcrumbs',['group'=>__('entries.entries'),'links'=> [
['url' =>'','name' => __('entries.register.new.warehouse')],
]])
@endpush

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <new-warehouse></new-warehouse>
        </div>
    </div>
</div>
@endsection
