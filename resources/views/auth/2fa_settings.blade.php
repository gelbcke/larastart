@extends('layouts.app', [
'class' => 'sidebar-mini ',
'namePage' => __('auth.title.2fa'),
'activePage' => '2fa',
'activeNav' => '',
'bodyPage' => 'login-page'
])

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <strong>{{ __('2fa.title') }}</strong>
        </div>
        <div class="card-body">
            <p>{{__('2fa.settings.about')}}</p>

            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if($data['user']->loginSecurity == null)
            <form class="form-horizontal" method="POST" action="{{ route('generate2faSecret') }}">
                @csrf
                @method('POST')
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        {{ __('2fa.settings.generate_2fa_button') }}
                    </button>
                </div>
            </form>
            @elseif(!$data['user']->loginSecurity->google2fa_enable)
            1. {{ __('2fa.settings.set_step_1') }}
            <br>
            <code>{{ $data['secret'] }}</code><br />
            {!! $data['google2fa_url'] !!}
            <br /><br />
            2. {{ __('2fa.settings.set_step_2') }} <br /><br />
            <form class="form-horizontal" method="POST" action="{{ route('enable2fa') }}">
                @csrf
                @method('POST')
                <div class="form-group{{ $errors->has('verify-code') ? ' has-error' : '' }}">
                    <label for="secret" class="control-label"> {{ __('2fa.settings.authenticator_code') }} </label>
                    <input id="secret" type="password" class="form-control col-md-4" name="secret" required>
                    @if ($errors->has('verify-code'))
                    <span class="help-block">
                        <strong>{{ $errors->first('verify-code') }}</strong>
                    </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">
                    {{ __('2fa.settings.enable_2fa_button') }}
                </button>
            </form>
            @elseif($data['user']->loginSecurity->google2fa_enable)
            <div class="alert alert-success">
                {!! __('2fa.settings.2fa_is_actived') !!}
            </div>
            <p>{{ __('2fa.settings.cancel_2fa_text') }}</p>
            <form class="form-horizontal" method="POST" action="{{ route('disable2fa') }}">
                @csrf
                @method('POST')
                <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                    <label for="change-password" class="control-label">{{ __('2fa.settings.current_password') }}</label>
                    <input id="current-password" type="password" class="form-control col-md-4" name="current-password" required>
                    @if ($errors->has('current-password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('current-password') }}</strong>
                    </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary ">{{ __('2fa.settings.cancel_2fa_button') }}</button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection