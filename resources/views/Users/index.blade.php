@extends('templates.master')

@section('titulo', 'Senderos')

@section('titulo_pagina', 'Usuarios')

@section('customcss')

@endsection

@section('content')
	<div class="row">
	    <div class="col-lg-12">
	        <div class="panel">
	        	@if(session()->has('info'))
		        	<div class="panel-heading">
			        	<div class="alert alert-success">{{ session('info') }}
			        		<button class="close" data-dismiss="alert">
                            	<i class="pci-cross pci-circle"></i>
                        	</button>
			        	</div>
				    </div>
			    @endif
			</div>
	    </div>
	</div>
    <!-- Contact Toolbar -->
    <!---------------------------------->
    <div class="row pad-btm">
        <div class="col-sm-2 toolbar-left">
        	@can('create_user')
            	<a href="{{ route('usuarios.create') }}" class="btn btn-primary">Crear usuario</a>
            @endcan
        </div>

        <div class="col-sm-5 toolbar-center">
            <form method="get" action="{{ route('usuarios.search') }}">
                <div class="input-group mar-btm">
                    <input type="text" id="search" name="search" placeholder="Buscar por nombre, correo electrónico, IMEI, Número Telefónico" class="form-control" value="{{ $search }}" autofocus>
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="pli-search-people icon-lg"></i></button>
                    </span>
                </div>
            </form>
        </div>

        <div class="col-sm-5 toolbar-right text-right">
        	<br><br>
        </div>
		<div class="pad-btm">
			<ul class="pagination">
		    	{{ method_exists($users,'links')?$users->appends(['search' => $search])->links():'' }}
		    </ul>
		    <br>
		    <h5>
		    	Usuarios {{ $users->firstItem() }} - {{ $users->lastItem() }} de {{ $users->total() }} (Página {{ $users->currentPage() }}) 
		    </h5>
		</div>
        <div class="row">
        	@php ($row = 1)
			@foreach ($users as $user)
				<div class="col-sm-4 col-md-3">
	            <!-- Contact Widget -->
	            <!---------------------------------->
	            <div class="panel pos-rel">
	                <div class="pad-all">
	                    <div class="media pad-ver">
	                        <div class="media-left">
	                            <a href="#" class="box-inline">
                            		<img alt="Foto de perfil" class="img-md img-circle" src="/img/profile-photos/1.png">
	                           	</a>
	                        </div>
	                        <div class="media-body pad-top">
                                <span class="text-lg text-semibold text-main">{{ (isset($user->name) ? $user->name : '') .' '. (isset($user->paterno) ? $user->paterno : '') .' '. (isset($user->materno) ? $user->materno : '') }}</span>
                                <p class="text-sm">{{ isset($user->email) ? $user->email : '' }}</p>
                                <p class="text-sm">Perfil: {{ $user->roles() !== null ? $user->roles()->pluck('name')->first() : '' }}</p>
	                        </div>
	                    </div>
	                    <div class="text-center pad-to">
	                        <div class="btn-group">
	                            @can('edit_user')
	                            <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-sm btn-default">
	                            	<i class="pli-pen-5 icon-lg icon-fw"></i> Editar
	                            </a>
	                            @endcan
	                            @can('delete_user')
	                            <form class="delete" style="display: inline" method="POST" action="{{ route('usuarios.destroy', $user->id) }}">
	                            	{!! method_field('DELETE') !!}
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
		                            <button href="#" class="btn btn-sm btn-default">
		                            	<i class="pli-recycling icon-lg icon-fw"></i> Eliminar
		                            </button>
		                        </form>
		                        @endcan
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <!---------------------------------->

	            </div>
	            @if($row > 3)
	            	@php ( $row = 1 )
	            	<div class="clearfix"></div>
	            @else
	            	@php( $row++ )
	            @endif

			@endforeach
	    </div>
	    <div class="pad-btm">
			<ul class="pagination">
		    	{{ method_exists($users,'links')?$users->appends(['search' => $search])->links():'' }}
		    </ul>
		    <br>
		    <h5>
		    	Usuarios {{ $users->firstItem() }} - {{ $users->lastItem() }} de {{ $users->total() }} (Página {{ $users->currentPage() }}) 
		    </h5>
		</div>
    </div>

	<div class="modal" id="confirm">
	    <div class="modal-dialog modal-sm">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                <h4 class="modal-title" style="text-align: center;">Atención</h4>
	            </div>
	            <div class="modal-body" style="text-align: center;">
	                <p>¿Está seguro de eliminar?</p>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-sm btn-primary" id="delete-btn">Eliminar</button>
	                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
	            </div>
	        </div>
	    </div>
	</div>
@endsection

@section('customjs')
<script>
    $(".delete").on('click', function(e){
    	e.preventDefault();
        var $form = $(this);
	    $('#confirm').modal({ backdrop: 'static', keyboard: false })
	        .on('click', '#delete-btn', function(){
	            $form.submit();
	    });
    });
</script>
@endsection