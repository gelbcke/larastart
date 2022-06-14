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
            <p class="login-box-msg">{{__('auth.sign_in_to_start') }} </p>
            <form method="POST" action="{{ route('login') }}" autocomplete="off">
                @csrf
                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
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
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">
                                {{__('auth.remember_me') }}
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-flat btn-primary btn-block">
                            {{__('auth.login') }}
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <hr>
            <p class="mb-1">
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-center">
                    {{__('auth.forgot_password') }}
                </a>
                @endif
            </p>
            <p class="mb-0">
                <a href="{{route('register')}}" class="text-center">{{__('auth.register_new_member')}}</a>
            </p>
        </div>
        <!-- /.card-body -->
    </div>
</div>
@endsection