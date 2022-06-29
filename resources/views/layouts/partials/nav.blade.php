<!-- Navbar -->
<nav class="{{ $apply_theme->value('nav') }}">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="{{ route('home') }}" class="nav-link">{{ __('layouts.home') }}</a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="{{ route('profile', auth()->user()->id) }}" class="nav-link">{{ __('layouts.profile') }}</a>
		</li>
	</ul>
	<ul class="navbar-nav ml-auto">
		<li class="nav-item dropdown">
			<a class="nav-link">
				<div id="clock">
					<b>{{ \Carbon\Carbon::now()->setTimezone($app_s->timezone->name)->format($app_s->clock_format) }}</b>
				</div>
			</a>
		</li>
	</ul>
	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<!-- Language Dropdown Menu -->
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
				@if (auth()->user()->language == 'en')
					<i class="flag-icon flag-icon-us"></i>
				@elseif(auth()->user()->language == 'pt_BR')
					<i class="flag-icon flag-icon-br"></i>
				@endif
			</a>
			<div class="dropdown-menu dropdown-menu-right p-0">
				<a href="{{ route('lang.update', 'en') }}" class="dropdown-item @if (auth()->user()->language == 'en') active @endif">
					<i class="flag-icon flag-icon-us mr-2"></i> English
				</a>
				<a href="{{ route('lang.update', 'pt_BR') }}"
					class="dropdown-item @if (auth()->user()->language == 'pt_BR') active @endif">
					<i class="flag-icon flag-icon-br mr-2"></i> Portuguese
				</a>
				<a href="#" class="dropdown-item">
					<i class="flag-icon flag-icon-de mr-2"></i> German (Not available)
				</a>
				<a href="#" class="dropdown-item">
					<i class="flag-icon flag-icon-fr mr-2"></i> French (Not available)
				</a>
				<a href="#" class="dropdown-item">
					<i class="flag-icon flag-icon-es mr-2"></i> Spanish (Not available)
				</a>
			</div>
		</li>

		<li class="nav-item dropdown">
			<a class="nav-link" href="#" data-toggle="dropdown">
				{{ explode(' ', auth()->user()->name)[0] }}
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<a href="{{ route('profile', auth()->user()->id) }}" class="dropdown-item">
					{{ __('layouts.profile') }}
				</a>
				<a href="{{ route('users.index') }}" class="dropdown-item">
					{{ __('layouts.users') }}
				</a>
				<a href="{{ route('logs.index') }}" class="dropdown-item">
					{{ __('layouts.logs') }}
				</a>
				<a href="{{ route('system_settings') }}" class="dropdown-item">
					{{ __('layouts.system_settings') }}
				</a>
				<a class="dropdown-item" href="{{ route('logout') }}"
					onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
					{{ __('layouts.logout') }}
				</a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
					@csrf
				</form>
			</div>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="{{ route('users.lockscreen') }}" role="button" title="{{ __('auth.lock') }}">
				<i class="fas fa-lock"></i>
			</a>
		</li>
	</ul>
</nav>
<!-- /.navbar -->
