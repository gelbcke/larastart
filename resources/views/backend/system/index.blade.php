@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => __('system_settings.title'),
    'activePage' => 'system_settings',
    'activeNav' => '',
])

@section('content')
	<section class="content">

		<!-- Default box -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"> {{ __('system_settings.text') }} </h3>

				<div class="card-tools">
					<a class="btn btn-default" href="{{ route('system_settings.edit') }}" title="Edit">
						{{ __('global.form.edit') }}
					</a>
				</div>
			</div>
			<table class="table-striped table">
				<thead>
					<tr>
						<th style="width: 20%">#</th>
						<th> {{ __('global.description') }} </th>
						<th style="width: 10%"></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ __('system_settings.currency') }}</td>
						<td><b>{{ __('global.name') }}:</b> {{ $settings[0]->currency->name }} | <b>Code:</b>
							{{ $settings[0]->currency->code }} | <b>Symbol:</b> {{ $settings[0]->currency->symbol }}</td>
						<td><span class="badge bg-danger">{{ $app_s->currency->symbol . ' ' . number_format(1255, 2) }}</span></td>
					</tr>
					<tr>
						<td>{{ __('system_settings.timezone') }}</td>
						<td><b>{{ __('global.name') }}:</b> {{ $settings[0]->timezone->name }} | <b>Offset:</b>
							{{ $settings[0]->timezone->offset }}</td>
						<td><span class="badge bg-danger">{{ now() }}</span></td>
					</tr>
					<tr>
						<td>{{ __('system_settings.clock_format') }}</td>
						<td>{{ $settings[0]->clock_format }}</td>
						<td><span class="badge bg-danger">{{ now()->format($app_s->clock_format) }}</span></td>
					</tr>
					<tr>
						<td>{{ __('system_settings.date_format') }}</td>
						<td>{{ $settings[0]->date_format }}</td>
						<td><span class="badge bg-danger">{{ now()->format($app_s->date_format) }}</span></td>
					</tr>
					<tr>
						<td>{{ __('system_settings.datetime_format') }}</td>
						<td>{{ $settings[0]->datetime_format }}</td>
						<td><span class="badge bg-danger">{{ now()->format($app_s->datetime_format) }}</span></td>
					</tr>
				</tbody>
			</table>
			<div class="card-footer text-right">
				Last Update: {{ $settings[0]->updated_at->format($app_s->datetime_format) }}
			</div>
			<!-- /.card-footer-->
		</div>
		<!-- /.card -->
	</section>
@endsection
