@extends('templates.master')
@section('titulo', 'Senderos')

@section('customcss')
<link href="/plugins/select2/css/select2.css" rel="stylesheet">
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
<script src="/plugins/select2/js/select2.min.js"></script>
<script src="/plugins/select2/js/i18n/es.js"></script>
<script type="text/javascript">
//maps
var locations = [];
var map = L.map('map', {
  zoomSnap: 0.25,
  scrollWheelZoom:true
}).setView([19.432603, -99.133206], 12);

var alcaldia = L.layerGroup();
var interseccion = L.layerGroup().addTo(map);
var camaras = L.layerGroup().addTo(map);
var sobse = L.layerGroup().addTo(map);
var mejoramiento = L.layerGroup().addTo(map);
var c5 = L.layerGroup().addTo(map);
var c5buffer = L.layerGroup().addTo(map);
var iztapalapa = L.layerGroup().addTo(map);
var cuauhtemoc = L.layerGroup().addTo(map);
var ssc = L.layerGroup().addTo(map);

alcaldia.setZIndex(1);
camaras.setZIndex(2);
sobse.setZIndex(5);
mejoramiento.setZIndex(4);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
L.control.scale().addTo(map);
let layerControl = {
  '<span style="color: black; font-size: 20px"><b>─</b> </span> Alcaldias (División Geografica)':alcaldia,
  '<span style="color: blue; font-size: 20px"><b>─</b> </span> Senderos SOBSE': sobse,
  '<span style="color: green; font-size: 20px"><b>─</b> </span> Senderos Mejoramiento Barrial': mejoramiento,
  '<span style="color: red; font-size: 20px"><b>─</b> </span> Intersección SOBSE - Mejoramiento': interseccion,
  'C5': c5,
  'Alcance C5':c5buffer,
  '<span style="color: yellow; font-size: 20px"><b>─</b> </span>Senderos Iztapalapa': iztapalapa,
  '<span style="color: navy; font-size: 20px"><b>─</b> </span>Senderos Cuauhtemoc': cuauhtemoc,
  '<span style="color: purple; font-size: 20px"><b>─</b> </span>Corredores SSC': ssc,// an option to show or hide the layer you created from geojson
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
          '<h4 id="firstHeading" class="firstHeading">Senderos</h4>' +
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
    }else{
      $color = 'danger';
        popupContent = '<div id="content">' +
          '<div id="siteNotice">' +
          '</div>' +
          '<h4 id="firstHeading" class="firstHeading">Senderos</h4>' +
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

var geojson = L.geoJSON({!! $polygons !!}, {
        onEachFeature: function (feature, layer) {
            if(feature.properties.Description == 'Alcaldia'){
                popupContent = '<div id="content">' +
                    '<div id="siteNotice">' +
                    '</div>' +
                    '<h4 id="firstHeading" class="firstHeading">Senderos</h4>' +
                    '<div id="bodyContent">' +
                    '<p>' +
                    '<ul><li><b>Alcaldía: </b>'+feature.properties.Alcaldia+'</li>' +
                    '</p>' +
                    '</div>' +
                    '</div>';
                layer.bindPopup(popupContent).addTo(alcaldia);
            }else if(feature.properties.Description == 'Interseccion'){
                popupContent = '<div id="content">' +
                    '<div id="siteNotice">' +
                    '</div>' +
                    '<h4 id="firstHeading" class="firstHeading">Senderos</h4>' +
                    '<div id="bodyContent">' +
                    '<p>' +
                    '<ul><li>'+feature.properties.perfil+'</li>'+
                    '<li><b>Tipo: </b>'+feature.properties.tipo+'</li>'+
                    '<li><b>Estatus: </b>'+feature.properties.estatus+'</li>'+
                    '<li><b>Número: </b>'+feature.properties.num+'</li>'+
                    '<li><b>Nombre: </b>'+feature.properties.nombre+'</li>'+
                    '<li><b>Ubicación: </b>'+feature.properties.ubicacion+'</li>'+
                    '<li><b>Longitud: </b>'+feature.properties.long+' Kms.</li>'+
                    '</p>' +
                    '</div>' +
                    '</div>'; 
                layer.bindPopup(popupContent).addTo(interseccion);
            }else if(feature.properties.Description == 'SOBSE'){
                popupContent = '<div id="content">' +
                    '<div id="siteNotice">' +
                    '</div>' +
                    '<h4 id="firstHeading" class="firstHeading">Senderos</h4>' +
                    '<div id="bodyContent">' +
                    '<p>' +
                    '<ul><li>'+feature.properties.perfil+'</li>'+
                    '<li><b>Tipo: </b>'+feature.properties.tipo+'</li>'+
                    '<li><b>Estatus: </b>'+feature.properties.estatus+'</li>'+
                    '<li><b>Número: </b>'+feature.properties.num+'</li>'+
                    '<li><b>Nombre: </b>'+feature.properties.nombre+'</li>'+
                    '<li><b>Ubicación: </b>'+feature.properties.ubicacion+'</li>'+
                    '<li><b>Longitud: </b>'+feature.properties.long+' Kms.</li>'+
                    '</p>' +
                    '</div>' +
                    '</div>'; 
                layer.bindPopup(popupContent).addTo(sobse);
            }else if(feature.properties.Description == 'Camaras'){
                popupContent = '<div id="content">' +
                    '<div id="siteNotice">' +
                    '</div>' +
                    '<h4 id="firstHeading" class="firstHeading">Senderos</h4>' +
                    '<div id="bodyContent">' +
                    '<p>' +
                    '<ul><li>'+feature.properties.tipo+'</li>'+
                    '<li><b>Ubicación: </b>'+feature.properties.nombre+'</li>'
                    '</p>' +
                    '</div>' +
                    '</div>'; 
                layer.bindPopup(popupContent).addTo(camaras);
            }else if(feature.properties.Description == 'Mejoramiento'){
                popupContent = '<div id="content">' +
                    '<div id="siteNotice">' +
                    '</div>' +
                    '<h4 id="firstHeading" class="firstHeading">Senderos</h4>' +
                    '<div id="bodyContent">' +
                    '<p>' +
                    '<ul><li>'+feature.properties.perfil+'</li>'+
                    '<li><b>Vialidad: </b>'+feature.properties.nomvial+'</li>'+
                    '<li><b>Sentido: </b>'+feature.properties.sentido+'</li>'+
                    '<li><b>Tipo de Vialidad: </b>'+feature.properties.tipovial+'</li>'+
                    '</p>' +
                    '</div>' +
                    '</div>'; 
                layer.bindPopup(popupContent).addTo(mejoramiento);
            }else if(feature.properties.Description == 'Iztapalapa'){
                popupContent = '<div id="content">' +
                    '<div id="siteNotice">' +
                    '</div>' +
                    '<h4 id="firstHeading" class="firstHeading">Senderos Iztapalapa</h4>' +
                    '<div id="bodyContent">' +
                    '<p>' +
                    '<ul><li>'+feature.properties.estado+'</li>'+
                    '<li><b>Nombre: </b>'+feature.properties.nombre+'</li>'+
                    '<li><b>Longitud: </b>'+feature.properties.long+' Kms.</li>'+
                    '</p>' +
                    '</div>' +
                    '</div>'; 
                layer.bindPopup(popupContent).addTo(iztapalapa);
            }else if(feature.properties.Description == 'Cuauhtemoc'){
                popupContent = '<div id="content">' +
                    '<div id="siteNotice">' +
                    '</div>' +
                    '<h4 id="firstHeading" class="firstHeading">Senderos Cuauhtemoc</h4>' +
                    '<div id="bodyContent">' +
                    '<p>' +
                    '<ul><li>'+feature.properties.estado+'</li>'+
                    '<li><b>Nombre: </b>'+feature.properties.nombre+'</li>'+
                    '<li><b>Longitud: </b>'+feature.properties.long+' Kms.</li>'+
                    '</p>' +
                    '</div>' +
                    '</div>';
                layer.bindPopup(popupContent).addTo(cuauhtemoc);
            }else if(feature.properties.Description == 'SSC'){
                popupContent = '<div id="content">' +
                    '<div id="siteNotice">' +
                    '</div>' +
                    '<h4 id="firstHeading" class="firstHeading">Corredores SSC</h4>' +
                    '<div id="bodyContent">' +
                    '<p>' +
                    '<ul><li><b>Calle: </b>'+feature.properties.nombre+'</li>'+
                    '<li><b>Sector: </b>'+feature.properties.sector+'</li>'+
                    '<li><b>Cuadrante: </b>'+feature.properties.cuadrante+'</li>'+
                    '<li><b>Colonia: </b>'+feature.properties.colonia+'</li>'+
                    '</p>' +
                    '</div>' +
                    '</div>'; 
                layer.bindPopup(popupContent).addTo(ssc);
            }else if(feature.properties.Description == 'C5'){
                popupContent = '<div id="content">' +
                    '<div id="siteNotice">' +
                    '</div>' +
                    '<h4 id="firstHeading" class="firstHeading">C5</h4>' +
                    '<div id="bodyContent">' +
                    '<p>' +
                    '<ul><li>'+feature.properties.tipo+'</li>'+
                    '<li><b>Ubicación: </b>'+feature.properties.nombre+'</li>'
                    '</p>' +
                    '</div>' +
                    '</div>'; 
                layer.bindPopup(popupContent).addTo(c5);
            }else if(feature.properties.Description == 'C5buffer'){
                popupContent = '<div id="content">' +
                    '<div id="siteNotice">' +
                    '</div>' +
                    '<h4 id="firstHeading" class="firstHeading">C5</h4>' +
                    '<div id="bodyContent">' +
                    '<p>' +
                    '<ul><li><b>Vialidad: </b>'+feature.properties.vialidad+'</li>'+
                    '<li><b>Longitud: </b>'+feature.properties.long+'</li>'
                    '</p>' +
                    '</div>' +
                    '</div>'; 
                layer.bindPopup(popupContent).addTo(c5buffer);
            }

            layer.bindPopup(popupContent);
        }, style: function(feature) {
            switch (feature.properties.Description) {
                case 'Alcaldia': return {fillColor: "#eeeeee", color: "#000", weight: 2};
                //case 'Alcaldia':   return {fillColor: "gray", color: "gray", weight: 2, opacity: 1, fillOpacity: 0.35};
                case 'SOBSE':   return {fillColor: "blue", color: "blue", weight: 6, opacity: 1, fillOpacity: 0.35};
                case 'Camaras':   return {fillColor: "brown", color: "brown", weight: 6, opacity: 1, fillOpacity: 0.35};
                case 'Mejoramiento':   return {fillColor: "green", color: "green", weight: 6, opacity: 1, fillOpacity: 0.35};
                case 'Interseccion':   return {fillColor: "red", color: "red", weight: 6, opacity: 1, fillOpacity: 0.35};
                case 'c5':   return {fillColor: "brown", color: "brown", weight: 6, opacity: 1, fillOpacity: 0.35};
                case 'Iztapalapa' :return {fillColor: "yellow", color: "yellow", weight: 6, opacity: 1, fillOpacity: 0.35};
                case 'Cuauhtemoc' :return {fillColor: "#1D2951", color: "#1D2951", weight: 6, opacity: 1, fillOpacity: 0.35};
                case 'SSC' :return {fillColor: "purple", color: "purple", weight: 6, opacity: 1, fillOpacity: 0.35};
                case 'C5buffer' :return {fillColor: "violet", color: "violet", weight: 6, opacity: 1, fillOpacity: 0.35};
            }
        }
});
var today = new Date();
var date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
var dateTime = date+' '+time;

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

function filtros(){
  var parametros       = {};
  parametros['_token'] = '{{ csrf_token() }}';
  parametros['responsable'] = $('#responsable').val();
  parametros['alcaldia'] = $('#alcaldia').val();
  parametros['estatus'] = $('#estatus').val();
  $.ajax({
      url:        '{{ url("/home/filtros") }}',
      data:       parametros, 
      type:       'post',
      dataType:   'json',
      success: function (response) {
          myTable.clear();
          
          var result = response.map(function (item) {
              var result = [];
              result.push(item.id);
              result.push(item.responsable);
              result.push(item.sendero);
              result.push(item.alcaldia);
              result.push(item.colonia);
              result.push(item.entrecalles);
              result.push(item.inaugurar);
              result.push(item.estatus);
              return result;
          });
          myTable.rows.add(result);
          myTable.draw();
      }
  });
}
$(document).ready(function() {
  BindItemTable();
  $(".select2").select2({
        placeholder: "Selecciona una opción",
        allowClear: true,
        language: 'es',
        width:'100%'
    }).on("select2:select", function (e) {
        filtros();
    }).on("select2:unselect", function (e) {
        $(this).val(null);
        filtros();
    });
});
</script>
@endsection

@section('content')
<div class="tab-base tab-stacked-left">
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#stk-lft-tab-1" aria-expanded="true">Inicio</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#stk-lft-tab-2" aria-expanded="false">Senderos de la  Secretaría de Obras y Servicios</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#stk-lft-tab-3" aria-expanded="false">Senderos Mejoramiento Barrial</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#stk-lft-tab-4" aria-expanded="false">Alcaldías</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="stk-lft-tab-1" class="tab-pane fade active in">
            <div class="row">
              <div class="col-md-12">
                <img width="100%" src="/img/senderos/sibiso-01.png">
              </div>
            </div>
        </div>
        <div id="stk-lft-tab-3" class="tab-pane fade">
            <div class="row">
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
            <div class="row">
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
        <div id="stk-lft-tab-2" class="tab-pane fade">
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
        <div id="stk-lft-tab-4" class="tab-pane fade">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div id="map" style="height: 900px;">
        </div>
    </div>
</div>
<br>
<div class="panel">
  <div class="panel-body">
    <div class="row">
      <div class="col-md-2"> 
        <select class="form-control select2" data-placeholder="Selecciona un responsable" name="responsable" id="responsable">
            <option value=""></option>
            @foreach($responsables as $responsable)
                <option value="{{$responsable}}">
                    {{ $responsable }}
                </option>
            @endforeach
        </select>
      </div>
      <div class="col-md-2"> 
        <select class="form-control select2" data-placeholder="Selecciona Alcaldía" name="alcaldia" id="alcaldia">
            <option value=""></option>
            @foreach($alcaldias as $alcaldia)
                <option value="{{$alcaldia}}">
                    {{ $alcaldia }}
                </option>
            @endforeach
        </select>
      </div>
      <div class="col-md-2"> 
        <select class="form-control select2" data-placeholder="Selecciona un estatus" name="estatus" id="estatus">
            <option value=""></option>
            @foreach($statuses as $status)
                <option value="{{$status}}">
                    {{ $status }}
                </option>
            @endforeach
        </select>
      </div>
    </div>
    <br>
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