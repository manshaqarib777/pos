@include('partials.head')
<body>
    <div class="bg-default pb-5">
        <div class="wrapper bg-default">
            <div class="main-header m-0" data-background-color="{{$setting->skin}}">
                <div class="float-right pt-2 pr-2">
                    <ul class="navbar-nav topbar-nav  align-items-left">
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
                                                <h4>{{Auth::user()->name}} </h4>
                                                <p class="text-muted">
                                                    {{Auth::user()->email}}
                                                </p>
                                                <small class="badge">{{Auth::user()->group->name}}</small>
                                                <button class="btn btn-link btn-xs swicher" data-toggle="tooltip" title="Toggle between POS And Register/Chapter board">Toggle</button>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{route('home')}}">Control Panel</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hide">
                                        {{csrf_field()}}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="content pt-5">
                <div id="app" class="pt-2 bg-default">
                    <div id="alerts">
                        @include('partials.alerts')
                    </div>
                    <div class="card m-4 mt-2 p-2" id="chapterBoard">
                        <div class="card-body">
                            <div class="card-head">
                                <h4 class="card-title">
                                    {{$openedChapter->key}}
                                </h4>
                            </div>
                            <div class="p-2">
                                Click <a href="{{route('chapter.show',$openedChapter)}}" target="_blank">here</a> to view full details (only for authorized persons).
                                <p> Use same toggle button to move/switch back as well, Or click <a href="{{route('pos.index')}}" class="swicher">here</a> to force back.</p>
                            </div>
                            @include('partials.chapter',['chapter'=>$openedChapter,'info'=>$info])
                        </div>
                    </div>
                    <div id="posPortal">
                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- End Custom template -->
        </div>
    </div>
    @include('partials.copyright')
    @include('partials.jsDependencies')
    <script src="{{asset('js/pos.js')}}"></script>
</body>
</html>
