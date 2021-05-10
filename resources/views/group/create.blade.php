@extends('layouts.master')

@section('title')
     {{__('group.createGroup')}}
@endsection

@push('breadcrumbs')
@include('partials.breadcrumbs',['group'=>__('group.groups'),'links'=> [
['url' =>route('user.index'),'name' => __('group.manageGroup')],
['url' =>'','name' => __('group.editGroup')],
]])
@endpush
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('group.store') }}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name">{{ __('group.groupName') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="details">{{ __('group.description') }}</label>
                                <input id="details" type="text" class="form-control @error('details') is-invalid @enderror" name="details" value="{{ old('details') }}" required>
                                @error('details')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <button type="submit" class="btn btn-primary">
                            {{ __('group.createGroup') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

