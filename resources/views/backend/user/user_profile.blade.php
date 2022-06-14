@extends('layouts.app', [
'class' => 'sidebar-mini ',
'namePage' => __('profile.title'),
'activePage' => 'profile',
'activeNav' => '',
])

@section('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<!-- summernote -->
<link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="
                            @if($user->image == 'profile_default.png')
                            {{asset('/img/profile_default.png')}}
                            @else
                            {{asset('/img/profiles/'.$user->image)}}
                            @endif
                            " alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{$user->name}}</h3>
                        <p class="text-muted text-center">
                            {{$user->email}}
                            <br>
                            <small>ID: {{$user->id}}</small>
                        </p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>
                                    {{__('profile.user_status')}}
                                </b>
                                <a class="float-right">
                                    @if($user->status == 1)
                                    <b class="text-success"> {{ __('global.status.activated') }} </b>
                                    @else
                                    <b class="text-danger"> {{ __('global.status.deactivated')  }} </b>
                                    @endif
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>
                                    <a href=" {{route('2fa')}} " style="color: inherit;">
                                        {{__('profile.2fa_status')}}
                                    </a>
                                </b>
                                <a class="float-right">
                                    @if($user->loginSecurity->google2fa_enable ?? '')
                                    <b class="text-success"> {{ __('global.status.activated') }} </b>
                                    @else
                                    <b class="text-danger"> {{ __('global.status.deactivated')  }} </b>
                                    @endif
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>{{__('profile.last_ip')}}</b>
                                <a class="float-right">
                                    {{$user->last_login_ip}}
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>{{__('profile.last_login_at')}}</b>
                                <a class="float-right">
                                    {{$user->last_login_at}}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{__('profile.about_me')}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-phone mr-1"></i> {{__('global.phone')}}</strong>
                        <p class="text-muted">
                            {{$user->phone}}
                        </p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> {{__('global.location')}}</strong>
                        <p class="text-muted">{{$user->location}}</p>
                        <hr>
                        <strong><i class="far fa-file-alt mr-1"></i> {{__('global.notes')}}</strong>
                        <p class="text-muted">{!!$user->notes!!}</p>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal" action="{{route('profile.update', $user->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">{{__('global.name')}}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{$user->name}}" placeholder="{{__('global.name')}}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">{{__('global.email')}}</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{$user->email}}" placeholder="{{__('global.email')}}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-sm-2 col-form-label">{{__('global.phone')}}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{$user->phone}}" placeholder="{{__('global.phone')}}" data-inputmask='"mask": "(999) 9999-9999"' data-mask>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="location" class="col-sm-2 col-form-label">{{__('global.location')}}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{$user->location}}" placeholder="{{__('global.location')}}">
                                    @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-success btn-block">{{__('global.form.save')}}</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection

@section('scripts')
<!-- Select2 -->
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- bs-custom-file-input -->
<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<!-- Page specific script -->
<script>
    $(function() {
        bsCustomFileInput.init();

        //Initialize Select2 Elements
        $('.select2').select2({
            theme: 'bootstrap4'
        })

        // Summernote
        $('#summernote').summernote()

        // CodeMirror
        CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
            mode: "htmlmixed",
            theme: "monokai"
        });

        $('[data-mask]').inputmask()
    })
</script>
@endsection