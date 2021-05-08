@extends('layouts.print')
@section('content')
<div  class="col-md-auto m-0">
  <div class="card">
    <div class="card-body">
      <img title="{{$purchase->reference}}" src="data:image/png;base64,{{DNS1D::getBarcodePNG($purchase->reference, 'C39')}}" alt="barcode"  class="barcode-200w-60h" />
      <p>
        {{__('common.reference')}} # {{$purchase->reference}}
        |  {{__('common.date')}}: {{$purchase->date}}
      </p>
      <strong>
      {{__('common.status')}}:
      @if($purchase->status)
      {{__('common.paid')}}
      @else
      {{__('common.unpaid')}}
      @endif
      </strong>

      <hr>
      <div class="row">
        <div class="col-md-8">
          <p class="p-0 text-left">
            {{__('common.company')}} : {{$setting->site_name}} | Reg#:{{$setting->registration_number}}<br>
            {{__('manage.vat')}} # : {{$setting->vat}}<br>
            {{__('common.address')}}:  {{$setting->address_1}} {{$setting->address_2}} <br>
            {{__('common.phone')}}: {{$setting->phone}} | {{__('common.email')}}: {{$setting->default_email}}
          </p>
        </div>
        <div class="col-md-4 flot-right">
          <p class="p-0 text-left">
            {{__('manage.supplier')}} : {{$purchase->supplier->name}}<br>
            {{__('manage.vat')}} # : {{$purchase->supplier->vat}}<br>
            {{__('common.company')}} : {{$purchase->supplier->company}}:
            {{__('common.address')}} {{$purchase->supplier->address}}:
          </p>
        </div>
      </div>
      <hr>
     @include('./partials.purchases.details',['purchase'=>$purchase])

       <hr>
      <div class="row text-left pt-4 only-print">
        <div class="col-md-6">
          <strong>{{__('manage.purchaser.sig')}}: </strong> __________________________________
        </div>
        <div class="col-md-6 text-right">
          <strong>{{__('manage.supplier.sig')}}: </strong> __________________________________
        </div>
      </div>
      <div class="mt-4 mb-4 no-print">
        <button class="btn btn-block print no-print" onclick="print()"><i class="fas fa-print fa-fw" aria-hidden="true"></i>{{__('common.print')}}</button>
        <a href="{{url()->previous()}}" class="no-print pos btn btn-block btn-success">{{__('common.back')}}</a>
      </div>
    </div>
  </div>
</div>
@endsection
