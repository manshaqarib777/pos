<ul class="breadcrumbs p-0">

    <li class="nav-home mr-1">
        <a href="{{route('home')}}" class="btn-link btn-info" data-toggle="tooltip" title="{{__('common.gotoHome')}}">
            <i class="fas fa-home fa-lg" aria-hidden="true"></i>
        </a>
    </li>
    @if(isset($group))
    <li class="separator">
        <i class="fa fa-angle-double-right fa-lg" aria-hidden="true"></i>
    </li>
    <li class="nav-item">
        <strong> {{$group}}</strong>
    </li>
    @endif
    @foreach($links as $key => $link)
    <li class="separator">
        @if(!isset($group) && $key < 1)
        <i class="fa fa-angle-double-right fa-lg" aria-hidden="true"></i>
        @else
        <i class="fa fa-angle-right fa-lg" aria-hidden="true"></i>
        @endif
    </li>
    <li class="separator">
        @if($link['url'])
        <a href="{{$link['url']}}" class="m-0 btn-info btn-link">
            {{$link['name']}}
        </a>
        @else
        {{$link['name']}}
        @endif
    </li>
    @endforeach
</ul>
