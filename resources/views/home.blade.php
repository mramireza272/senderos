@extends('templates.master')
@section('titulo', 'Senderos')

@section('customcss')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" />
<link rel="stylesheet" href="/plugins/leaflet/leaflet.css" />
<link rel="stylesheet" href="/plugins/leaflet/Control.FullScreen.css"/>
<style>
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
            }

            layer.bindPopup(popupContent);
        }, style: function(feature) {
            switch (feature.properties.Description) {
                case 'Alcaldia': return {fillColor: "#eeeeee", color: "#000", weight: 3};
                //case 'Alcaldia':   return {fillColor: "gray", color: "gray", weight: 2, opacity: 1, fillOpacity: 0.35};
                case 'SOBSE':   return {fillColor: "blue", color: "blue", weight: 2, opacity: 1, fillOpacity: 0.35};
                case 'Drenaje':   return {fillColor: "brown", color: "brown", weight: 4, opacity: 1, fillOpacity: 0.35};
                
            }
        }
});
</script>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div id="map" style="height: 900px;">
        </div>
    </div>
</div>
@endsection