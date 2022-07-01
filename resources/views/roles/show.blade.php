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
								<h3 class="card-title"> {!! __('roles.show.role_name', ['name' => '<b>' . ucfirst($role->name) . '</b>']) !!} </h3>
								<br>
								<small>{{ __('roles.show.description') }}</small>
							</div>
						</div>
						<table class="table-striped table">
							<thead>
								<th scope="col" width="20%">{{ __('permissions.title') }}</th>
								<th scope="col" width="1%">Guard</th>
							</thead>

							@foreach ($rolePermissions as $permission)
								<tr>
									<td>{{ $permission->name }}</td>
									<td>{{ $permission->guard_name }}</td>
								</tr>
							@endforeach

						</table>
					</div>
					<div class="card-body">
						<div class="row">
							<!-- /.col -->
							<div class="col-12">
								<a href="{{ url()->previous() }}" class="btn btn-default btn-block">{{ __('global.form.go_back') }}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
