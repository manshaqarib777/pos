<table class="table table-striped table-hover">
  <caption>Out of stock</caption>
  <thead>
    <tr>
      <th scope="row" class="th-width-25">{{__('report.productCode')}}</th>
      <th scope="row" class="th-width-25">{{__('report.name')}}</th>
      <th scope="row" class="th-width-25">{{__('report.supplier')}}</th>
      <th scope="row" class="th-width-10">{{__('report.alertedOn')}}</th>
      <th scope="row" class="th-width-10">{{__('report.remainingQty')}}</th>
      <th scope="row" class="th-width-5">{{__('report.impact')}}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($products as $product)
    <tr>
      <td>
        <img title="{{$product->code}}" src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->code, 'C39','1','20')}}" alt="barcode"  />
        {{$product->code}}</td>
        <td>
          @if(isset($linkable))
          <a href="{{route('product.show',$product->id)}}" target="_blank">
            {{ucwords($product->name)}}
          </a>
          @else
          {{ucwords($product->name)}}
          @endif
        </td>
        <td>{{$product->supplier->name}}</td>
        <td>{{$product->alert_quantity}}</td>
        <td>{{$product->qty}}</td>
        <td>
          {{$product->impact}}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
