@extends('templates.master')
@section('titulo', 'Senderos')

@section('customcss')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="/plugins/datatables/media/css/dataTables.bootstrap.min.css">
<link href="/plugins/datatables/extensions/Responsive/css/responsive.dataTables.min.css">
<link href="/plugins/datatables/extensions/Buttons/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" />
<link rel="stylesheet" href="/plugins/leaflet/leaflet.css" />
<link rel="stylesheet" href="/plugins/leaflet/Control.FullScreen.css"/>
<style>
  table td {
        word-wrap: break-word;
        max-width: 400px;
    }
    #example td {
        white-space:inherit;
    }
    div#capas {
        position: absolute;
        top: 5px;
        width: 290px !important;
        height: 100%;
        z-index:5000 !important;
    }
    .leaflet-div-icon {
        background: transparent;
        border: none;
        vertical-align: middle;
    }  
</style>
@endsection

@section('customjs')
<script src="/plugins/leaflet/leaflet.js"></script>
<script src="/plugins/leaflet/Control.FullScreen.js"></script>
<script src="/plugins/datatables/media/js/jquery.dataTables.js"></script>
<script src="/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
<script src="/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js "></script>
<script type="text/javascript">
//maps
var locations = [];
var map = L.map('map', {
  zoomSnap: 0.25,
  scrollWheelZoom:true
}).setView([19.432603, -99.133206], 12);

var alcaldia = L.layerGroup().addTo(map);
var camaras = L.layerGroup().addTo(map);
var sobse = L.layerGroup().addTo(map);
var mejoramiento = L.layerGroup().addTo(map);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
L.control.scale().addTo(map);
let layerControl = {
  'Alcaldias':alcaldia,
  'Camaras': camaras,
  'Senderos SOBSE': sobse,
  'Senderos Mejoramiento Barrial': mejoramiento // an option to show or hide the layer you created from geojson
}
L.control.layers({},layerControl, {position: 'topleft'} ).addTo( map );

