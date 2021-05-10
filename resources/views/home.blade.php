@extends('layouts.master')
@section('title')
{{__('home.welcomeHome')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>'','name' => __('home.welcomeHome')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="card p-5">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{__('home.home')}}</a>
                @can('newRequest','App\Group')
                <a class="nav-item nav-link" id="nav-permission-tab" data-toggle="tab" href="#nav-permission" role="tab" aria-controls="nav-permission" aria-selected="false">{{__('home.requestPermissions')}}</a>
                @endcan
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">{{__('home.activityLog')}}</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                @if(!isset($_GET['quick-mail']))
                <div class="card-body">
                    <div class="text-center p-3">
                        <h1>{{__('home.welcomeHome')}} {{ucwords(strtolower($setting->site_name))}}<sup><div class="badge badge-default">{{__('settings.version').' '.$setting->version}}</div></sup></h1>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="{{asset('storage/'.Auth::user()->image)}}" class="img img-responsive logo-img-150wh" alt="{{Auth::user()->name}}">
                        </div>
                        <div class="col-md-8">
                            <h2>
                            <i class="fa fa-check-circle fa-fw fa-lg" aria-hidden="true"></i> {{Auth::user()->name}} <small>{{__('home.loggedIn')}}</small> </h2>
                            <ul class="mt-3">
                                <li>{{__('common.email')}} : {{Auth::user()->email}}</li>
                                <li>{{__('common.phone')}} : {{Auth::user()->phone}}</li>
                                <li>{{__('common.address')}} : {{Auth::user()->address}}</li>
                            </ul>
                            <a href="{{route('user.edit',Auth::user())}}">
                                <i class="fa fa-edit" aria-hidden="true"></i> {{__('home.editInformation')}}
                            </a>
                            <a class="btn btn-default btn-sm float-right" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{__('common.logout')}}
                            </a>
                        </div>
                    </div>
                </div>
                @else
                <h1 class="pt-5"> {{__('home.quickMailTo')}} : {{ $_GET['quick-mail']}}</h1>
                @endif
                @can('quickMail','App\Setting')
                <div class="col-md-12 {{isset($_GET['quick-mail'])? 'bg-warning':'bg-default'}} p-3">
                    <h3 class="pl-3"><i class="fa fa-envelope" aria-hidden="true"></i> {{__('home.quickMail')}}</h3>
                    <form action="{{route('quick-mail')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input required type="email" name="email" placeholder="{{__('home.emailToSend')}}"  class="form-control @if($errors->has('email')) is-invalid @endif" value="{{isset($_GET['quick-mail'])? $_GET['quick-mail']:old('email')}}">
                            @if($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group pt-0">
                            <input required type="text" name="subject" placeholder="{{__('home.mailSubject')}}"  class="form-control @if($errors->has('subject')) is-invalid @endif" value="{{old('subject')}}">
                            @if($errors->has('subject'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('subject') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group pt-0">
                            <textarea required name="message" class="form-control @if($errors->has('message')) is-invalid @endif" rows="11" placeholder="{{__('home.mailMessage')}}">{{old('message')}}</textarea>
                            @if($errors->has('message'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('message') }}</strong>
                            </span>
                            @endif
                        </div>
                        <button class="btn btn-sm ml-2 btn-info">{{__('home.send')}}</button>
                    </form>
                </div>
                @endcan
                @cannot('quickMail','App\Setting')
                <div class="alert p-2 pl-5 bg-danger text-white">
                    <stong>{{__('common.attention')}} :</stong> {{__('home.notAuthToSendQuickMail')}}.
                </div>
                @endcan
            </div>
            @can('newRequest','App\Group')
            <div class="tab-pane fade" id="nav-permission" role="tabpanel" aria-labelledby="nav-permission-tab">
                @if(auth()->user()->id < 2)
                <div class="card-body p-5">
                    <h1 class="m-5"> <i class="fa fa-check-circle fa-fw fa-lg" aria-hidden="true"></i> {{__('home.allPermissionsGranted')}}</h1>
                </div>
                @else
                <div class="card-body">
                    <form action="{{route('group.permission.request')}}" method="post">
                        {{csrf_field()}}
                        @include('partials/permission',['per'=>$per])
                        <input type="hidden" name="user" value="{{auth()->user()->id}}">
                        <div class="form-group">
                            <label>{{__('home.WhyAreYouGoingToMake')}}</label>
                            <textarea name="note" required class="form-control" rows="5"></textarea>
                        </div>
                        <input type="submit" value="{{__('home.makeRequest')}}" class="btn btn-success">
                    </form>
                </div>
                @endif
            </div>
            @endcan
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

                <div class="col-md-12 bg-default p-4 m-3">
                    <ul class="timeline">
                        @foreach($logs as $key => $activity)
                        @if($key % 2 == 0)
                        <li>
                        @else
                        <li class="timeline-inverted">
                        @endif
                            <div class="timeline-badge info">{{($key+1)}}</div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4 class="timeline-title p-0" data-toggle="tooltip" title="{{__('home.description')}}">
                                        {{ucwords(strtolower($activity->description))}}
                                    </h4>
                                    <p class="m-0 p-0"><small class="text-muted"><i class="fa fa-clock"></i>  {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</small></p>
                                </div>
                                <div class="timeline-body">
                                    <div class="badge badge-secondary" data-toggle="tooltip" title="{{__('home.module')}}">
                                        {{ucwords($activity->type)}}
                                    </div>
                                    <div class="badge badge-info" data-toggle="tooltip" title="{{__('common.reference')}}">
                                        {{ucwords(strtolower($activity->reference))}}
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
