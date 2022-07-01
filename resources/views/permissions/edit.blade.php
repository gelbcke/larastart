@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => __('permissions.title'),
    'activePage' => 'permissions',
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
								<h3 class="card-title">{{ __('global.form.edit') . ' ' . __('permissions.title') }}</h3>
								<br>
								<small>{!! __('permissions.editing_permission', ['name' => '<b>' . $permission->name . '</b>']) !!} </small>
							</div>
						</div>
						<div class="card-body">
							<form method="POST" action="{{ route('permissions.update', $permission->id) }}">
								@method('patch')
								@csrf
								<div class="mb-3">
									<label for="name" class="form-label">{{ __('global.name') . ' ' . __('permissions.title') }}</label>
									<input value="{{ $permission->name }}" type="text" class="form-control" name="name"
										placeholder="{{ __('global.name') . ' ' . __('permissions.title') }}" required>

									@if ($errors->has('name'))
										<span class="text-danger text-left">{{ $errors->first('name') }}</span>
									@endif
								</div>
								<div class="row">
									<!-- /.col -->
									<div class="col-3">
										<a href="{{ url()->previous() }}" class="btn btn-default btn-block">{{ __('global.form.go_back') }}</a>
									</div>
									<div class="col-9">
										<button type="submit"
											class="btn btn-primary btn-block">{{ __('global.form.update') . ' ' . __('permissions.title') }}</button>
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
