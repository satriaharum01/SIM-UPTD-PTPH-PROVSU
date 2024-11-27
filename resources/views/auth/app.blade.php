<!DOCTYPE html>
<html>
<head>
	<title>Login | {{env('APP_NAME')}}</title>
 	<link rel="shortcut icon" href="{{ asset('assets/img/logo.png')}}" type="image/gif" />
	<link rel="stylesheet" type="text/css" href="{{asset('static/css/main.css')}}">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

	<div class="container">
        @yield('content')
		<h2><center><br>{{env('APP_DETAIL')}}</center></h2>
    </div>

    <script type="text/javascript" src="{{asset('static/js/main.js')}}"></script>
</body>
</html>

    