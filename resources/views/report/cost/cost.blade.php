@extends('layouts.master')
@section('title')
 {{__('report.purchaseOrderCostReport')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['group'=>__('report.reports'),'links'=> [
['url' =>'','name' => __('report.costReport')],
]])
@endpush
@section('content')
<div class="col-md-12 m-0">
    <div class="card">
        <div class="card-body">
            @if(isset($reportCard))
            @include('partials.reports.actions',[
            'genLink' => route('cost.gen'),
            'backLink' => route('cost.report'),
            'reportData' => $reportData,
            'type' => 'cost',
            ])
            <div class="row row-card-no-pd bg-info mb-1">
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col col-stats">
                                    <div class="numbers">
                                        <p class="card-category">{{__('report.netCost')}}</p>
                                        <h4 class="card-title">
                                            {{$setting->currency}}{{$reportCard['total_cost']}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col col-stats">
                                    <div class="numbers">
                                        <p class="card-category">{{__('report.qtyPurchased')}}</p>
                                        <h4 class="card-title">
                                            {{$reportCard['total_qty']}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col col-stats">
                                    <div class="numbers">
                                        <p class="card-category">{{__('report.shippingAmount')}}</p>
                                        <h4 class="card-title">
                                            {{$setting->currency}}{{$reportCard['shipping']}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-card-no-pd bg-info mb-1">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col col-stats">
                                    <div class="numbers">
                                        <p class="card-category">{{__('report.includedTax')}}</p>
                                        <h4 class="card-title">
                                            {{$setting->currency}}{{$reportCard['tax_amount']}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col col-stats">
                                    <div class="numbers">
                                        <p class="card-category">{{__('report.discount')}}</p>
                                        <h4 class="card-title">
                                            {{$setting->currency}}{{$reportCard['off_amount']}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="card card-stats card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col col-stats">
                                    <div class="numbers">
                                        <p class="card-category">{{__('report.taxAmountExcludedShipping')}}</p>
                                        <h4 class="card-title">
                                            {{$setting->currency}}{{$reportCard['total_payment']}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive p-1">
                @include('partials.reports.cost',['purchaseOrders'=>$reportCard['list']])
            </div>
            @else
            @include('partials.reports.builder',['action'=>route('cost.gen')])
            @endif
        </div>
    </div>
</div>
@include('partials.pageUrl',['pageLink'=>route('cost.report')])
@endsection
