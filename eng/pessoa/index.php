<?php 
  require_once("permissao_pessoa.php"); 
?>
<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>DescartesLab</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    
    <script src="https://use.fontawesome.com/9c8fd2c64e.js"></script>

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <style type="text/css">

    html{
        height: 100%;
      }

      #map {
        height: 550px;
      }

      .controls {
        position: relative;
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #btfiltro{
        padding: 15px;
        //background-color: #00FFFF;
        color: white;
        margin-bottom: 15px;
        margin-right: 15px;
      }

      .popover {
        bottom: : 55px !important;
      }

      #pac-input {
        position: relative;
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #target {
        width: 345px;
      }
    </style>
    <script src="js/markerclusterer.js"></script>
  
  </head>

  <body>

  <section id="container" >
      <?php 
          require_once("navtop.php");
      ?>
    <section class="wrapper">
      <div style="width:100%;height:auto;margin-top:10px;">
        <input id="pac-input" class="controls" type="text" placeholder="Pesquise a localidade">
        <a id="btfiltro" class="btn btn-theme03" data-toggle="modal" data-target="#myModal"><i class="fa fa-filter"></i></a>
        <div id="map"></div> 
      </div>
            <input type='hidden' id="latt" value="e">
      <input type='hidden' id="lonn" value="e">
    </section>
    <!-- Modal -->
    <div class="container">
      <div class="modal fade" id="myModal" role="dialog" style="z-index: 20000000;">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Trash type selection</h4>
            </div>
            <form action="#" method="post">
              <div class="modal-body" style="overflow: auto; max-height: 400px;">
                <table class="table table-stripped">                                    
                 <?php 
                    $dados_json = $service->call('tipo_lixo.select',array(NULL));
                    $tipo_lixo = json_decode($dados_json);
                    $num = count($tipo_lixo);
                    for ($i=0; $i < $num ; $i++) { 
                      echo "<tr><td><input type='checkbox' name='tipos[]' value='".$tipo_lixo[$i]->id."'></td><td>".$tipo_lixo[$i]->nome_eng."</td></tr>";
                    }
                 ?> 
                </table>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-theme" id="seleciona" name="seleciona">Select</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="modal fade" id="modalend" role="dialog" style="z-index: 20000000;">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select your address to create the route</h4>
            </div>
            <form action="#" method="post">
              <div class="modal-body" style="overflow: auto; max-height: 400px;">
                <table class="table table-stripped">   
                <?php 
                    $dados_json = $service->call('usuario_has_endereco.select',array("usuario_id = ". $_SESSION['id']));
                    $ush = json_decode($dados_json);
                    $num = count($ush);
                    for ($i=0; $i < $num ; $i++) { 
                      $dados_json = $service->call('endereco.select_by_id',array($ush[$i]->endereco_id));
                      $end = json_decode($dados_json);
                      echo "<tr><td><a class='btn btn btn-theme03' href='#' style='width:100%;' onclick='pegain(".$end[0]->latitude.",".$end[0]->longitude.")'data-dismiss='modal'>".$ush[$i]->nome."</a></td></tr>";
                    }
                 ?>
                </table>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
 <script type="text/javascript">
