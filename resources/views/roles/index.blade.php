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
								<h3 class="card-title">{{ __('roles.title') }}</h3>
								<br>
								<small>{{ __('roles.description') }} </small>
							</div>
							<div class="card-tools">
								<a href="{{ route('roles.create') }}" class="btn btn-block btn-primary btn-xs">{{ __('global.form.create') }}
								</a>
							</div>
						</div>

						<table class="table-striped table">
							<tr>
								<th>{{ __('roles.role_name') }}</th>
								<th width="3%" colspan="3">{{ __('global.action') }}</th>
							</tr>
							@foreach ($roles as $role)
								<tr>
									<td>{{ $role->name }}</td>
									<td>
										<a class="btn btn-xs" href="{{ route('roles.show', $role->id) }}">
											<i class="fa-solid fa-eye"></i>
										</a>
									</td>
									<td>
										<a class="btn btn-xs" href="{{ route('roles.edit', $role->id) }}">
											<i class="fa-solid fa-pen-to-square"></i>
										</a>
									</td>
									<td>
										<form method="POST" action="{{ route('roles.destroy', $role->id) }}">
											{{ csrf_field() }}
											{{ method_field('DELETE') }}

											<button type="submit" class="btn delete-role btn-xs">
												<i class="fa-solid fa-trash text-danger"></i>
											</button>
										</form>
									</td>
								</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@section('scripts')
	<script>
	 $('.delete-role').click(function(e) {
	  e.preventDefault() // Don't post the form, unless confirmed
	  if (confirm('Are you sure?')) {
	   // Post the form
	   $(e.target).closest('form').submit() // Post the surrounding form
	  }
	 });
	</script>
@endsection
