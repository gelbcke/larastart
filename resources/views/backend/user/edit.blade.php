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
						<div class="card-header">
							<div class="card-title">
								<h3 class="card-title">{{ __('global.form.update') . ' ' . $user->name }}</h3>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">

							<form method="post" action="{{ route('users.update', $user->id) }}">
								@method('patch')
								@csrf
								<div class="mb-3">
									<label for="name" class="form-label">{{ __('global.name') }}</label>
									<input value="{{ $user->name }}" type="text" class="form-control" name="name" placeholder="Name"
										required>

									@if ($errors->has('name'))
										<span class="text-danger text-left">{{ $errors->first('name') }}</span>
									@endif
								</div>
								<div class="mb-3">
									<label for="email" class="form-label">{{ __('global.email') }}</label>
									<input value="{{ $user->email }}" type="email" class="form-control" name="email"
										placeholder="Email address" required>
									@if ($errors->has('email'))
										<span class="text-danger text-left">{{ $errors->first('email') }}</span>
									@endif
								</div>
								<div class="mb-3">
									<label for="role" class="form-label">{{ __('global.role') }}</label>
									<select class="form-control" name="role" required>
										<option value="">{{ __('global.form.select') . ' ' . __('global.role') }} </option>
										@foreach ($roles as $role)
											<option value="{{ $role->name }}" {{ in_array($role->name, $userRole) ? 'selected' : '' }}>
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
										<button type="submit" class="btn btn-primary btn-block">
											{{ __('global.form.update') }}
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
