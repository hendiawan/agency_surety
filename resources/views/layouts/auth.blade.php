<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Laravel') }}</title>

	<link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-ipad-retina.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-iphone-retina.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-ipad.png" />
	<link rel="apple-touch-icon" sizes="57x57" href="apple-touch-icon-iphone.png" />
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

	<!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-3.3.7/css/bootstrap.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/font-awesome-4.7/css/font-awesome.min.css') }}"/>
     <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}"/>

	<!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
	
</head>
<body>
	<div id="loading">
		<div>
			<div></div>
		    <div></div>
		    <div></div>
		</div>
	</div>

	@yield('content')

	<div class="clearfix"></div>
	<div id="footer">
		2017 &copy; Surety Bond Online v1.0. Powered by <a href="#">CalateSectorSeven</a>
	</div>

	<script type="text/javascript" src="{{ asset('/js/jquery.js') }}"></script>	
	<script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
	<script>
		$(window).load(function(){
			$('#loading').fadeOut(1000);
		});
	</script>
</body>
</html>