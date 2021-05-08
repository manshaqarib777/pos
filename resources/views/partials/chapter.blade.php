<div class="row">
  <div class="col-md-9">
    <table class="table table-bordered table-striped mt-2">
      <caption>category Information</caption>
      <tr>
        <th scope="row" class="th-width-20">{{__('pos.createdOn')}}</th>
        <td><strong>{{$chapter->created_at}}</strong> |   {{ \Carbon\Carbon::parse($chapter->created_at)->diffForHumans() }}</td>
      </tr>
      <tr>
        <th scope="row" class="th-width-20"> {{__('pos.lastUpdate')}}</th>
        <td><strong>{{$chapter->updated_at}} </strong>| {{ \Carbon\Carbon::parse($chapter->updated_at)->diffForHumans() }}</td>
      </tr>
      <tr>
        <th scope="row">{{__('pos.status')}}</th>
        <td>
          @if($chapter->status)
          <div class="badge badge-success">
            <i class="fa fa-unlock" aria-hidden="true"></i> {{__('pos.opened')}}
          </div>
          @else
          <div class="badge badge-danger">{{__('pos.closed')}}</div>
          @endif
        </td>
      </tr>
      <tr>
        <th scope="row">{{__('pos.holdingOrders')}}</th>
        <td>
          <strong>{{$info['holdOnOrders']}}</strong>
          @if(route('pos.index') == url()->current())
          <a href="{{route('pos.index')}}?toggle=true" class="btn-link btn-sm btn-submit">{{__('pos.refresh')}}</a>
          @endif
        </td>
      </tr>
    </table>
    <div class="row">
      <div class="col-md-6">
        <table class="table">
          <caption>Last 10 sales</caption>
          <tr>
            <th scope="row">{{__('pos.saleAmount')}}</th><td>{{$info['saleAmount']}}</td>
          </tr>
          <tr>
            <th scope="row">{{__('pos.refundedAmount')}} </th><td>{{$info['refundAmount']}}</td>
          </tr>
          <tr>
            <td>
              <h1>{{__('pos.saleBalance')}}</h1>
            </td>
            <td>
              <h1>{{$info['saleBalance']}}</h1>
            </td>
          </tr>
        </table>
      </div>
      <div class="col-md-6">
        <table class="table">
          <caption>Chaoter info</caption>
          <tr>
            <th scope="row">{{__('pos.saleBalance')}}</th><td>{{$info['saleBalance']}}</td>
          </tr>
          <tr>
            <th scope="row">{{__('pos.refundedCharges')}}</th><td>{{$info['refundedCharges']}}</td>
          </tr>
          <tr>
            <td>
              <h1>{{__('pos.netBalance')}}</h1>
            </td>
            <td>
              <h1> {{$info['netBalance']}}</h1>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-md-12">
      <table class="table">
        <caption>Details about chapter</caption>
        <tr>
          <th scope="row">{{__('pos.netBalance')}}</th>
          <td>
            {{$info['netBalance']}}
          </td>
        </tr>
        <tr class="bg-success">
          <th scope="row">{{__('pos.cashInHands')}}</th><td>{{$info['cashInHands']}}</td>
        </tr>
        <tr class="bg-warning">
          <td>
            <h1>
              <strong> {{__('pos.closingBalance')}}</strong>
            </h1>
          </td>
          <td>
            <h1>
              <strong>{{$info['closingAmount']}}</strong>
            </h1>
          </td>
        </tr>
      </table>
      @if($chapter->status)
      <div class="row m-2">
        <form class="form" action="{{route('chapter.close',$chapter)}}" method="post">
          {{csrf_field()}}
          {{ method_field('PUT') }}
          <div class="custom-control custom-checkbox m-2" data-toggle="tooltip" title="{{__('pos.checkToAutoClear')}}">
            <input type="checkbox" class="custom-control-input" id="forceClearHolding"  name="forceClearHolding" value="1">
            <label class="custom-control-label" for="forceClearHolding">
              <strong>{{__('pos.forceClearHoldingOrders')}}</strong>
            </label>
          </div>
          <div class="input-group bg-warning p-1" data-toggle="tooltip" title="Hi {{$chapter->user->name}} ! , {{__('pos.enterAuthenticationPinToCloseChapter')}}">
            <div class="input-group-prepend">
              <button class="btn btn-default" disabled>
                <i class="fa fa-key" aria-hidden="true"></i> {{__('pos.authenticationPIN')}}
              </button>
            </div>
            <input type="password" name="authKey" required placeholder="{{__('pos.authenticationPIN')}}" class="form-control" autofocus="">
            <input type="submit"  class="btn btn-danger" value="{{__('pos.closeChapter')}}">
          </div>
        </form>
        <p class="pl-2 text-danger">
          <strong>{{__('pos.warning')}} </strong>
          {{__('pos.closeWarning')}}
          </p>
        </div>
        @else
        <div class="alert text-danger">
          <i class="fa fa-lock" aria-hidden="true"></i> {{__('pos.closedAt')}}: {{$chapter->closed_at}}
        </div>
        @endif
      </div>
    </div>
    <div class="col-md-3 pt-3">
      <h2>{{__('pos.paymentFilters')}}</h2>
      <ul>
        @if($chapter->gatewayFilters)
        @foreach(json_decode($chapter->gatewayFilters) as $key => $gate)
        <li><strong>{{$key }}:</strong> {{ $gate}}</li>
        @endforeach
        @else
        <li>{{__('pos.notUpated')}}</li>
        @endif
      </ul>
    </div>
  </div>
