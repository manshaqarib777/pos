<table class="table mt-3">
  <caption> {{__('manage.product.in.resource')}}</caption>
  <thead>
    <tr class="bg-info">
      <th scope="row" class="th-width-50">{{__('manage.product.name')}}</th>
      <th scope="row" class="th-width-25">{{__('manage.product.code')}}</th>
      <th scope="row" class="th-width-20">{{__('common.view')}}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($products as $product)
    <tr>
      <td>{{$product->name}}</td>
      <td>{{$product->code}}</td>
      <td>
        <a href="{{route('product.show',$product->id)}}" title="{{__('common.view.info')}}">
          <i class="fa fa-eye" aria-hidden="true"></i>
        </a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
