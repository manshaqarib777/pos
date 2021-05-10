@extends('layouts.master')
@section('title')
{{__('pos.register')}} {{$chapter->key}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>route('chapter.index'),'name' => __('pos.pos')],
['url' =>'','name' => __('pos.register')],
]])
@endpush
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-body text-default">
      <div class="col-md-12">
        <h1>{{$chapter->key}}</h1>
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">{{__('pos.chapterInformation')}}</a>
            <a class="nav-item nav-link" id="nav-summary-tab" data-toggle="tab" href="#nav-summary" role="tab" aria-controls="nav-summary" aria-selected="true"> {{__('pos.summary')}}</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"> {{__('pos.userInformation')}}</a>
            <a class="nav-item nav-link" id="nav-sale-tab" data-toggle="tab" href="#nav-sale" role="tab" aria-controls="nav-sale" aria-selected="false">{{__('pos.saleOrders')}}</a>
            <a class="nav-item nav-link" id="nav-refund-tab" data-toggle="tab" href="#nav-refund" role="tab" aria-controls="nav-refund" aria-selected="false">{{__('pos.refundOrders')}}</a>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
            @include('partials.chapter',['chapter'=>$chapter,'info'=>$info])
          </div>
          <div class="tab-pane fade show" id="nav-summary" role="tabpanel" aria-labelledby="nav-summary-tab">
            <table class="table table-bordered table-striped mt-2">
              <caption>Hands on details</caption>
              <tr>
                <th scope="row" class="th-width-20">{{__('pos.totalCashInHand')}}</th>
                <td>{{$chapter->total_cash_in_hands}}</td>
              </tr>
              <tr>
                <th scope="row" class="th-width-20">{{__('pos.walkingCustomerOrders')}}</th>
                <td>{{$chapter->walkin}}</td>
              </tr>
              <tr>
                <th scope="row" class="th-width-20">{{__('pos.regularCustomerOrders')}}</th>
                <td>{{$chapter->regular}}</td>
              </tr>
            </table>
            <table class="table table-bordered table-striped">
              <caption>Sale Order information</caption>
              <tr>
                <th scope="row" class="th-width-20">{{__('pos.saleOrders')}}</th>
                <td>{{$chapter->sale_orders}}</td>
              </tr>
              <tr>
                <th scope="row">{{__('pos.includedTaxAmount')}}</th>
                <td>{{$chapter->tax_amount}}</td>
              </tr>
              <tr>
                <th scope="row">{{__('pos.discountAmount')}}</th>
                <td>{{$chapter->discount}} | <small>( {{__('pos.overallApplied')}} )</small></td>
              </tr>
              <tr>
                <th scope="row">{{__('pos.itemsSold')}}</th>
                <td>{{$chapter->sold_item}}</td>
              </tr>
              <tr>
                <th scope="row">{{__('pos.profit')}}</th>
                <td>{{$chapter->profit}}</td>
              </tr>
              <tr>
                <th scope="row">{{__('pos.lpi')}}</th>
                <td>{{$chapter->low_price_index}}</td>
              </tr>
            </table>
            <table class="table table-bordered table-striped">
              <caption>Refunds Order info</caption>
              <tr>
                <th scope="row" class="th-width-20"> {{__('pos.refundsOrders')}}</th>
                <td>{{$chapter->refund_orders}}</td>
              </tr>
              <tr>
                <th scope="row" class="th-width-20">{{__('pos.includedTaxDepreciation')}}</th>
                <td>{{$chapter->tax_fall}}</td>
              </tr>
              <tr>
                <th scope="row" class="th-width-20">{{__('pos.refundSurcharge')}}</th>
                <td>{{$chapter->surcharges}}</td>
              </tr>
              <tr>
                <th scope="row" class="th-width-20">{{__('pos.refundedAmount')}}</th>
                <td>{{$chapter->refundables}}</td>
              </tr>
            </table>
          </div>
          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="col-md-8 m-5">
              <strong>{{$chapter->user->name}}</strong> | <div class="badge badge-warning">{{$chapter->user->group->name}}</div>
              |<a href="{{route('user.edit',$chapter->user)}}" target="_blank" class="btn btn-link">
                {{__('common.edit')}}
              </a>
              <ul class="mt-3">
                <li>{{__('common.email')}} : {{$chapter->user->email}} |
                  <a href="{{route('home')}}/?quick-mail={{$chapter->user->email}}" target="_blank">
                    {{__('common.quickMail')}}
                  </a>
              </li>
                <li> {{__('common.phone')}}: {{$chapter->user->phone}}</li>
                <li> {{__('common.address')}}: {{$chapter->user->address}}</li>
              </ul>
              <h2>{{__('pos.chaptersHistory')}}</h2>
              <ul>
                @foreach($chapter->user->chapters as $chapter)
                <li>
                  <strong>{{$chapter->key}} </strong>  <small>{{$chapter->status?__('pos.opened'):__('pos.closed')}}</small> |
                  {{ \Carbon\Carbon::parse($chapter->created_at)->diffForHumans() }} |
                  <strong> {{__('pos.orders')}}: </strong> {{$chapter->sales->count()}} |
                  <a href="{{route('chapter.show',$chapter)}}" class="btn-link">
                    {{__('common.view')}}
                  </a>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
          <div class="tab-pane fade" id="nav-sale" role="tabpanel" aria-labelledby="nav-sale-tab">
            @include('partials.reports.sale',['orders'=>$chapter->sales])
          </div>
          <div class="tab-pane fade" id="nav-refund" role="tabpanel" aria-labelledby="nav-refund-tab">
            <table class="table mt-3">
              <caption>Refunds Information</caption>
              <thead class="badge-danger">
                <tr>
                  <th scope="row">#</th>
                  <th scope="row" class="th-width-20">{{__('common.time')}}</th>
                  <th scope="row">{{__('common.reference')}}</th>
                </tr>
              </thead>
              <tbody>
                @foreach($chapter->refunds as $key => $refund)
                <tr>
                  <td>{{$key+1}}</td>
                  <td>
                    <strong>{{ \Carbon\Carbon::parse($refund->created_at)->diffForHumans() }} </strong>
                  </td>
                  <td>
                    {{$refund->reference}}
                    <a href="{{route('refund.show',$refund)}}">{{__('common.view')}}</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('partials.pageUrl',['pageLink'=>route('chapter.index')])
@endsection
