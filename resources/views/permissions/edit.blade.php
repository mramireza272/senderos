@extends('templates.master')

@section('titulo')
	Senderos
@endsection

@section('titulo_pagina')
	Editar Permiso
@endsection

@section('content')  
<div class="panel">
    <div class="panel-body">
    	<a href="{{ route('permisos.index') }}" type="submit" class="btn btn-info">Regresar</a>
    	<a href="{{ route('permisos.create') }}" type="submit" class="btn btn-info">Nuevo Permiso</a>
		<form method="POST" action="{{ route('permisos.update', $permission->id) }}">
			{!! method_field('PUT') !!}
			@include('permissions.form', ['btnText'=>'Actualizar'])
		</form>
    </div>
</div>
@endsection