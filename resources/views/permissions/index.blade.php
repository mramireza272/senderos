@extends('templates.master')

@section('titulo')
	Senderos
@endsection

@section('titulo_pagina')
	Permisos
@endsection
@section('customcss')
	<link href="/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
    <link href="/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/plugins/x-editable/css/bootstrap-editable.css" rel="stylesheet">
@endsection
@section('content')
<div class="panel">
    <div class="panel-body">
        @can('create_roles')
        <a href="{{ route('permisos.create') }}" class="btn btn-primary">
            Nuevo Permiso
        </a>
        @endcan

        <table id="table-proyectos"
	               data-search="true"
	               data-show-refresh="true"
	               data-show-toggle="true"
	               data-show-columns="true"
	               data-sort-name="id"
	               data-page-list="[5, 10, 20]"
	               data-page-size="10"
	               data-pagination="true" 
	               data-show-pagination-switch="true"
	               data-locale="es-MX">
	    	<thead>
	    		<tr>
	    			<th class="col-sm-1"></th>
	    			<th>Permiso</th>
	    			<th class="col-lg-3"></th>
	    		</tr>
	    	</thead>
	    	<tbody>
                @foreach($permissions as $permission)
	                <tr>
	                    <td>{{ $permission->id }}</td>
	                    <td>{{ $permission->name }}</td>
	                    <td>
	                        @can('show_roles')
	                            <a href="{{ route('permisos.show', $permission->id)}}" class="btn btn-sm btn-primary">
	                                Ver
	                            </a>
	                        @endcan
	                        @can('edit_roles')
	                            <a href="{{ route('permisos.edit', $permission->id)}}" class="btn btn-sm btn-warning">
	                                Editar
	                            </a>
	                        @endcan
	                        @can('delete_roles')
	                            <form action="{{ route('permisos.destroy', $permission->id) }}" 
		        					  style="display: inline;" method="POST">
		        					{!! method_field('DELETE') !!}
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
			        				<button title="Eliminar" class="btn btn-sm btn-danger">
			        					Eliminar
			        				</button>
			        			</form>
	                        @endcan
	                    </td>
	                </tr>
                @endforeach
            </tbody>
	    </table>
    </div>
</div>
@endsection
@section('customjs')
    <script src="/plugins/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="/plugins/bootstrap-table/locale/bootstrap-table-es-MX.min.js"></script>
    <script type="text/javascript">
    	$(document).on('nifty.ready', function() {

		    jQuery.fn.bootstrapTable.defaults.icons = {
		        paginationSwitchDown: 'pli-arrow-down',
		        paginationSwitchUp: 'pli-arrow-up',
		        refresh: 'pli-repeat-2',
		        toggle: 'pli-layout-grid',
		        columns: 'pli-check',
		        detailOpen: 'psi-add',
		        detailClose: 'psi-remove'
		    }

		    $('#table-proyectos').bootstrapTable();

		});
    </script>
@endsection