// create fullscreen control
var fsControl = L.control.fullscreen({
  title: 'Ver pantalla completa',
  titleCancel: 'Salir pantalla completa',
});
// add fullscreen control to the map
map.addControl(fsControl);
function populate(locations){
  for (var i = 0; i < locations.length; i++) {
    if(locations[i][0] == 'User'){
        $color = 'success';
        popupContent = '<div id="content">' +
          '<div id="siteNotice">' +
          '</div>' +
          '<h4 id="firstHeading" class="firstHeading">Seguimiento Territorial - SACMEX</h4>' +
          '<div id="bodyContent">' +
          '<p><b>Nombre </b>'+locations[i][3]+'<br>' +
          '<ul>'+
          '<li><b>'+locations[i][9]+'</b></li>' +
          '<li><b># Tel.: </b>'+locations[i][7]+'</li>' +
          '<li><b>Última Conexión: </b>'+locations[i][8]+'</li>' +
          locations[i][10]+
          '</p>' +
          '</div>' +
          '</div>';
          if(locations[i][9] == 'Tormenta'){
            hexa = '00004c';
          }else if(locations[i][9] == 'Cuadrilla'){
            hexa = '4A7023';
          }else{
            hexa = 'D3D3D3';
          }
          /*var greenIcon = L.icon({
                        iconUrl: "https://chart.googleapis.com/chart?chst=d_bubble_icon_text_small&chld=location|bb|"+locations[i][3]+" - "+locations[i][9]+"|"+hexa+"|FFFFFF",
                    });*/
        var greenIcon = L.divIcon({html: ' <span class="icon-wrap icon-wrap-xs icon-circle bg-'+$color+'"><i class="'+locations[i][5]+' icon-2x"></i></span>',
                            iconSize: [20, 20],
                            className: 'leaflet-div-icon'
                    });

        L.marker([locations[i][1],locations[i][2]], {icon: greenIcon})
          .bindPopup(popupContent)
          .addTo(markers);
    }else if(locations[i][0] == 'Report'){
        $color = 'info';
        popupContent = '<div id="content">' +
          '<div id="siteNotice">' +
          '</div>' +
          '<h4 id="firstHeading" class="firstHeading">Seguimiento Territorial - SACMEX</h4>' +
          '<div id="bodyContent">' +
          '<p><b>'+locations[i][3]+'</b><br>' +
          '<ul>'+
          '<li><b>Estatus: </b>'+locations[i][4]+'</li>' +
          '<li><b>Fecha de Alta: </b>'+locations[i][6]+'</li>' +
          '<li><b>Folio de Incidente: </b>'+locations[i][7]+'</li>' +
          locations[i][8]+
          '</p>' +
          '</div>' +
          '</div>';
        var greenIcon = L.divIcon({html: ' <span class="icon-wrap icon-wrap-xs icon-circle bg-'+$color+'"><i class="'+locations[i][5]+' icon-2x"></i></span>',
                            iconSize: [20, 20],
                            className: 'leaflet-div-icon'
                    });

        L.marker([locations[i][1],locations[i][2]], {icon: greenIcon})
          .bindPopup(popupContent)
          .addTo(reports);
    }else if(locations[i][0] == 'Incident'){
        $color = 'warning';
        popupContent = '<div id="content">' +
          '<div id="siteNotice">' +
          '</div>' +
          '<h4 id="firstHeading" class="firstHeading">Seguimiento Territorial - SACMEX</h4>' +
          '<div id="bodyContent">' +
          '<p><b>'+locations[i][3]+'</b><br>' +
          '<ul>'+
          '<li><b>Estatus: </b>'+locations[i][4]+'</li>' +
          '<li><b>Fecha de Alta: </b>'+locations[i][6]+'</li>' +
          '<li><b>Folio de Incidente: </b>'+locations[i][7]+'</li>' +
          locations[i][8]+
          '</p>' +
          '</div>' +
          '</div>';
        var greenIcon = L.divIcon({html: ' <span class="icon-wrap icon-wrap-xs icon-circle bg-'+$color+'"><i class="'+locations[i][5]+' icon-2x"></i></span>',
                            iconSize: [20, 20],
                            className: 'leaflet-div-icon'
                    });

        L.marker([locations[i][1],locations[i][2]], {icon: greenIcon})
          .bindPopup(popupContent)
          .addTo(incidents);
    }else if(locations[i][0] == 'Validation'){
        $color = 'danger';
        popupContent = '<div id="content">' +
          '<div id="siteNotice">' +
          '</div>' +
          '<h4 id="firstHeading" class="firstHeading">Seguimiento Territorial - SACMEX</h4>' +
          '<div id="bodyContent">' +
          '<p><b>'+locations[i][3]+'</b><br>' +
          '<ul>'+
          '<li><b>Estatus: </b>'+locations[i][4]+'</li>' +
          '<li><b>Fecha de Alta: </b>'+locations[i][6]+'</li>' +
          '<li><b>Folio de Incidente: </b>'+locations[i][7]+'</li>' +
          locations[i][8]+
          '</p>' +
          '</div>' +
          '</div>';
        var greenIcon = L.divIcon({html: ' <span class="icon-wrap icon-wrap-xs icon-circle bg-'+$color+'"><i class="'+locations[i][5]+' icon-2x"></i></span>',
                            iconSize: [20, 20],
                            className: 'leaflet-div-icon'
                    });

        L.marker([locations[i][1],locations[i][2]], {icon: greenIcon})
          .bindPopup(popupContent)
          .addTo(validations);
    }else{
      $color = 'danger';
        popupContent = '<div id="content">' +
          '<div id="siteNotice">' +
          '</div>' +
          '<h4 id="firstHeading" class="firstHeading">Seguimiento Territorial - SACMEX</h4>' +
          '<div id="bodyContent">' +
          '<p><b>'+locations[i][3]+'</b><br>' +
          '<ul>'+
          '<li><b>Estatus: </b>'+locations[i][4]+'</li>' +
          '<li><b>Fecha de Alta: </b>'+locations[i][6]+'</li>' +
          '<li><b>Folio de Incidente: </b>'+locations[i][7]+'</li>' +
          locations[i][8]+
          '</p>' +
          '</div>' +
          '</div>';
        var greenIcon = L.divIcon({html: ' <span class="icon-wrap icon-wrap-xs icon-circle bg-'+$color+'"><i class="'+locations[i][5]+' icon-2x"></i></span>',
                            iconSize: [20, 20],
                            className: 'leaflet-div-icon'
                    });

        L.marker([locations[i][1],locations[i][2]], {icon: greenIcon})
          .bindPopup(popupContent)
          .addTo(repairs);
    }
  }
}
//console.log({!! $polygons !!});
var geojson = L.geoJSON({!! $polygons !!}, {
        onEachFeature: function (feature, layer) {
            if(feature.properties.Description == 'Alcaldia'){
                popupContent = '<div id="content">' +
                    '<div id="siteNotice">' +
                    '</div>' +
                    '<h4 id="firstHeading" class="firstHeading">Seguimiento Territorial | SACMEX</h4>' +
                    '<div id="bodyContent">' +
                    '<p>' +
                    '<ul><li><b>Alcaldía: </b>'+feature.properties.Alcaldia+'</li>' +
                    '</p>' +
                    '</div>' +
                    '</div>';
                layer.bindPopup(popupContent).addTo(alcaldia);
            }else if(feature.properties.Description == 'SOBSE'){
                popupContent = '<div id="content">' +
                    '<div id="siteNotice">' +
                    '</div>' +
                    '<h4 id="firstHeading" class="firstHeading">Seguimiento Territorial | SACMEX</h4>' +
                    '<div id="bodyContent">' +
                    '<p>' +
                    '<ul><li><b>Tipo: </b>'+feature.properties.tipo+'</li>'+
                    '<li><b></b>'+feature.properties.Alcaldia+'</li>'
                    '</p>' +
                    '</div>' +
                    '</div>'; 
                layer.bindPopup(popupContent).addTo(sobse);
            }else if(feature.properties.Description == 'Camaras'){
                popupContent = '<div id="content">' +
                    '<div id="siteNotice">' +
                    '</div>' +
                    '<h4 id="firstHeading" class="firstHeading">Seguimiento Territorial | SACMEX</h4>' +
                    '<div id="bodyContent">' +
                    '<p>' +
                    '<ul><li><b>Nombre: </b>'+feature.properties.nombre+'</li>'+
                    '<li><b></b>'+feature.properties.tipo+'</li>'
                    '</p>' +
                    '</div>' +
                    '</div>'; 
                layer.bindPopup(popupContent).addTo(camaras);
            }else if(feature.properties.Description == 'Mejoramiento'){
                popupContent = '<div id="content">' +
                    '<div id="siteNotice">' +
                    '</div>' +
                    '<h4 id="firstHeading" class="firstHeading">Seguimiento Territorial | SACMEX</h4>' +
                    '<div id="bodyContent">' +
                    '<p>' +
                    '<ul><li><b>Nombre: </b>'+feature.properties.nombre+'</li>'+
                    '<li><b></b>'+feature.properties.tipo+'</li>'
                    '</p>' +
                    '</div>' +
                    '</div>'; 
                layer.bindPopup(popupContent).addTo(mejoramiento);
            }

            layer.bindPopup(popupContent);
        }, style: function(feature) {
            switch (feature.properties.Description) {
                case 'Alcaldia': return {fillColor: "#eeeeee", color: "#000", weight: 3};
                //case 'Alcaldia':   return {fillColor: "gray", color: "gray", weight: 2, opacity: 1, fillOpacity: 0.35};
                case 'SOBSE':   return {fillColor: "blue", color: "blue", weight: 2, opacity: 1, fillOpacity: 0.35};
                case 'Camaras':   return {fillColor: "red", color: "red", weight: 2, opacity: 1, fillOpacity: 0.35};
                case 'Mejoramiento':   return {fillColor: "greent", color: "green", weight: 2, opacity: 1, fillOpacity: 0.35};
               
                
            }
        }
});
var today = new Date();
var date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
var dateTime = date+' '+time;
$(document).ready(function() {
  BindItemTable();
});
function BindItemTable() {
    myTable = $('#incidentes').DataTable({
        "destroy": true,
        "processing": true,
        "deferRender": true,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "dom": 'lBfrtip',
        "buttons": [
            {
                extend: 'excelHtml5',
                title: 'Senderos '+ date,
                footer: true,
                messageTop: 'Fecha de descarga '+ dateTime
            },
            {
                extend: 'csvHtml5',
                title: 'Senderos '+ date,
                footer: true,
                messageTop: 'Fecha de descarga '+ dateTime
            },
            {
                extend: 'pdfHtml5',
                title: 'Senderos '+ date,
                footer: true,
                messageTop: 'Fecha de descarga '+ dateTime
            }
        ]
    });
}
</script>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div id="map" style="height: 900px;">
        </div>
    </div>
