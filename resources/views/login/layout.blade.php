<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<title>{{ env('APP_NAME') }}</title>

	<base href="/">
	@include ('layouts.styles')
	{!! cssComponent('css/login') !!}

	<meta id="the-t" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	@yield ('css')
</head>

<body>

	@include ('layouts.scripts')
	@yield ('scripts')

	@yield ('content')
</body>
</html>
