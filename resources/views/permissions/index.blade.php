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
								<h3 class="card-title">{{ __('permissions.title') }}</h3>
								<br>
								<small>{{ __('permissions.description') }}</small>
							</div>
							<div class="card-tools">
								<a href="{{ route('permissions.create') }}"
									class="btn btn-block btn-primary btn-xs">{{ __('global.form.create') }}
								</a>
							</div>
						</div>
						<table class="table-striped table-sm table">
							<thead>
								<tr>
									<th width="30%">{{ __('global.name') }}</th>
									<th>Guard</th>
									<th colspan="3" width="1%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach ($permissions as $permission)
									<tr>
										<td>{{ $permission->name }}</td>
										<td>{{ $permission->guard_name }}</td>
										<td>
											<a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-xs">
												<i class="fa-solid fa-pen-to-square"></i>
											</a>
										</td>
										<td>
											<form method="POST" action="{{ route('permissions.destroy', $permission->id) }}">
												{{ csrf_field() }}
												{{ method_field('DELETE') }}
												<button type="submit" class="btn delete-permission btn-xs">
													<i class="fa-solid fa-trash text-danger"></i>
												</button>
											</form>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@section('scripts')
	<script>
	 $('.delete-permission').click(function(e) {
	  e.preventDefault() // Don't post the form, unless confirmed
	  if (confirm('Are you sure?')) {
	   // Post the form
	   $(e.target).closest('form').submit() // Post the surrounding form
	  }
	 });
	</script>
@endsection
