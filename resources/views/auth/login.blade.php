<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/png" href="/img/logos/logo_fav.png"/>

    <title>Senderos</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/argon.css" rel="stylesheet">
    <link href="css/nifty.min.css" rel="stylesheet">
    <link href="premium/icon-sets/icons/line-icons/premium-line-icons.min.css" rel="stylesheet">
    <link href="premium/icon-sets/icons/solid-icons/premium-solid-icons.min.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/argon.css?v=1.1.0" type="text/css">
	<link rel="stylesheet" href="argon.css">
	  <link rel="stylesheet" href="assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
    {{--<link href="css/pace.min.css" rel="stylesheet">
    <script src="js/pace.min.js"></script>
	
    <link href="temp.css" rel="stylesheet"> --}}
</head>

<body style=background-image:url(/img/bg-img/gris.jpg);">
</body>

    <div class="main-content"> 
    <!-- Header -->
    <div class="header py-7 py-lg-8 pt-lg-9">
      <div class="container">
          <div class="row justify-content-center">
            <div class="container">
             
    </div>
    <!-- Page content -->
    <div class="container mt--1 pb-8">
      <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
          <div class="card bg-dark border-0 mb-0">
            <div class="card-header bg- pb-5">
              <div class="btn-wrapper text-center">
              <img src="/img/logos/logo.png" class="img-responsive">
              </div>
            </div>
            <div class="card-body px-lg-7 py-lg-5">
              <div class="text-center text-muted mb-4">					
					<div class="text-center text-muted mb-3">
		                <h1 style="font-size:32px; color: #ffffff">Senderos</h1>
		                <p style="font-size:16px; color: #ffffff">Ingrese sus credenciales</p>
		            
	                </div>

		            
		            @if(Session::has('info'))
						<div class="row">
						    <div class="panel-heading">
						        <div class="alert alert-success">{{ Session::get('info') }}
						            <button class="close" data-dismiss="alert">
						                <i class="pci-cross pci-circle"></i>
						            </button>
						        </div>
						    </div>
						</div>
						<br><br>
					@endif
		            <form method="POST" action="/login">
		            	<input type="hidden" id="lat" name="lat">
                		<input type="hidden" id="long" name="long">
		            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		                <div class="form-group">
		                    <input name="email" type="text" class="form-control" placeholder="Usuario" autofocus value="{{ old('email') }}"> 
		                </div>
						
		                <div class="form-group">
		                    <input name="password" type="password" class="form-control" placeholder="Contraseña">
		                </div>
		                {{--<div class="checkbox pad-btm text-left">
		                    <input id="demo-form-checkbox" class="magic-checkbox" type="checkbox">
		                    <label for="demo-form-checkbox">Recordarme</label>
		                </div>--}}
		                <button class="btn btn-primary btn-lg btn-block" type="submit">Ingresar</button>
		            </form>
		            <br>
		            @if(Session::has('msg'))
		            <div class="text-center text-muted mb-8">
		            	<div class="alert {{ Session::get('msg.class') }}">{!! Session::get('msg.text') !!}</div>
		            @endif
		            {!! $errors->first('email', '<div class="alert alert-danger">:message</div>') !!}
		        </div>

		        	<div class="text-center text-muted mb-3">
		            <a href="{{ route('password.request') }}" class="btn-link mar-rgt">¿Olvidó su contraseña?</a>
		            <div class="text-center text-muted mb-12">
		            <a href="{{ route('register') }}" class="btn-link mar-lft"><strong>Registrarse</strong></a>
		            <div class="media pad-top bord-top">
		                <div class="media-body text-center text-bold text-main">
		                    Versión: {{ Session::get('Current.version') }}
		                </div>
		            </div>
		        </div>
		    </div>
		</div>


    </div>

    <script src="/js/jquery.min.js"></script>
	<script src="/js/argon.js"></script>
	<script src="/js/argon.min.js"></script>
</body>
</html>
