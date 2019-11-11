@extends('templates.master')

@section('titulo')
	Senderos
@endsection

@section('titulo_pagina')
	Bitácora de sistema
@endsection

@section('customcss')
	<link href="/plugins/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="/plugins/datatables/media/css/dataTables.bootstrap.min.css">
    <link href="/plugins/datatables/extensions/Responsive/css/responsive.dataTables.min.css">
    <link href="/plugins/datatables/extensions/Buttons/css/buttons.dataTables.min.css">
    <style>
        table {
          table-layout:fixed;
        }
        table td {
          word-wrap: break-word;
          max-width: 400px;
        }
        #example td {
          white-space:inherit;
        }
    </style>
@endsection
@section('customjs')
	<script src="/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
 	<script>
	 	$(document).ready(function() {
		    $('#example').DataTable({
		    	"language": {
		            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
		        },
		        "responsive": true,
		        "paging"    : true,
		        "ordering"	: false
		    });
		});
 	</script>
@endsection
@section('content')
	<div class="panel">
		<div class="panel-body">
			<div class="row">
	            <div class="col-md-12">
			    	<table id="example" class="display" style="width:100%">
				        <thead>
				            <tr>
				                <th>ID</th>
				                <th>Información</th>
				                <th>Fecha</th>
				            </tr>
				        </thead>
				        <tbody>
				        	@foreach($log as $entry)
				        		<tr>
				        			<td>{{ $entry->id}}</td>
				        			<td>{{ $entry->data}}</td>
				        			<td>{{ $entry->created_at }}</td>
				        		</tr>
				        	@endforeach
				        </tbody>
				    </table>
				</div>
			</div>
		</div>
	</div>
@endsection