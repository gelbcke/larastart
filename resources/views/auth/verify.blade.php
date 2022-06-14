@extends('layouts.auth', [
'class' => 'sidebar-mini ',
'namePage' => __('auth.title.verify'),
'activePage' => 'verify',
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
            <p class="login-box-msg">{{ __('auth.box_msg.verify_email') }}</p>
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('auth.click_here_to_request_another') }}</button>
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