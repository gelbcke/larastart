<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>{{ config('app.name') }} - Welcome</title>

	<!-- Favicons -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/img/favicon/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/img/favicon/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/img/favicon/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('/img/favicon/site.webmanifest') }}">
	<link rel="mask-icon" href="{{ asset('/img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="theme-color" content="#ffffff">

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

	<!-- Styles -->
	<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

	@yield('styles')

</head>

<body>
	<div class="wrapper">
		<!-- Main content -->
		<section class="content">
			<!-- Default box -->
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">{{ __('global.welcome.project_detail') }}</h3>
					<div class="card-tools">
						<a type="button" href="{{ route('home') }}" class="btn btn-tool">
							{{ __('global.welcome.go_to_system') }} <i class="fas fa-arrow-right"></i>
						</a>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12 col-md-12 col-lg-8 order-md-1 order-2">
							<div class="row">
								<div class="col-12 col-sm-6">
									<div class="info-box bg-light">
										<div class="info-box-content">
											<span class="info-box-text text-muted text-center">Global Currency variable </span>
											<code class="text-center"> $app_s->currency </code>
											<span
												class="info-box-number text-muted mb-0 text-center">{{ $app_s->currency->symbol . ' ' . number_format(1255, 2) }}</span>
										</div>
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="info-box bg-light">
										<div class="info-box-content">
											<span class="info-box-text text-muted text-center">Global Date format variable</span>
											<code class="text-center"> $app_s->date_format </code>
											<span class="info-box-number text-muted mb-0 text-center">{{ now()->format($app_s->date_format) }}</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-sm-6">
									<div class="info-box bg-light">
										<div class="info-box-content">
											<span class="info-box-text text-muted text-center">Global Time format variable</span>
											<code class="text-center"> $app_s->clock_format </code>
											<span class="info-box-number text-muted mb-0 text-center">{{ now()->format($app_s->clock_format) }}</span>
										</div>
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="info-box bg-light">
										<div class="info-box-content">
											<span class="info-box-text text-muted text-center">Global Date and Time format variable</span>
											<code class="text-center"> $app_s->datetime_format </code>
											<span
												class="info-box-number text-muted mb-0 text-center">{{ now()->format($app_s->datetime_format) }}</span>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-12">
									<h4>{{ __('global.welcome.more_info_title') }}</h4>
									<div class="post">
										<div class="user-block">
											<span class="username" style="margin-left: 0;">
												<a href="https://github.com/gelbcke/" target="_blank">Ney Gelbcke Junior</a>
											</span>
											<span class="description" style="margin-left: 0;">{{ __('global.welcome.more_info_details') }}</span>
										</div>
										<!-- /.user-block -->

										<h6>For securty reasons:</h6>
										<br>
										<li>The User ID is UUID</li>
										<li>Is possible to activate 2FA to all users of the system, by the Admin</li>
										<hr>

										<h6>Global variables about the system could be set on <i>"/system_settings"</i> url. The available variable
											are:</h6>
										<br>
										<b>$app_s</b> = Give everything on SystemSettings-><i>object</i>
										<br>
										<b>$timezone</b> = Give the timezone name.
										- Ex. America/Sao_Paulo
										<br> * To get offset: <code>$app_s->timezone->offset</code>
										<br>
										<b>$currency</b> = Give the currency symbol.
										- Ex. R$
										<br> * To get currency code: <code>$app_s->curency->code</code>
										<br> * To get currency name: <code>$app_s->curency->name</code>

										<hr>

										<h6>The user can personalize you own profile on <i>"/profile/{id}"</i>. The options are:</h6>
										<br>
										<li>Themes</li>
										<li>Language</li>
										<li>Profile Photo</li>
										<li>Personalized notes</li>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-4 order-md-2 order-1">
							<h3 class="text-primary">
								<a href="https://github.com/gelbcke/" target="_blank">
									<i class="fas fa-cog"></i> LaraStart
								</a>
							</h3>
							<h5 class="text-primary"><i class="fas fa-paint-brush"></i> AdminLTE v3</h5>
							<p class="text-muted"><b>Atention! </b>
								<br>
								This page is only a example, and the documentation is under construction. Check the updates and more details on
								<a href="https://github.com/gelbcke/" target="_blank">GitHub </a>
							</p>
							<br>
							<div class="text-muted">
								<p class="text-sm">Project Leader (Back-end)
									<b class="d-block">Ney Gelbcke Junior</b>
								</p>
								<p class="text-sm">Front-end
									<b class="d-block">AdminLTE v3.0.2 (edited)</b>
								</p>
							</div>
						</div>
					</div>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</section>
		<!-- /.content -->
	</div>
</body>

</html>
