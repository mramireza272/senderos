@extends('templates.master')

@section('titulo')
	Senderos
@endsection

@section('titulo_pagina')
	Editar Rol
@endsection

@section('content')  
<div class="panel">
    <div class="panel-body">
		<form method="POST" action="{{ route('roles.update', $role->id) }}">
			{!! method_field('PUT') !!}
			@include('roles.form', ['btnText'=>'Actualizar'])
		</form>
    </div>
</div>
@endsection