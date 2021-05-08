@extends('layouts.print')
@section('content')
<div  class="col-sm-auto m-0">
  <div class="card">
    <div class="card-body">
      <img title="{{$expense->reference}}" src="data:image/png;base64,{{DNS1D::getBarcodePNG($expense->reference, 'C39','1','50')}}" alt="barcode"  />
      <p>
        {{__('common.reference')}} # {{$expense->reference}}
        |  {{__('common.date')}} : {{$expense->created_at}}
      </p>
      <div class="row">
        <div class="col-md-12">
          <p class="p-0 text-left">
            {{__('common.company')}} : {{$setting->site_name}} | Reg#:{{$setting->registration_number}}<br>
            {{__('manage.vat')}} # : {{$setting->vat}}<br>
            {{__('common.address')}}:  {{$setting->address_1}} {{$setting->address_2}} <br>
            {{__('common.phone')}}: {{$setting->phone}} | {{__('common.email')}}: {{$setting->default_email}}
          </p>
        </div>
      </div>
      <table class="table table-bordered">
        <caption>Expense Report</caption>
        <tr>
          <th scope="row" class="th-width-20">{{__('manage.by')}}</th>
          <td>{{$expense->by}}</td>
        </tr>
        <tr>
          <th scope="row">{{__('manage.amount')}}</th>
          <td>{{$setting->currency}}{{$expense->amount}}</td>
        </tr>
        <tr>
          <th scope="row">{{__('manage.type')}}</th>
          <td>{{$expense->type}}</td>
        </tr>
        <tr>
          <th scope="row">{{__('manage.details')}}</th>
          <td>{{$expense->note}}</td>
        </tr>
        <tr>
          <th scope="row">{{__('manage.attachment')}}</th>
          <td>
            <img src="{{asset('storage/'.$expense->attachment)}}" alt="attachment" class="attach-expense">
          </td>
        </tr>
      </table>
      <div class="row text-left pt-4 only-print">
        <div class="col-md-6">
          <strong>{{__('manage.person.sig')}}</strong> __________________________________
        </div>
        <div class="col-md-6 text-right">
          <strong>{{__('manage.accountant.sig')}} </strong> _______________________________
        </div>
      </div>
      <div class="mt-4 mb-4 no-print">
        <button class="btn btn-block print no-print" onclick="print()"><i class="fas fa-print fa-fw" aria-hidden="true"></i>{{__('common.print')}}</button>
        <a href="{{url()->previous()}}" class="no-print expense btn btn-block btn-success">{{__('common.back')}}</a>
      </div>
    </div>
  </div>
</div>
@endsection