var ds;
 var map;
 var infowindow;
 var markers = [];
 var markerCluster;
   function initAutocomplete() {
      var poder = true; // somente utilizada quando a empresa for criar um ponto para selecionar o local
      map = new google.maps.Map(document.getElementById('map'), {
              zoom: 2,
              center: new google.maps.LatLng(16.770881080415, 12.3046875),
              mapTypeId: google.maps.MapTypeId.ROADMAP,
              streetViewControlOptions: {
                  position: google.maps.ControlPosition.BOTTOM_CENTER
              },
              zoomControlOptions: {
                  position: google.maps.ControlPosition.LEFT_BOTTOM
              },
              styles: [
                {
                  "stylers": [
                    { "visibility": "on" },
                    { "weight": 1 },
                    { "hue": "#64B5F6" },
                    { "gamma": 0.75 }
                  ]
                },
                {
                  featureType: 'landscape',
                  elementType: 'geometry',
                  stylers: [
                    { hue: '#00ff00' }
                  ]
                },
                {
                  featureType: 'poi.park',
                  elementType: 'geometry',
                  stylers: [
                    { hue: '#00ff00' }
                  ]
                }
              ]
      });

      //responsivo
      google.maps.event.addDomListener(window, "resize", function() {
         var center = map.getCenter();
         google.maps.event.trigger(map, "resize");
         map.setCenter(center);
      });

      //cria o input para pesquisar no mapa
      var input = document.getElementById('pac-input');
      var fil = document.getElementById('btfiltro');
      var searchBox = new google.maps.places.SearchBox(input);
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
      map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(fil);

      // Bias the SearchBox results towards current map's viewport.
      map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
      });

      searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
          return;
        }

        // Encontra o lugar pesquisado
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
          var icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
          };

          //coloca o lugar em uma variável para dar fit no mapa
          if (place.geometry.viewport) {
            bounds.union(place.geometry.viewport);
          } else {
            bounds.extend(place.geometry.location);
          }
        });
        map.fitBounds(bounds);
      });

      //local dos ícones utilizados
      var icons = {
              mark1: {
                icon: 'images/mark1.png'
              },
              mark2: {
                icon: 'images/mark2.png'
              }
      };

      //função que adiciona marcadores
      function addMarker(feature) {
        var marker = new google.maps.Marker({
          position: feature.position,
          icon: icons[feature.type].icon,
          map: map,
          draggable:feature.draggable, // se pode ser arrastado
          info: feature.info //conteudo do marcador
        });

        google.maps.event.addListener(marker, 'click', function () {
          infowindow.setContent(this.info); //conteúdo do marcador
          infowindow.open(map, this);
        });

        markers.push(marker);
      }

      //criação da infowindow
     infowindow = new google.maps.InfoWindow(); // variável para criar a tela quando clica no marcador

      //uso de ícone personalizado e conteúdo de cada marker
      var features = [

        <?php
              $dados_json = $service->call('ponto.select',array(NULL));
              
              $ponto = json_decode($dados_json);
              $num = count($ponto);
              if (isset($_POST['tipos'])) {
                  $tipos = $_POST['tipos'];
                  for ($i=0;$i<$num;$i++){
                    $verifica = false;
                    $dados_json = $service->call('tipo_lixo_has_ponto.select_by_ponto',array($ponto[$i]->id));
                    $tipo_lixo_has_ponto = json_decode($dados_json);
                    for ($j=0;$j<count($tipo_lixo_has_ponto);$j++){
                      if (in_array($tipo_lixo_has_ponto[$j]->tipo_lixo_id, $tipos))
                        $verifica = true;
                    }
                    if(!$verifica)
                      continue;
                    else{
                        $dados_json = $service->call('endereco.select_by_id',array($ponto[$i]->endereco_id));
                        $endereco = json_decode($dados_json);
                        $dados_json = $service->call('tipo_lixo_has_ponto.select_by_ponto',array($ponto[$i]->id));
                        $tipo_lixo_has_ponto = json_decode($dados_json);
                        $pontos = "";
                        if (count($tipo_lixo_has_ponto) == 0)
                          $pontos += "No trash types!";
                        else{
                          for ($j=0;$j<count($tipo_lixo_has_ponto);$j++)
                          {
                            $dados_json1 = $service->call('tipo_lixo.select_by_id',array($tipo_lixo_has_ponto[$j]->tipo_lixo_id));
                            $tipo_lixo = json_decode($dados_json1);
                            if ($j != 0)
                              $pontos .= ", ";
                            $pontos = $pontos.$tipo_lixo[0]->nome;
                          }
                          if ($i!=0)
                            echo ",";
                          $dados_json1 = $service->call('empresa.select_by_id',array($ponto[$i]->empresa_id));
                          $emp = json_decode($dados_json1);
                        ?>
                        {
                          position: new google.maps.LatLng(<?php echo $endereco[0]->latitude . "," . $endereco[0]->longitude; ?>), 
                          type: 'mark1',
                          info:'<div id="content">'+
                                '<div id="siteNotice">'+
                                '</div>'+
                                '<h3 id="firstHeading" class="firstHeading"><?php echo $emp[0]->nome_fantasia; ?></h3>'+
                                '<div id="bodyContent">'+
                                '<p>Picks up: <?php echo $pontos; ?></p><p name="nome"> <?php echo $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais; ?></p>'+
                                '<p name="descricao"> <?php echo $ponto[$i]->observacao; ?> </p>'+
                                '<p name="descricao"> <?php echo $ponto[$i]->telefone; ?> </p>'+
                                '<form action="agendamentos.php" method="post">'+
                                '<input type="hidden" id="empresa_id" name="empresa_id" value="<?php echo $ponto[$i]->empresa_id; ?>">'+
                                '<input type="hidden" id="ponto_id" name="ponto_id" value="<?php echo $ponto[$i]->id; ?>">'+
                                '<button type="submit" name="agendar" id="agendar" class="btn btn-sm btn-theme pull-left">Schedule pickup</button>'+  
                                '</form>'+
                                '<form action="#" method="post">'+
                                '<a class="btn btn-sm btn-theme03 pull-right" id="rota" style="margin-left: 30px;" data-toggle="modal" data-target="#modalend" onclick="rota(<?php echo $endereco[0]->latitude.','.$endereco[0]->longitude;?>)">Create route</a><br>'+
                                '</form>'+
                                '</div>'+
                                '</div>',
                          draggable:false
                        }
                        <?php
                        
                      }

                    }
                  }
              }else{
                for ($i=0;$i<$num;$i++)
                {
                  $dados_json = $service->call('endereco.select_by_id',array($ponto[$i]->endereco_id));
                  $endereco = json_decode($dados_json);
                  $dados_json = $service->call('tipo_lixo_has_ponto.select_by_ponto',array($ponto[$i]->id));
                  $tipo_lixo_has_ponto = json_decode($dados_json);
                  $pontos = "";
                  if (count($tipo_lixo_has_ponto) == 0)
                    $pontos += "No trash types!";
                  else
                    for ($j=0;$j<count($tipo_lixo_has_ponto);$j++)
                    {
                      $dados_json1 = $service->call('tipo_lixo.select_by_id',array($tipo_lixo_has_ponto[$j]->tipo_lixo_id));
                      $tipo_lixo = json_decode($dados_json1);
                      if ($j != 0)
                        $pontos .= ", ";
                      $pontos = $pontos.$tipo_lixo[0]->nome_eng;
                    }
                    if ($i!=0)
                      echo ",";
                     $dados_json1 = $service->call('empresa.select_by_id',array($ponto[$i]->empresa_id));
                     $emp = json_decode($dados_json1);
                  ?>
                  {
                    position: new google.maps.LatLng(<?php echo $endereco[0]->latitude . "," . $endereco[0]->longitude; ?>), 
                    type: 'mark1',
                    info:'<div id="content">'+
                          '<div id="siteNotice">'+
                          '</div>'+
                          '<h3 id="firstHeading" class="firstHeading"><?php echo $emp[0]->nome_fantasia; ?></h3>'+
                          '<div id="bodyContent">'+
                          '<p>Picks up: <?php echo $pontos; ?></p><p name="nome"> <?php echo $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais; ?></p>'+
                          '<p name="descricao"> <?php echo $ponto[$i]->observacao; ?> </p>'+
                          '<p name="descricao"> <?php echo $ponto[$i]->telefone; ?> </p>'+
                          '<form action="agendamentos.php" method="post">'+
                          '<input type="hidden" id="empresa_id" name="empresa_id" value="<?php echo $ponto[$i]->empresa_id; ?>">'+
                          '<input type="hidden" id="ponto_id" name="ponto_id" value="<?php echo $ponto[$i]->id; ?>">'+
                          '<button type="submit" name="agendar" id="agendar" class="btn btn-sm btn-theme pull-left">Schedule pickup</button>'+  
                          '</form>'+
                          '<form action="#" method="post">'+
                          '<a class="btn btn-sm btn-theme03 pull-right" id="rota" style="margin-left: 30px;" data-toggle="modal" data-target="#modalend" onclick="rota(<?php echo $endereco[0]->latitude.','.$endereco[0]->longitude;?>) " >Create route</a><br>'+
                          '</form>'+
                          '</div>'+
                          '</div>',
                    draggable:false
                  }
                  <?php
                    }
                }
            ?>
      ];

      //cria as variáveis chamando as funções
      for (var i = 0, feature; feature = features[i]; i++) {
        addMarker(feature);
      }

      //cluster de marcadores
      var options = {
                imagePath: 'images/m'
      };

      markerCluster = new MarkerClusterer(map, markers, options); // cria cluster
      ds = new google.maps.DirectionsRenderer;
    }

