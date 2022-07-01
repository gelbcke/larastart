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
								<h3 class="card-title">{{ __('global.form.create') . ' ' . __('permissions.title') }}</h3>
								<br>
								<small>{{ __('permissions.create.description') }}</small>
							</div>
						</div>
						<div class="card-body">
							<form method="POST" action="{{ route('permissions.store') }}">
								@csrf
								<div class="mb-3">
									<label for="name" class="form-label">{{ __('global.name') . ' ' . __('permissions.title') }}</label>
									<input value="{{ old('name') }}" type="text" class="form-control" name="name" placeholder="Name"
										required>

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
											class="btn btn-primary btn-block">{{ __('global.form.save') . ' ' . __('permissions.title') }}
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
