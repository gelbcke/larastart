@extends('layouts.auth', [
'class' => 'sidebar-mini ',
'namePage' => __('auth.title.login'),
'activePage' => 'login',
'activeNav' => '',
'bodyPage' => 'login-page'
])

@section('content')
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="{{url('/')}}" class="h1">
                <img src="{{asset('img/'.config('app.name').'Banner_trans.png')}}" alt="{{config('app.name')}} Banner" width="100%">
            </a>
        </div>
        <div class="card-body">
            <div class="card-header">
                <h3 class="card-title">Two Factor Authentication</h3>
            </div>

            <div class="card-body">
                <small>Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.</small>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <hr>
                <p style="text-align: center">Enter the pin from Google Authenticator app:</p>
                <form class="form-horizontal" action="{{ route('2faVerify') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="input-group mb-3">
                        <input id="one_time_password" type="number" class="form-control @error('one_time_password-code') is-invalid @enderror" name="one_time_password" placeholder="XXX-XXX" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('one_time_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">Authenticate</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection