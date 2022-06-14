@extends('layouts.auth', [
'class' => 'sidebar-mini ',
'namePage' => __('auth.title.confirm_password'),
'activePage' => 'confirm_password',
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
            <p class="login-box-msg"> {{ __('auth.msg_box.confirm_password') }}</p>
            <form method="POST" action="{{ route('password.confirm') }}" autocomplete="off">
                @csrf
                <div class="input-group mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

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
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('auth.confirm_password') }}</button>
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