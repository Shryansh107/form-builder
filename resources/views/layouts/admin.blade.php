<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
	{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	<!-- Meta data -->
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<!-- Title -->
	<title>{{$title}}</title>

	<!-- Inter + JetBrains Mono from Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

	@include('includes.css')
<style>
/* Cal.com global overrides */
html, body {
	font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
	color: #374151;
	background: #ffffff;
}
.app-content .side-app {
    padding: 20px 30px 0 30px !important;
}
/* Hide default bootstrap footer styling conflicts */
.footer {
	background: #101010 !important;
	border: none !important;
	color: #a1a1aa !important;
	padding: 32px 0 !important;
}
.footer a {
	color: #a1a1aa !important;
}
.footer .text-primary {
	color: #ffffff !important;
	font-weight: 600;
}
</style>
</head>


@include('includes.navigation')
@yield('content')

<!--/Footer-->
</div>

<!-- Back to top -->
<a href="#top" id="back-to-top" style="background: #111111; color: #ffffff;"><i class="fa fa-long-arrow-up"></i></a>

@include('includes.js')

</body>

</html>