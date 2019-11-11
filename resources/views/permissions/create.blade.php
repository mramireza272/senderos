@extends('templates.master')

@section('titulo')
	Senderos
@endsection

@section('titulo_pagina')
	Nuevo Permiso
@endsection

@section('content')
<div class="panel">
    <div class="panel-body">
    	<a href="{{ route('permisos.index') }}" type="submit" class="btn btn-info">Regresar</a>
		<form method="POST" action="{{ route('permisos.store') }}">
			@include('permissions.form')	
		</form>
    </div>
</div>
@endsection