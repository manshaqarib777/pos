<table class="table table-bordered">
    <caption>Purchased</caption>
    <thead>
        <tr>
            <th scope="row" class="th-width-20">{{__('report.reference')}}</th>
            <th scope="row">{{__('report.orderedAt')}}</th>
            <th scope="row">{{__('report.supplierName')}}</th>
            <th scope="row">{{__('report.qty')}}</th>
            <th scope="row">{{__('report.shipping')}}</th>
            <th scope="row">{{__('report.tax')}}</th>
            <th scope="row">{{__('report.payment')}}</th>
            <th scope="row">{{__('report.status')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reportCard['list'] as $purchase)
        <tr>
            <td class="p-0">
                <img title="{{$purchase['reference']}}" src="data:image/png;base64,{{DNS1D::getBarcodePNG($purchase['reference'], 'C39')}}" class="barcode-100w-20h" alt="barcode"/>
            </td>
            <td>{{$purchase['created_at']}}</td>
            <td>
                @if(isset($purchase->supplier->name))
                {{$purchase->supplier->name}}
                @else
                <a href="{{route('supplier.show',$purchase['supplier_id'])}}">{{__('common.view')}}</a>
                @endif
            </td>
            <td>{{$purchase['total_qty']}}</td>
            <td>{{$purchase['shipping']}}</td>
            <td>{{$purchase['tax_amount']}}</td>
            <td>{{$purchase['total_payment']}}</td>
            <td>
                @if($purchase['status'] == 1)
                {{__('common.paid')}}
                @else
                 {{__('common.unpaid')}}
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
