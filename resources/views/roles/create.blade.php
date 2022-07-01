@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => __('roles.title'),
    'activePage' => 'roles',
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
								<h3 class="card-title">{{ __('roles.create.title') }}</h3>
								<br>
								<small>{{ __('roles.create.description') }}</small>
							</div>
						</div>
						<div class="card-body">
							@if (count($errors) > 0)
								<div class="alert alert-danger">
									<strong>Whoops!</strong> There were some problems with your input.<br><br>
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif
							<form method="POST" action="{{ route('roles.store') }}">
								@csrf
								<div class="mb-3">
									<label for="name" class="form-label">{{ __('roles.role_name') }}</label>
									<input value="{{ old('name') }}" type="text" class="form-control" name="name" placeholder="Name"
										required>
								</div>
								<label for="permissions" class="form-label">{{ __('roles.assign_permissions') }}</label>
								<table class="table-striped table">
									<thead>
										<th scope="col" width="1%"><input type="checkbox" name="all_permission"></th>
										<th scope="col" width="20%">{{ __('permissions.title') }}</th>
										<th scope="col" width="1%">Guard</th>
									</thead>
									@foreach ($permissions as $permission)
										<tr>
											<td>
												<input type="checkbox" name="permission[{{ $permission->name }}]" value="{{ $permission->name }}"
													class='permission'>
											</td>
											<td>{{ $permission->name }}</td>
											<td>{{ $permission->guard_name }}</td>
										</tr>
									@endforeach
								</table>
								<div class="row">
									<!-- /.col -->
									<div class="col-3">
										<a href="{{ url()->previous() }}" class="btn btn-default btn-block">
											{{ __('global.form.go_back') }}
										</a>
									</div>
									<div class="col-9">
										<button type="submit" class="btn btn-primary btn-block">
											{{ __('global.form.save') . ' ' . __('roles.role') }}
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

@section('scripts')
	<script type="text/javascript">
	 $(document).ready(function() {
	  $('[name="all_permission"]').on('click', function() {

	   if ($(this).is(':checked')) {
	    $.each($('.permission'), function() {
	     $(this).prop('checked', true);
	    });
	   } else {
	    $.each($('.permission'), function() {
	     $(this).prop('checked', false);
	    });
	   }

	  });
	 });
	</script>
@endsection
