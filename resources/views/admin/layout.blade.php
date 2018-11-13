<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<title>{{ env('APP_NAME') }} - Admin Panel</title>

	<base href="/">
	@include ('layouts.styles')
	{!! cssComponent('css/admin') !!}

	<meta id="the-t" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	@yield ('css')
</head>

<body>
	<header class="header">
		<div class="container">
			
			<h1><span>{{ env('APP_NAME') }}</span> / Admin Panel</h1>
			
			<div class="menu-bar z-depth-3">
				
				<div class="menu-list">
					<a href="/admin" class="menu-item">
						<i class="icon fas fa-tachometer-alt"></i>
						@lang('buttons.admin_dash')
					</a>

					<a href="/admin/module/installer" class="menu-item">
						<i class="icon fas fa-hat-wizard"></i>
						@lang('buttons.admin_module_installer')
					</a>
				</div>
			</div>
		</div>
	</header>

	<div class="container">
		<div class="content-holder pull-up-content z-depth-3">
			@yield ('content')
		</div>
	</div>

	@include ('layouts.scripts')
	@yield ('scripts')
</body>
</html>
