@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => __('profile.title'),
    'activePage' => 'my_profile',
    'activeNav' => '',
])

@section('styles')
	<!-- Select2 -->
	<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
	<!-- summernote -->
	<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
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
								<img class="profile-user-img img-fluid img-circle"
									src="
                            @if (Auth::user()->image == 'profile_default.png') {{ asset('/img/profile_default.png') }}
                            @else
                            {{ asset('/img/profiles/' . $user->image) }} @endif
                            "
									alt="User profile picture">
							</div>
							<h3 class="profile-username text-center">{{ $user->name }}</h3>
							<p class="text-muted text-center">
								{{ $user->email }}
								<br>
								<small>ID: {{ $user->id }}</small>
							</p>

							<ul class="list-group list-group-unbordered mb-3">
								<li class="list-group-item">
									<b>
										{{ __('profile.user_status') }}
									</b>
									<a class="float-right">
										@if ($user->status == 1)
											<b class="text-success"> {{ __('global.status.activated') }} </b>
										@else
											<b class="text-danger"> {{ __('global.status.deactivated') }} </b>
										@endif
									</a>
								</li>
								<li class="list-group-item">
									<b>
										<a href=" {{ route('2fa') }} " style="color: inherit;">
											{{ __('profile.2fa_status') }}
										</a>
									</b>
									<a class="float-right">
										@if ($user->loginSecurity->google2fa_enable ?? '')
											<b class="text-success"> {{ __('global.status.activated') }} </b>
										@else
											<b class="text-danger"> {{ __('global.status.deactivated') }} </b>
										@endif
									</a>
								</li>
								<li class="list-group-item">
									<b>{{ __('global.role') }}</b>
									<a class="float-right" href="{{ route('roles.show', $user->roles->first()->id) }}">
										{{ $user->roles->first()->name }}
									</a>
								</li>
								<li class="list-group-item">
									<b>{{ __('profile.last_ip') }}</b>
									<a class="float-right">
										{{ $user->last_login_ip }}
									</a>
								</li>
								<li class="list-group-item">
									<b>{{ __('profile.last_login_at') }}</b>
									<a class="float-right">
										{{ $user->last_login_at }}
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
							<h3 class="card-title">{{ __('profile.note_about_me') }}</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<strong><i class="fas fa-phone mr-1"></i> {{ __('global.phone') }}</strong>
							<p class="text-muted">
								{{ $user->phone }}
							</p>
							<hr>
							<strong><i class="fas fa-map-marker-alt mr-1"></i> {{ __('global.location') }}</strong>
							<p class="text-muted">{{ $user->location }}</p>
							<hr>
							<strong><i class="far fa-file-alt mr-1"></i> {{ __('global.notes') }}</strong>
							<p class="text-muted">{!! $user->notes !!}</p>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.col -->
				<div class="col-md-9">
					<div class="card">
						<div class="card-header p-2">
							<ul class="nav nav-pills">
								<li class="nav-item">
									<a class="nav-link active" href="#timeline" data-toggle="tab">
										{{ __('profile.timeline') }}
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#settings" data-toggle="tab">
										{{ __('profile.settings') }}
									</a>
								</li>
								@if ($user->id == Auth::user()->id)
									<li class="nav-item">
										<a class="nav-link" href="{{ route('2fa') }}">
											{{ __('2fa.title') }}
										</a>
									</li>
								@endif
							</ul>
						</div><!-- /.card-header -->
						<div class="card-body">
							<div class="tab-content">
								<!-- /.tab-pane -->
								<div class="tab-pane active" id="timeline">
									<!-- The timeline -->
									<div class="timeline timeline-inverse">
										<!-- timeline time label -->
										<div class="time-label">
											<span class="bg-danger">
												{{ now()->format($app_s->date_format) }}
											</span>
										</div>
										<!-- /.timeline-label -->
										<!-- timeline item -->
										<div>
											<i class="fas fa-envelope bg-primary"></i>

											<div class="timeline-item">
												<span class="time"><i class="far fa-clock"></i> 12:05</span>

												<h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

												<div class="timeline-body">
													Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
													weebly ning heekya handango imeem plugg dopplr jibjab, movity
													jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
													quora plaxo ideeli hulu weebly balihoo...
												</div>
												<div class="timeline-footer">
													<a href="#" class="btn btn-primary btn-sm">Read more</a>
													<a href="#" class="btn btn-danger btn-sm">Delete</a>
												</div>
											</div>
										</div>
										<!-- END timeline item -->
										<!-- timeline item -->
										<div>
											<i class="fas fa-user bg-info"></i>

											<div class="timeline-item">
												<span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

												<h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
												</h3>
											</div>
										</div>
										<!-- END timeline item -->
										<!-- timeline item -->
										<div>
											<i class="fas fa-comments bg-warning"></i>

											<div class="timeline-item">
												<span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

												<h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

												<div class="timeline-body">
													Take me to your leader!
													Switzerland is small and neutral!
													We are more like Germany, ambitious and misunderstood!
												</div>
												<div class="timeline-footer">
													<a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
												</div>
											</div>
										</div>
										<!-- END timeline item -->
										<!-- timeline time label -->
										<div class="time-label">
											<span class="bg-success">
												{{ $user->created_at->format($app_s->date_format) ?? '' }}
											</span>
										</div>
										<!-- /.timeline-label -->
										<div>
											<i class="far fa-clock bg-gray"></i>
										</div>
									</div>
								</div>
								<!-- /.tab-pane -->

								<div class="tab-pane" id="settings">
									<form class="form-horizontal" action="{{ route('profile.update', $user->id) }}" method="POST"
										enctype="multipart/form-data">
										@csrf
										@method('POST')
										<div class="form-group row">
											<label for="name" class="col-sm-2 col-form-label">{{ __('global.name') }}</label>
											<div class="col-sm-10">
												<input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
													name="name" value="{{ $user->name }}" placeholder="{{ __('global.name') }}">
												@error('name')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>

										<div class="form-group row">
											<label for="email" class="col-sm-2 col-form-label">{{ __('global.email') }}</label>
											<div class="col-sm-10">
												<input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
													name="email" value="{{ $user->email }}" placeholder="{{ __('global.email') }}">
												@error('email')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>

										<div class="form-group row">
											<label for="phone" class="col-sm-2 col-form-label">{{ __('global.phone') }}</label>
											<div class="col-sm-10">
												<input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
													name="phone" value="{{ $user->phone }}" placeholder="{{ __('global.phone') }}"
													data-inputmask='"mask": "(999) 9999-9999"' data-mask>
												@error('phone')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>

										<div class="form-group row">
											<label for="location" class="col-sm-2 col-form-label">{{ __('global.location') }}</label>
											<div class="col-sm-10">
												<input type="text" class="form-control @error('location') is-invalid @enderror" id="location"
													name="location" value="{{ $user->location }}" placeholder="{{ __('global.location') }}">
												@error('location')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>

										<div class="form-group row">
											<label for="theme" class="col-sm-2 col-form-label">{{ __('global.theme') }}</label>
											<div class="col-sm-10">
												<select class="form-control @error('theme') is-invalid @enderror" id="theme" name="theme">
													@foreach ($avl_themes as $theme)
														<option value="{{ $theme->name }}" @if ($user->theme == $theme->name) selected="selected" @endif>
															{{ $theme->name }}</option>
													@endforeach
												</select>
												@error('theme')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>

										<div class="form-group row">
											<label for="language" class="col-sm-2 col-form-label">{{ __('global.language') }}</label>
											<div class="col-sm-10">
												<select class="custom-select" id="language @error('language') is-invalid @enderror" name="language">
													@foreach ($languages as $language)
														<option value="{{ $language }}" @if ($user->language == $language) selected @endif>
															{{ $language }}</option>
													@endforeach
												</select>
												@error('language')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>

										<div class="form-group row">
											<label for="lockout_time" class="col-sm-2 col-form-label">{{ __('global.lockout_time') }}</label>
											<div class="col-sm-10">
												<input type="number" class="form-control @error('lockout_time') is-invalid @enderror" id="lockout_time"
													name="lockout_time" value="{{ $user->lockout_time }}"
													placeholder="{{ __('global.lockout_time') }}">

												@error('lockout_time')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>

										<div class="form-group row">
											<label for="image" class="col-sm-2 col-form-label">{{ __('profile.my_photo') }}</label>
											<div class="input-group col-sm-10">
												<div class="custom-file">
													<input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image"
														name="image">
													<label class="custom-file-label" for="image">{{ __('global.form.choose_file') }}</label>
													@error('image')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
										</div>

										<div class="form-group row">
											<label for="notes" class="col-sm-2 col-form-label">{{ __('profile.note_about_me') }}</label>
											<div class="col-sm-10">
												<textarea id="summernote" style="display: none;" id="notes" name="notes"> {!! $user->notes !!} </textarea>
												@error('notes')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>

										<div class="form-group row">
											<div class="offset-sm-2 col-sm-10">
												<button type="submit" class="btn btn-success btn-block">{{ __('global.form.save') }}</button>
											</div>
										</div>
									</form>
								</div>
								<!-- /.tab-pane -->
							</div>
							<!-- /.tab-content -->
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
	<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
	<!-- InputMask -->
	<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
	<script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
	<!-- Summernote -->
	<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
	<!-- bs-custom-file-input -->
	<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
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

	 //Keep on same tab after update
	 $('a[data-toggle="tab"]').click(function(e) {
	  e.preventDefault();
	  $(this).tab('show');
	 });

	 $('a[data-toggle="tab"]').on("shown.bs.tab", function(e) {
	  var id = $(e.target).attr("href");
	  localStorage.setItem('selectedTab', id)
	 });

	 var selectedTab = localStorage.getItem('selectedTab');
	 if (selectedTab != null) {
	  $('a[data-toggle="tab"][href="' + selectedTab + '"]').tab('show');
	 }
	</script>
@endsection
