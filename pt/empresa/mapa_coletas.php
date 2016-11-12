<?php 
  require_once("permissao.php"); 
  require_once("../conectar_service.php");
?>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>DescartesLab</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">    
    
    <script src="https://use.fontawesome.com/9c8fd2c64e.js"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/table-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>
    <style type="text/css">

      #map {
        height: 550px;
        margin: 5px 5px 5px 5px;
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
	
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" >
      
      <?php
          require_once("navtop.php");
      ?>    
  
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT  TABELA RESPONSIVA
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
        <section class="wrapper">
          <h3><i class="fa fa-angle-right"></i> Mapa de coletas</h3>
          <div class="row mt">
            <div class="col-lg-12">
              <div class="panel">
                <form action="#" method="post" id="submete">        
                  <input type="hidden" name="lat" id="lat" value="e">
                  <input type="hidden" name="long" id="long" value="e">
                </form>
                <input id="pac-input" class="controls" type="text" placeholder="Pesquise a localidade"> </input>
                <div id="map"></div>                  
              </div><!-- /content-panel -->
            </div><!-- /col-lg-12 -->
          </div><!-- /row -->
        </section><! --/wrapper -->

     </section><!-- Conteiner-->

    <!--script mapa -->
    <script>
      function initAutocomplete() {
        var poder = true; // somente utilizada quando a empresa for criar um ponto para selecionar o local
        var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 2,
                center: new google.maps.LatLng(16.770881080415, 12.3046875),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
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
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
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
        var infowindow = new google.maps.InfoWindow(); // variável para criar a tela quando clica no marcador

        //variáveis de conteudo, substituir depois pela info no features
        var contentString = '<div id="content">'+
          '<div id="siteNotice">'+
          '</div>'+
          '<h1 id="firstHeading" class="firstHeading">NOME DO PONTO '+1+'</h1>'+
          '<div id="bodyContent" class="col-sm-12">'+
          '<p class="col-sm-6"> OLHA O CONTEÚDO DO PONTO MAHOE</p>'+
          '<p class="col-sm-6"> OEIOEIOEIOEOEIOEIEOIEOEI </p><p>'+
          '<p>'+
          '<button class="btn btn-primary" onclick="submeter();">SUCESSO!</button>'+
          ''+
          '</p>'+'</p>'+
          '</div>'+
          '</div>';

        //uso de ícone personalizado e conteúdo de cada marker
        var features = [

          <?php
                $dados_json = $service->call('agendamento.select_aceitos_by_empresa',array($_SESSION['id']));
                $aceitos = json_decode($dados_json);
                $num = count($aceitos);
                for ($i=0;$i<$num;$i++)
                {
                  $dados_json = $service->call('endereco.select_by_id',array($aceitos[$i]->endereco_id));
                  $endereco = json_decode($dados_json);
                  $dados_json = $service->call('usuario.select',array("id = ".$aceitos[$i]->usuario_id));
                  $Usuarioponto = json_decode($dados_json);
                  ?>
                  {
                    position: new google.maps.LatLng(<?php echo $endereco[0]->latitude . "," . $endereco[0]->longitude; ?>), 
                    type: 'mark1',
                    info:'<div id="content">'+
                          '<div id="siteNotice">'+
                          '</div>'+
                          '<h1 id="firstHeading" class="firstHeading"><?php echo $Usuarioponto[0]->nome; ?> - Aceitos</h1>'+
                          '<div id="bodyContent" class="col-sm-12">'+
                          '<p name="nome" class="col-sm-6"> <?php echo $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais; ?></p>'+
                          '<p name="data_agendamento" class="col-sm-6"> <?php echo $aceitos[$i]->data_agendamento; ?> </p>'+
                          '<p name="horario" class="col-sm-6"> <?php echo $aceitos[$i]->horario; ?> </p>'+
                          
                          '<form action="#" method="post">'+
                          '</form>'+
                          '</div>'+
                          '</div>',
                    draggable:false
                  }
                  <?php
                  if ($i!=$num-1) {
                    echo ",";
                  }
                }

                $dados_json = $service->call('agendamento.select_atrasados_by_empresa',array($_SESSION['id']));
                $atrasados = json_decode($dados_json);
                $num1 = count($atrasados);
                if ($num>0 && $num1>0) {echo ",";}
                for ($i=0;$i<$num1;$i++)
                {
                  $dados_json = $service->call('endereco.select_by_id',array($atrasados[$i]->endereco_id));
                  $endereco = json_decode($dados_json);
                  $dados_json = $service->call('usuario.select',array("id = ".$atrasados[$i]->usuario_id));
                  $Usuarioponto = json_decode($dados_json);
                  ?>
                  {
                    position: new google.maps.LatLng(<?php echo $endereco[0]->latitude . "," . $endereco[0]->longitude; ?>), 
                    type: 'mark1',
                    info:'<div id="content">'+
                          '<div id="siteNotice">'+
                          '</div>'+
                          '<h1 id="firstHeading" class="firstHeading"><?php echo $Usuarioponto[0]->nome; ?> - Atrasados</h1>'+
                          '<div id="bodyContent" class="col-sm-12">'+
                          '<p name="nome" class="col-sm-6"> <?php echo $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais; ?></p>'+
                          '<p name="data_agendamento" class="col-sm-6"> <?php echo $atrasados[$i]->data_agendamento; ?> </p>'+
                          '<p name="horario" class="col-sm-6"> <?php echo $atrasados[$i]->horario; ?> </p>'+
                          
                          '<form action="#" method="post">'+
                          '</form>'+
                          '</div>'+
                          '</div>',
                    draggable:false
                  }
                  <?php
                  if ($i!=$num1-1) {
                    echo ",";
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

        var markerCluster = new MarkerClusterer(map, markers, options); // cria cluster
      }

      function submeter()
      {
        document.getElementById("submete").submit();
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmWPAIE9_AASg6Ijgoh0lVOZZ_VWvw6fg&libraries=places&callback=initAutocomplete" async defer></script>  

        <!-- js placed at the end of the document so the pages load faster -->

    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

  </body>
</html>
