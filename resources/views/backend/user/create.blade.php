@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => __('users.title'),
    'activePage' => 'users',
    'activeNav' => '',
])

@section('content')
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<p class="login-box-msg">{{ __('auth.register_new_member') }}</p>

							<form method="POST" action="{{ route('users.store') }}" autocomplete="off">
								@csrf
								@method('POST')
								<div class="input-group mb-3">
									<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
										value="{{ old('name') }}" required autocomplete="name" placeholder="{{ __('global.name') }}" autofocus>

									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-user"></span>
										</div>
									</div>
									@error('name')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
								<div class="input-group mb-3">
									<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
										value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('global.email') }}">

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
									<input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
										name="password" placeholder="{{ __('global.password') }}" required autocomplete="new-password">

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

								<div class="mb-3">
									<label for="role" class="form-label">Role</label>
									<select class="form-control" name="role" required>
										<option value="">Select role</option>
										@foreach ($roles as $role)
											<option value="{{ $role->name }}">
												{{ $role->name }}</option>
										@endforeach
									</select>
									@if ($errors->has('role'))
										<span class="text-danger text-left">{{ $errors->first('role') }}</span>
									@endif
								</div>

								<div class="row">
									<!-- /.col -->
									<div class="col-3">
										<a href="{{ url()->previous() }}" class="btn btn-default btn-block">{{ __('global.form.go_back') }}</a>
									</div>
									<div class="col-9">
										<button type="submit" class="btn btn-flat btn-primary btn-block">{{ __('auth.register') }}</button>
									</div>
									<!-- /.col -->
								</div>
							</form>
						</div>
						<!-- /.form-box -->
					@endsection
