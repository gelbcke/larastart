@extends('layouts.auth', [
'class' => 'sidebar-mini ',
'namePage' => __('auth.title.request_new_password'),
'activePage' => 'reset_password',
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
            <p class="login-box-msg">{{__('auth.box_msg.set_new_password')}}</p>
            <form method="POST" action="{{ route('password.update') }}" autocomplete="off">
                @csrf
                <div class="input-group mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{__('global.password')}}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">{{__('auth.reset_password')}}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <hr>
            <p class="mt-3 mb-1">
                <a href="{{route('login')}}">{{__('auth.login')}}</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
@endsection