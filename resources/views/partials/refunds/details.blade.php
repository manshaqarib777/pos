<table class="table table-bordered">
  <caption>Item details</caption>
  <thead class="bg-danger">
    <tr>
      <th scope="row" class="th-width-60">{{__('pos.items')}}</th>
      <th scope="row" class="th-width-20">{{__('pos.quantity')}}</th>
      <th scope="row" class="th-width-10">{{__('pos.price')}}</th>
      <th scope="row" class="th-width-20">{{__('pos.subtotal')}}</th>
    </tr>
  </thead>
  <tbody>
    @foreach(json_decode($refund->products_data) as $item)
    <tr>
      <td>
        @if(isset($clickAble))
        <a href="{{route('product.show',$item->product->id)}}" target="_blank">
          {{$item->product->name}}
        </a>
        @else
        {{$item->product->name}}
        @endif
      </td>
      <td>{{$item->qty}}</td>
      <td>{{$item->price}}</td>
      <td>{{$item->subTotal}}</td>
    </tr>
    @endforeach
    <tr>
      <th scope="row" colspan="1">{{__('pos.total.items')}} : {{$refund->total_items}}</th>
      <th scope="row" colspan="3">{{__('pos.grand')}} : {{$setting->currency}}{{round($refund->total_price,2)}}</th>
    </tr>
  </tbody>
</table>
<table class="table">
  <caption>Tax information</caption>
  <tr>
    <th scope="row" class="th-width-50"> {{__('pos.included.tax.fall')}} {{$refund->order_tax}}% :</th>
    <td class="flot-right">{{$setting->currency}}{{$refund->tax_amount}}</td>
    <th scope="row"> {{__('pos.refund.charge')}} {{$refund->charge_rate}}% :</th>
    <td>{{$setting->currency}}{{round($refund->charge_amount,2)}}</td>
  </tr>
  <tr>
    <th scope="row" colspan="2">{{__('pos.total.refund.amount')}} : {{$setting->currency}}{{$refund->refundable}}</th>
    <td colspan="2">{{__('pos.by')}} : {{ucwords($refund->biller_detail)}}</td>
  </tr>
</table>
