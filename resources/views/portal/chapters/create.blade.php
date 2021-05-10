@extends('layouts.master')
@section('title')
{{__('pos.openingNewRegister')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['group'=>__('pos.pos'),'links'=> [
['url' =>'','name' => __('pos.newRegister')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body p-4">
            <form class="form" method="post" action="{{route('chapter.store')}}">
                {{csrf_field()}}
                <div class="row form-group">
                    <label for="user">{{__('pos.selectUser')}}</label>
                    <select class="form-control selectpicker" data-live-search="true" data-style="form-control" name="user" id="user">
                        @if(auth()->user()->id < 2)
                        <option disabled="">{{__('pos.masterSelectUser')}}</option>
                        @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}} | {{$user->email}}</option>
                        @endforeach
                        @else
                        <option value="{{auth()->user()->id}}" selected=""> {{__('pos.name')}}:{{auth()->user()->name}} - Group:{{auth()->user()->group->name}} - {{__('pos.loggedIn')}}</option>
                        @endif
                    </select>
                </div>
                <div class="form-group col-md-6">
                    @if(auth()->user()->id < 2)
                    <input type="hidden" name="adminAction" value="{{true}}">
                    @endif
                    <label for="total_cash_in_hands">{{__('pos.cashInHands')}}</label>
                    <input id="total_cash_in_hands" type="number" class="form-control @if($errors->has('total_cash_in_hands')) is-invalid @endif" name="total_cash_in_hands" value="{{ old('total_cash_in_hands') }}" required >
                    @if($errors->has('total_cash_in_hands'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$errors->first('message') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="row form-group">
                    <button type="submit" class="btn btn-primary">
                        {{ __('pos.openRegister') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('partials.pageUrl',['pageLink'=>route('chapter.create')])
@endsection
