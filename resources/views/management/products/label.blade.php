@extends('layouts.label')
@push('style')
<style>
    body {
    color: #000;
  }
  .label{
    border-style:dotted;
    border-color:red;
    border-width: 1px;
  }
  h6{
    padding: 0;
    margin: 0;
    font-size:{{$config['fontSize']}}px
  }

  @media print {
    body, h1, h2, h3, h4, h5, .h1, .h2, .h3, .h4, .h5 {
      font-size: 8px;
    }
    .label{
      border-style:dotted;
      border-color:gray ;
      border-width: 1px;
    }
  }
</style>

@endpush
@section('title')
Generating Product label
@endsection
@section('content')
<div class="col-md-12">
  <div class="card card-round">
    <div class="card-body">
      <div class="row">
        @for ($i =1 ; $i <= $config['times']; $i++)
        <div class="{{$config['col']}} {{$config['padding']}} text-center pl-0" title="Label block {{$i}}">
          <div class="p-1 {{$config['border']}}">
            @if(!is_null($config['price']))
            <h6 class="m-0 p-0" title="Product Price"> {{$config['price']}}</h6>
            @endif
            @if(!is_null($config['name']))
            <h6 class="m-0 p-0"> {{$config['name']}}</h6>
            @endif
            <img title="Bardcode {{$config['code']}}" src="data:image/png;base64,{{DNS1D::getBarcodePNG($config['code'], $config['symbology'])}}" alt="barcode" width="{{$config['width']}}" height="{{$config['height']}}" />
            @if(!is_null($config['code']))
            <h6 class="m-0 p-0" title="Product barcode">{{$config['code']}}</h6>
            @endif
            @if(!is_null($config['company']))
            <h6 class="m-0 p-0" title="Company Name">{{$config['company']}}</h6>
            @endif
          </div>
        </div>
        @endfor
      </div>
    </div>
  </div>
</div>
@endsection

