
<p class="p-0 text-left">
  <strong>{{$setting->site_name}}</strong> <br>

 {{$setting->address_1}} {{$setting->address_2}}  <br>
 {{$setting->phone}}

<table class="table">
  <caption>Date & reference</caption>
  <tr>
    <th scope="row" class="th-width-20">{{__('pos.createdOn')}}</th>
    <td>{{$order->created_at}}</td>
  </tr>
  <tr>
    <th scope="row" > {{__('common.reference')}}:</th>
    <td>{{$order->reference}}</td>
  </tr>
</table>
<div class="row">
  <div class="col-md-5">
    <div class="text-center">
      <img title="{{$order->reference}}" src="data:image/png;base64,{{DNS1D::getBarcodePNG($order->reference, 'C128A')}}" alt="barcode" class="barcode-200w-60h" /><br>
    </div>
  </div>
  <div class="col-md-7 mt-2">
    <table class="table table-striped">
      <caption>Customer</caption>
      <tr >
        <th scope="row" class="th-width-20">{{__('manage.customer')}} :</th>
        <td>{{$order->customer->name}}</td>
      </tr>
      @if($order->customer->id > 1)
      <tr>
        <th scope="row">{{__('common.email')}}</th>
        <td>{{$order->customer->email}} | <a href="{{route('home')}}/?quick-mail={{$order->customer->email}}" target="_blank">{{__('common.quickMail')}}</a></td>
      </tr>
      <tr>
        <th scope="row">{{__('common.phone')}}</th>
        <td>{{$order->customer->phone}}</td>
      </tr>
      <tr>
        <th scope="row">{{__('common.address')}}</th>
        <td> {{$order->customer->address}}</td>
      </tr>
      @endif
    </table>
  </div>
</div>
