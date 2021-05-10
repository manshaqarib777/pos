@section('title') Print @endsection
@include('partials.head')
@push('style')
<link rel="stylesheet" type="text/css" href="{{asset('css/print.custom.css')}}">
@endpush
<body>
    <div class="wrapper bg-default m-0">
        <div class="content bg-default">
            <div id="app" class="pt-2 bg-default">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                @yield('cardTitle')
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5 text-center">
                                    <img src="{{asset('storage/'.$setting->image)}}" class="img logo-150" alt="logo">
                                </div>
                                <div class="col-sm-7">
                                    <p class="text-left">
                                        Company Name:{{strtoupper($setting->site_name)}}
                                        <br>
                                        @if($setting->registration_number)
                                        Reg#:{{$setting->registration_number}}<br>
                                        @endif
                                        Phone : {{$setting->phone}} | Email: {{$setting->default_email}}<br>
                                        Address:  {{$setting->address_1}} {{$setting->address_2}}
                                    </p>
                                    <div class="pt-1">
                                        <h2>@yield('cardTitle')</h2>
                                        <img  src="data:image/png;base64,{{DNS1D::getBarcodePNG(Date('dmY'), 'C128A')}}" alt="barcode" class="report-barcode" />
                                        <br>
                                        <small>Generated: {{time()}}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                @yield('content')
                            </div>
                            <small class="text-center p-by p-1 m-0">Powered by : Rose Finch <strong>info.codehas@gmail.com</strong> </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/report.js') }}"></script>
</body>
</html>
