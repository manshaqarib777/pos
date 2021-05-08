<nav class="navbar navbar-header navbar-expand-lg">
    <div class="container-fluid">
        <div class="collapse" id="search-nav">
            <div class="navbar mr-md-3">
                <a href="{{route('pos.index')}}" target="_blank" class="text-white" title="{{__('pos.pointOfSale')}}">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <strong>{{__('pos.pointOfSale')}}</strong>
                </a>
            </div>
        </div>
        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            <li class="nav-item dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                        <img src="{{asset('storage/'.Auth::user()->image)}}" alt="..." class="avatar-img rounded-circle">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <li>
                        <div class="user-box">
                            <div class="avatar-lg">
                            <img src="{{asset('storage/'.Auth::user()->image)}}" alt="image profile" class="avatar-img rounded"></div>
                            <div class="u-text">
                                <h4>{{Auth::user()->name}}</h4>
                                <p class="text-muted">
                                    {{Auth::user()->email}}
                                </p>
                                <a class="btn-link btn-xs" href="{{ route('user.edit',Auth::user()->id) }}">
                                    {{__('common.change.information')}}
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{__('common.logout')}}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hide">
                            {{csrf_field()}}
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
