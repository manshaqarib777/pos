<div class="logo-header">
    <a href="{{route('home')}}" class="logo">
        <img src="{{asset('storage/'.$setting->image)}}" alt="{{$setting->site_name}}" class="navbar-brand logo-img-45wh" >
    </a>
    <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </span>
    </button>
    <button class="topbar-toggler more"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
    <div class="navbar-minimize">
        <button class="btn btn-minimize btn-rounded">
        <i class="fa fa-bars" aria-hidden="true"></i>
        </button>
    </div>
</div>
