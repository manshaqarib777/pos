<!DOCTYPE html>
<html>
<head>
    <title>Printing</title>
    @if(!Str::contains(url()->current(), 'print/a4/')
    && !Str::contains(url()->current(), 'expense/print')
    && !Str::contains(url()->current(), 'purchase/print/') )
    <link rel="stylesheet" href="{{asset('css/print.custom.css')}}">
    <style>
        @page { size:58mm 7in; margin: 0cm; padding: 0px; }
    </style>
    @else
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/azzara.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    @endif
</head>
<body>
    <div class="ticket ">
        <div class="mb-3 hidden-print no-print">
          <button class="btn btn-block" onclick="print()">
             {{__('common.print')}}
         </button>
         <a href="{{url()->previous()}}" class="no-print pos btn btn-block btn-success">{{__('common.back')}}</a>
     </div>
     @yield('content')
 </div>
 <script src="{{ asset('js/app.js') }}"></script>
 <script src="{{ asset('js/report.js') }}"></script>
</body>
</html>
