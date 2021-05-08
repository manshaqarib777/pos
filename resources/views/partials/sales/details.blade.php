<table class="table">
  <caption>Order items</caption>
  <thead class="bg-success">
    <tr>
      <th scope="row" class="th-width-50">{{__('pos.items')}}</th>
      <th scope="row" class="th-width-10">{{__('pos.qty')}}</th>
      <th scope="row" class="th-width-10">{{__('pos.price')}}</th>
      <th scope="row" class="th-width-10"> {{__('pos.itemDiscount')}}</th>
      <th scope="row" class="th-width-10"> {{__('pos.subtotal')}}</th>
    </tr>
  </thead>
  <tbody>
    @foreach(json_decode($sale->products_data) as $item)
    <tr>
      <td>
        @if(isset($links))
        <a href="{{route('product.show',$item->product->id)}}" target="_blank">
         {{ucwords($item->product->name)}}
        </a>
        @else
        {{ucwords($item->product->name)}}
        @endif
      </td>
      <td>{{$item->qty}}</td>
      <td>{{$item->price}}</td>
      <td>{{$item->discount}}</td>
      <td>{{$item->subTotal}}</td>
    </tr>
    @endforeach
    <tr>
      <td colspan="1"><strong>{{__('pos.totalItems')}} </strong> {{$sale->total_items}}</td>
      <td colspan="4" ><strong> {{__('pos.grand')}} </strong>{{$setting->currency}}{{round($sale->total_price,2)}}</td>
    </tr>
  </tbody>
</table>
<table class="table">
  <caption>Sale Tax info</caption>
  <tr>
    <th scope="row" class="th-width-50">{{__('pos.includedTax')}} {{$sale->order_tax}}% :</th>
    <td class="flot-right">{{$setting->currency}}{{$sale->tax_amount}}</td>
    <th scope="row">{{__('pos.orderDiscount')}} {{$sale->discount_rate}}% :</th>
    <td>{{$setting->currency}}{{round($sale->discount_amount,2)}}</td>
  </tr>
  <tr>
    <td> {{__('pos.recipientAmount')}}</td>
    <td>{{$setting->currency}}{{round($sale->enter_amount,2)}}</td>
    <td> {{__('pos.returnChange')}}</td>
    <td>{{$setting->currency}}{{round($sale->change,2)}}</td>
  </tr>
  <tr>
    <th scope="row" colspan="2">{{__('pos.totalPaidAmount')}} : {{$setting->currency}}{{$sale->payable}}</th>
    <td colspan="2">{{__('pos.by')}} : {{ucwords($sale->biller_detail)}}</td>
  </tr>
</table>
