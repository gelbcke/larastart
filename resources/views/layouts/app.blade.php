<!doctype html>
<html lang="{{ auth()->user()->language ?? app()->getLocale() }}">


@include('layouts.partials.head')



<body class="{{ $apply_theme->value('body') }}">
	<div class="wrapper">

		<!-- Preloader -->
		<div class="preloader flex-column justify-content-center align-items-center">
			<img class="animation__shake" src="{{ asset('img/' . config('app.name', 'Laravel') . 'Logo.png') }}"
				alt="{{ config('app.name', 'Laravel') }}Logo" height="60" width="60">
		</div>

		@include('sweetalert::alert')

		@include('layouts.partials.nav')

		@include('layouts.partials.sidebar')
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">

			@include('layouts.partials.header')

			<!-- Main content -->
			<section class="content">

				@yield('content')

			</section>
			<!-- /.content -->
			<a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
				<i class="fas fa-chevron-up"></i>
			</a>
		</div>
		<!-- /.content-wrapper -->
	</div>

	@include('layouts.partials.footer')

	<!-- jQuery -->
	<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	 $.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- overlayScrollbars -->
	<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('js/adminlte.js') }}"></script>
	<!-- Special page scripts -->

	@yield('scripts')

</body>

</html>