function rota(lat,long)
{
    document.getElementById('latt').value = lat;
    document.getElementById('lonn').value = long;
}

function pegain(lati,longi) {
  var directionsDisplay = new google.maps.DirectionsRenderer;
  var directionsService = new google.maps.DirectionsService;
  ds.setMap(null);
  realiza_rota();
  directionsDisplay.setMap(map);
  infowindow.close();

  setMapOnAll(false);
  directionsService.route({
    origin: new google.maps.LatLng(lati,longi),
    destination: new google.maps.LatLng(document.getElementById('latt').value,document.getElementById('lonn').value),
    travelMode: google.maps.TravelMode.DRIVING
  }, function(response, status) {
    if (status === google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    } else {
      alert("We couldn't create your route, please, try again.");
    }
  });
  ds = directionsDisplay;
}
function setMapOnAll(mapi) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setVisible(mapi);
  }
}

function realiza_rota(){  
    markerCluster.clearMarkers();
    markerCluster.resetViewport();
    markerCluster.repaint();
    document.getElementById('btfiltro').innerHTML = '<i class="fa fa-remove"></i> Remove route';
    document.getElementById('btfiltro').setAttribute('data-target', ' ');
    document.getElementById('btfiltro').setAttribute('onclick', 'remover_rota()');
}

function remover_rota()
{
    ds.setMap(null);
    document.getElementById('btfiltro').setAttribute('onclick', '');
    document.getElementById('btfiltro').innerHTML = '<i class="fa fa-filter"></i>';
    document.getElementById('btfiltro').setAttribute('data-target', '#myModal');
    $('#myModal').modal('toggle');
    setMapOnAll(true);
    markerCluster.addMarkers(markers);
    markerCluster.resetViewport();
    markerCluster.repaint();
}
 </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmWPAIE9_AASg6Ijgoh0lVOZZ_VWvw6fg&libraries=places&callback=initAutocomplete" async defer></script>  


 
     <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>

    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

  </body>
</html>
