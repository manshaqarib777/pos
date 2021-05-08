@extends('layouts.simple')

@section('content')
<div class="container">
    <div class="row justify-content-center pt-5">
        <div class="col-md-8 mt-5">
            <div class="card">
                <div class="card-header bg-warning text-white">{{ __('user.verifyYourEmailAddress') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('user.freshLinlSentMessage') }}
                        </div>
                    @endif

                    {{ __('user.b4ProcessingMessage') }}
                    {{ __('user.didNotRececive') }}, <a href="{{ route('verification.resend') }}">{{ __('user.anOtherRequest') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
