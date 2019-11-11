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
    <link href="css/nifty.min.css" rel="stylesheet">
    <link href="premium/icon-sets/icons/line-icons/premium-line-icons.min.css" rel="stylesheet">
    <link href="premium/icon-sets/icons/solid-icons/premium-solid-icons.min.css" rel="stylesheet">
    {{--<link href="css/pace.min.css" rel="stylesheet">
    <script src="js/pace.min.js"></script>
    <link href="temp.css" rel="stylesheet"> --}}
</head>

<body>
    <div id="container" class="cls-container">
		<div class="cls-content">
		    <div class="cls-content-sm panel">
		        <div class="panel-body">
		        	<div class="media-body text-bold text-main">
	                    <img width="100%" src="/img/logos/logo_full.png">
	                </div>

		        	<div class="media pad-top bord-top"></div>

		            <div class="mar-ver pad-btm">
		                <h1 class="h3">Senderos</h1>
		                <p>Ingrese sus credenciales</p>
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
		            	<div class="alert {{ Session::get('msg.class') }}">{!! Session::get('msg.text') !!}</div>
		            @endif
		            {!! $errors->first('email', '<div class="alert alert-danger">:message</div>') !!}
		        </div>

		        <div class="pad-all">
		            <a href="{{ route('password.request') }}" class="btn-link mar-rgt">Olvidó su contraseña?</a>
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
</body>
</html>
