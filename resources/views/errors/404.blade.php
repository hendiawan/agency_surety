<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ config('app.name', 'Laravel') }}</title>

	<link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-ipad-retina.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-iphone-retina.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-ipad.png" />
	<link rel="apple-touch-icon" sizes="57x57" href="apple-touch-icon-iphone.png" />
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

	<!-- bootstrap -->
    <link href="{{ asset('/css/bootstrap-3.3.7/css/bootstrap.css') }}" rel="stylesheet" />    
    <link rel="stylesheet" href="{{ asset('/css/font-awesome-4.7/css/font-awesome.min.css') }}"> 
	<link href="{{ asset('/css/style.css') }}" rel="stylesheet" type="text/css" />

	
</head>
<body>
	<div id="top">
		<div id="topBar">
			<div class="wrapper20">
				<a class="logo" href="{{ url('/home') }}">
					<img src="{{ url('/images') }}/logo.png" rel="logo">
				</a>
			</div>
		</div> <!-- /topBar -->
		
	</div> <!-- /top -->
			

	
	<a href="{{ url('/home') }}" class="hexagon hexa-widget aqua ttip hex-error" data-ttip="Come back home..."><i class="fa fa-frown-o"></i></a>

	<div class="clearfix"></div>
	<div id="footer" class="footerror">
		<h1>Error 404</h1>
	</div>

	<script type="text/javascript" src="{{ asset('/js/jquery.js') }}"></script>

	
</body>
</html>