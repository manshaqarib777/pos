<table class="table mt-3">
  <caption>Purchase Orders {{__('manage.purchase.orders')}}</caption>
  <thead>
    <tr class="bg-warning">
      <th scope="row" class="th-width-50"> {{__('manage.created.on')}}</th>
      <th scope="row" class="th-width-25"> {{__('common.reference')}}</th>
      <th scope="row">view</th>
    </tr>
  </thead>
  <tbody>
    @foreach($orders as $purchase)
    <tr>
      <td>{{$purchase->created_at}}</td>
      <td>{{$purchase->reference}}</td>
      <td>
        <a href="{{route('purchase.show',$purchase->id)}}" title="{{__('common.view.info')}}">
          <i class="fa fa-eye" aria-hidden="true"></i>
        </a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
