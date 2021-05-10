@extends('layouts.master')

@section('title')
   {{__('user.addNewUser')}}
@endsection

@push('breadcrumbs')
@include('partials.breadcrumbs',['group'=>__('user.users'),'links'=> [
['url' =>'','name' => __('user.newUser')],
]])
@endpush


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">{{ __('user.name') }}</label>
                                <input id="name" type="text" class="form-control @if($errors->has('name')) is-invalid @endif" name="name" value="{{ old('name') }}" required>
                                @if($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">{{ __('user.emailAddress') }}</label>
                                <input id="email" type="email" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" value="{{ old('email') }}" required >
                                @if($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="address">{{ __('user.address') }}</label>
                                <input id="address" type="text" class="form-control @if($errors->has('address')) is-invalid @endif" name="address" value="{{ old('address') }}" required >
                                @if($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                <label for="password">{{ __('user.password') }}</label>
                                <input id="password" type="password" class="form-control @if($errors->has('password')) is-invalid @endif" name="password" required >
                                @if($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                <label for="password-confirm">{{ __('user.confirmPassword') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required >
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="phone">{{ __('user.phone') }}</label>
                                <input id="phone" type="text" class="form-control @if($errors->has('phone')) is-invalid @endif" name="phone" value="{{ old('phone') }}" required >
                                @if($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="company">{{ __('user.company') }}</label>
                                <input id="company" type="text" class="form-control @if($errors->has('company')) is-invalid @endif" name="company" value="{{ old('company') }}" required >
                                @if($errors->has('company'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('company') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="image">{{ __('user.image') }}</label>
                                <input id="image" type="file" class="p-2 form-control @if($errors->has('image')) is-invalid @endif" name="image">
                                @if($errors->has('image'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <button type="submit" class="btn btn-primary">
                            {{ __('user.register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
