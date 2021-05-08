@extends('layouts.master')
@section('title')
 {{__('manage.purchase.order.detail')}}
@endsection
@push('breadcrumbs')
@include('./partials.breadcrumbs',['links'=> [
['url' =>route('purchase.index'),'name' => __('manage.manage')],
['url' =>'','name' => __('manage.purchase.order.detail')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <table class="table table-bordered">
                        <caption>Purchase Details</caption>
                        <tr>
                            <th scope="row" class="th-width-25">{{__('common.reference')}}</th>
                            <td>{{$purchase->reference}}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="th-width-25">{{__('common.date')}}</th>
                            <td>{{$purchase->date}}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="th-width-25"> {{__('common.status')}}</th>
                            <td>
                                @if($purchase->status)
                                <i class="fa fa-check-circle fa-fw" aria-hidden="true"></i>{{__('common.paid')}}
                                @else
                                {{__('common.unpaid')}} | <a title="hit if payment done" href="{{route('purchase.paid',$purchase->id)}}" class="btn btn-sm">{{__('common.paid')}}? </a>
                                @endif
                            </td>
                        </tr>
                        @if($purchase->status)
                        <tr>
                            <th scope="row" class="th-width-25">{{__('manage.update.stock')}}</th>
                            <td>
                                @if($purchase->stock)
                                <i class="fa fa-check-circle fa-fw" aria-hidden="true"></i>{{__('manage.stock.updated')}}
                                @else
                                {{__('manage.not.update')}} |<a href="{{route('purchase.stock-up',$purchase->id)}}" class="btn btn-sm">{{__('manage.yes.update')}} ? </a>
                                @endif
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="2">
                                @section('buttons')
                                <a class="btn btn-sm btn-default" title="{{__('common.print')}}" href="{{route('purchase.print',$purchase->id)}}" ><i class="fa fa-print fa-fw" aria-hidden="true"></i>{{__('common.print')}}</a>
                                @endsection
                                @include('./partials.buttons',[
                                'allLink'=>route('purchase.index'),
                                'destroyLink' =>route('purchase.destroy',$purchase->id)
                                ])
                            </td>
                        </tr>
                        <tr class="bg-warning text-white">
                            <th scope="row" class="th-width-25" colspan="2">{{__('manage.supplier.detail')}}</th>
                        </tr>
                        <tr>
                            <th scope="row">{{__('manage.name')}}</th>
                            <td>{{$purchase->supplier->name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{__('common.email')}}</th>
                            <td>{{$purchase->supplier->email}}
                                | <a href="{{route('home')}}/?quick-mail={{$purchase->supplier->email}}" target="_blank">{{__('common.quickMail')}}</a>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">{{__('manage.vat')}}</th>
                            <td>{{$purchase->supplier->vat}}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{__('manage.company')}}</th>
                            <td>{{$purchase->supplier->company}}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{__('manage.address')}}</th>
                            <td>{{$purchase->supplier->address}}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-8">
                    <h1 class="text-center">{{__('manage.purchase.order.detail')}}</h1>
                    @include('./partials.purchases.details',['purchase'=>$purchase])
                </div>
            </div>
        </div>
    </div>
</div>
@include('./partials.pageUrl',['pageLink'=>route('purchase.index')])
@endsection
