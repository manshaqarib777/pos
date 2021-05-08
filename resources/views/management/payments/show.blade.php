@extends('layouts.master')
@section('title')
 {{__('manage.paymentDetails')}}
@endsection
@push('breadcrumbs')
@include('./partials.breadcrumbs',['links'=> [
['url' =>route('payment.index'),'name' => __('manage.manage')],
['url' =>'','name' => __('manage.paymentDetails')],
]])
@endpush
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-body text-default">
      <div class="row">
        <div class="col-md-12">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">{{__('manage.paymentDetails')}}</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
              @section('buttons')
              <form  method="post" action="{{route('payment.toggle',$payment)}}">
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <input type="hidden" name="payment_code" value="{{$payment->code}}">
                <button class="btn btn-sm btn-default" data-toggle="tooltip" title="{{__('manage.toggleTitle')}}" type="submit">{{__('manage.toggle')}}</button>
              </form>
              @endsection
              @include('./partials.buttons',[
              'allLink'=>route('payment.index'),
              'editLink'=>route('payment.edit',$payment->id),
              'destroyLink' =>route('payment.destroy',$payment->id)
              ])
              <table class="table table-bordered table-striped">
                <caption>Gateway information </caption>
                <tr>
                  <th scope="row" class="th-width-20">{{__('manage.createdOn')}}</th>
                  <td>{{$payment->created_at}}</td>
                </tr>
              </table>
              <table class="table table-bordered table-striped" >
                <caption>payment title</caption>
                <tr>
                  <th scope="row" class="th-width-20">{{__('manage.title')}}</th>
                  <td>{{$payment->title}}</td>
                </tr>
                <tr>
                  <th scope="row">{{__('manage.short.code')}}</th>
                  <td>{{$payment->code}}</td>
                </tr>
                <tr>
                  <th scope="row">{{__('manage.state')}}</th>
                  <td>
                    @if($payment->state)
                    <div class="badge badge-success">{{__('common.active')}}</div>
                    @else
                    <div class="badge badge-warning">{{__('common.inactive')}}</div>
                    @endif
                  </td>
                </tr>
                <tr>
                  <th scope="row">{{__('manage.details')}}</th>
                  <td>
                    {{$payment->detail}}
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@include('./partials.pageUrl',['pageLink'=>route('payment.index')])
