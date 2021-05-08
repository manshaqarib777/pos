@extends('layouts.master')

@section('title')
 {{__('entries.add.new.expense')}}
@endsection

@push('breadcrumbs')
@include('./partials.breadcrumbs',['group'=>__('entries.entries'),'links'=> [
['url' =>'','name' => __('entries.expense.voucher')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <new-expense></new-expense>
        </div>
    </div>
</div>
@endsection