</div>
<br>
<br>
<div class="panel">
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <img width="100%" src="/img/senderos/sibiso-01.png">
      </div>
      <div class="col-md-12">
        <img width="100%" src="/img/senderos/sibiso-02.png">
      </div>
      <div class="col-md-12">
        <img width="100%" src="/img/senderos/sibiso-03.png">
      </div>
      <div class="col-md-12">
        <img width="100%" src="/img/senderos/sibiso-04.png">
      </div>
    </div>
  </div>
</div>
<br>
<div class="panel">
  <div class="panel-body">
    <div class="row">
      <div class="col-md-6">
        <img width="100%" src="/img/senderos/senderos-05.png">
      </div>
      <div class="col-md-12">
        <img width="100%" src="/img/senderos/senderos-06.png">
      </div>
      <div class="col-md-12">
        <img width="100%" src="/img/senderos/senderos-07.png">
      </div>
      <div class="col-md-12">
        <img width="100%" src="/img/senderos/senderos-08.png">
      </div>
    </div>
  </div>
</div>
<br>
<div class="panel">
  <div class="panel-body">
    <div class="row">
      <div class="col-md-6">
        <img width="100%" src="/img/senderos/senderos-09.png">
      </div>
      <div class="col-md-12">
        <img width="100%" src="/img/senderos/senderos-10.png">
      </div>
      <div class="col-md-12">
        <img width="100%" src="/img/senderos/senderos-11.png">
      </div>
      <div class="col-md-12">
        <img width="100%" src="/img/senderos/senderos-12.png">
      </div>
      <div class="col-md-12">
        <img width="100%" src="/img/senderos/senderos-13.png">
      </div>
      <div class="col-md-12">
        <img width="100%" src="/img/senderos/senderos-14.png">
      </div>
    </div>
  </div>
</div>
<br>
<br>
<div class="panel">
  <div class="panel-body">
    <div class="row">
            <div class="col-lg-12">             
                <div class="form-group table-responsive">
                    <table id="incidentes" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Responsable</th>
                                <th>Sendero</th>
                                <th>Alcaldía</th>
                                <th>Colonia</th>
                                <th>Entre Calles</th>
                                <th>Fecha de inauguración</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody id="data">
                            @foreach($senderos as $sendero)
                            <tr>
                              <td>{{ $sendero->id }}</td>
                              <td>{{ $sendero->responsable }}</td>
                              <td>{{ $sendero->sendero }}</td>
                              <td>{{ $sendero->alcaldia }}</td>
                              <td>{{ $sendero->colonia }}</td>
                              <td>{{ $sendero->entrecalles }}</td>
                              <td>{{ $sendero->inaugurar }}</td>
                              <td>{{ $sendero->estatus }}</td>
                            </tr>                              
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Responsable</th>
                                <th>Sendero</th>
                                <th>Alcaldía</th>
                                <th>Colonia</th>
                                <th>Entre Calles</th>
                                <th>Fecha de inauguración</th>
                                <th>Estatus</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
  </div>
</div>
@endsection