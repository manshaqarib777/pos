<div class="col-sm-12 col-md-12 {{app()->getLocale() == 'en'? 'text-left':'text-center'}}">
    @if(session()->has('warning'))
    <div class="alert bg-warning p-1 pl-2 m-1 text-white">
        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{session()->get('warning')}}
    </div>
    @endif
    @if(session()->has('message'))
    <div class="alert bg-danger p-1 pl-2 m-1 text-white">
        <i class="fa fa-times-circle" aria-hidden="true"></i> {{session()->get('message')}}
    </div>
    @endif
    @if(session()->has('success'))
    <div class="alert bg-success p-1 pl-2 m-1 text-white">
        <i class="fa fa-check-circle" aria-hidden="true"></i> {{session()->get('success')}}
    </div>
    @endif
    @if(session()->has('info'))
    <div class="alert bg-info p-1 pl-2 m-1 text-white">
        <i class="fa fa-info-circle" aria-hidden="true"></i> {{session()->get('info')}}
    </div>
    @endif
</div>
