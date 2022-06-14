@extends('layouts.auth', [
'class' => 'sidebar-mini ',
'namePage' => __('auth.title.locked'),
'activePage' => 'locked',
'activeNav' => '',
'bodyPage' => 'lockscreen'
])

@section('styles')

@endsection

@section('content')
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
        <a href="{{url('/')}}" class="h1">
            <img src="{{asset('img/'.config('app.name').'Banner_trans.png')}}" alt="{{config('app.name')}} Banner" width="50%">
        </a>
    </div>
    <!-- User name -->
    <div class="lockscreen-name">{{Auth::user()->name}}</div>

    <!-- START LOCK SCREEN ITEM -->
    <div class="lockscreen-item">
        <!-- lockscreen image -->
        <div class="lockscreen-image">
            <img class="img-fluid img-circle" src=" @if(Auth::user()->image == 'profile_default.png'){{asset('/img/profile_default.png')}}@else{{asset('/images/profiles/'.$user->image)}}@endif" alt="User profile picture">
        </div>
        <!-- /.lockscreen-image -->

        <!-- lockscreen credentials (contains the form) -->
        <form method="POST" action="{{ route('login.unlock') }}" aria-label="{{ __('Locked') }}" class="lockscreen-credentials" autocomplete="off">
            @csrf
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="password" autocomplete="new-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <div class="input-group-append">
                    <button type="submit" class="btn">
                        <i class="fas fa-arrow-right text-muted"></i>
                    </button>
                </div>
            </div>
        </form>
        <!-- /.lockscreen credentials -->

    </div>
    <!-- /.lockscreen-item -->
    <div class="help-block text-center">
        Enter your password to retrieve your session
    </div>
    <div class="text-center">
        <a href="{{ route('logout') }}">Or sign in as a different user</a>
    </div>
    <div class="lockscreen-footer text-center">
        Copyright © 2019 - {{date('Y')}} | <b><a href="https://github.com/gelbcke/" target="_blank">Gelbcke - LaraStart</a></b><br>

    </div>
</div>
<!-- /.center -->

@endsection