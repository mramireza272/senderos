@extends('templates.master')

@section('titulo')
	Senderos
@endsection

@section('titulo_pagina')
	Rol
@endsection

@section('content')  
<div class="panel">
    <div class="panel-body">
		<h2 class="panel-title"><strong>{{ $role->slug }}</strong></h2>
		<p><strong>Descripción</strong> {{ $role->description }}</p>
		<p><strong>Permisos</strong> 
			<ul>
				@foreach($role->permissions as $permission)
					<li><strong>{{$permission->name}}</strong> <em>{{$permission->description}}</em></li>
				@endforeach
			</ul>
		</p>
    </div>
</div>
@endsection