<?php
	require_once("permissao.php");
	$alert = "";
	if(isset($_POST["email"]))
	{
		require_once('../lib/nusoap.php');

		ini_set("soap.wsdl_cache_enabled", "1");
		$service = new nusoap_client('http://descartes.esy.es/index.php?wsdl', true);
		if(!$service->call("MandarEmail",array($_POST["name"],$_POST["email"],$_POST["message"])))
			$alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Captha ne donne pas!</b></div>';
		else
			$alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Message envoyé avec succès</b></div>';
	}

	require_once("../conectar_service.php");

?>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Infinity - Mobile App HTML5 Template">
	<meta name="keywords" content="keywords">
	<meta name="author" content="Audain Designs">
	<title>DescartesLab</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.css" rel="stylesheet">

	<!-- General Style -->
	<link href="style.css" rel="stylesheet">
	
	<!--Custom CSS-->
	<link href="custom.css" rel="stylesheet">

	<!-- Animations -->
	<link href="assets/css/style.css" rel="stylesheet">
	
	<!-- Owl Carousel -->
	<link href="css/owl.carousel.css" rel="stylesheet">
	
	<!-- Vendor Styles -->
	<link rel="stylesheet" type="text/css" href="vendor/push-menu/css/jasny-bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="vendor/animated-text/css/style.css" />
	
	<!-- Device Styles -->
	<link rel="stylesheet" type="text/css" href="css/devices/style.css">
	<script src="https://use.fontawesome.com/9c8fd2c64e.js"></script>

	<!-- Cover Styles (Skin) -->
	<link rel="stylesheet" type="text/css" href="css/landing/landing.css">
	
	<!--Fonts-->
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,200,100,500,600,700,800,900' rel='stylesheet' type='text/css'>
	<link href="css/fonts/font-awesome.css" rel="stylesheet">
	    <script src="js/markerclusterer.js"></script>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style>
		h4{
			color:white;
		}
		.verde{
			color:#11ABB0;
		}

      .btfiltro{
        padding: 15px;
        color: white;
        margin-bottom: 15px;
        margin-right: 15px;
      }

        input.form-control
        {
            height:auto;
            margin-top:5px;
            margin-bottom:5px;
        }
        .col-xs-6,.col-lg-6,.text-center
        {
            margin-bottom: 20px;
        }
    
</style>
</head>

<body data-spy="scroll" data-target="#nav-wrap" style="overflow-y: auto; overflow-x: hidden;" class="bg5">
<header class="mobile">
  <div class="row">
    <div class="col full">
      <div class="logo"><img src="logo2.png" height="45" alt="logo" width="130" style="margin-left:30px; margin-top:5px;" class="img-responsive"> </div>
      <nav id="nav-wrap" style="left: 25%;">
        <a class="mobile-btn" href="#nav-wrap" title="Show navigation">
        	<i class="fa fa-bars" style="color:white; margin-top:2px;margin-left:8px;font-size:36px;"></i>
        </a> 
        <a class="mobile-btn" href="#nvv" title="Hide navigation">
        	<i class="fa fa-bars" style="color:white; margin-top:2px;margin-left:8px;font-size:36px;"></i>
        </a>
        <ul id="nav" class="nav" >
          <li><a href="#landing">Accueil</a></li>
          <li><a href="#pesquise">Chercher</a></li>
          <li><a href="#descubra">Registre</a></li>
          <li><a href="#sobre">Propos</a></li>
          <li><a href="#contato">Contact</a></li>
          <li><a class="portfolio-link btn" data-toggle="modal" data-target="#login_modal">S'identifier</a></li>
          <li><a href="../../pt/index/"><img src="img/bndbr.png" width="20" alt="bandeira"></a></li>
        </ul>
      </nav>
    </div>
  </div>
</header>
	<!-- Main Content -->
	<section id="landing" class="bg">
	<div class="bgmap">
		<div class="container">
			<!-- Main Content Inner -->
			<div class="row margin-lg" style="margin-top: 55px;">
			<!--Visible on LG MD-->
			<?php echo $alert; ?>
				<div class="col-lg-4 col-md-4 visible-lg visible-md">
					<div class="cd-intro">
						<div class="cd-headline letters rotate-3">
							
							<div class="landing-heading padding-sm" style="background-color: rgba(0,0,0,0.5);color: white">
								<span class="txt-lg" style="margin-left: 10px;">DescartesLab: </span>
								<span class="txt-lg cd-words-wrapper text-right">
									<b class="is-visible">Penser</b>
									<b>Regarde</b>
									<b>Jeter</b>
								</span>
							</div>
							<div class="landing-text text-right">
								<span class="txt-md">Une application simple et facile à utiliser pour trouver des sites de collecte près de chez vous.</span>
							</div>
						</div>
						<div class="text-right h-quote">
							<div class="landing-quote quote-text">
								<span>"Trouvez les points de collecte et rendez votre vie plus facile, et aider l'environnement."</span>
							</div>
						</div>
					</div>
				</div>
				<!--/Visible on LG MD-->
				<!--Visible on XS SM-->
				<div class="col-sm-12 visible-xs visible-sm">
					<div class="cd-intro">
						<div class="cd-headline letters rotate-3">
							<div class="landing-heading text-center padding-sm" style="background-color: rgba(0,0,0,0.5);color:white;">
								<span class="txt-lg">DescartesLab </span>
								<span class="txt-lg cd-words-wrapper center">
									<b class="is-visible">Penser</b>
									<b>Regarde</b>
									<b>Jeter</b>
							</div>
							<div class="landing-text text-right">
								<span class="txt-md">Une application simple et facile à utiliser pour trouver des sites de collecte près de chez vous.</span>
							</div>
						</div>
						<div class="text-center h-quote">
							<div class="landing-quote quote-text">
								<span>"Trouvez les points de collecte et rendez votre vie plus facile, et aider l'environnement."</span>
							</div>
						</div>
					</div>
				</div>
				<!--/Visible on XS SM-->
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<!--Device Container-->
					<div class="device-container i6 iphone-silver">
						<div class="device-container-inner">
							<div id="app-showcase" class="owl-carousel owl-theme">
							  <div class="item"><img src="img/cover/4.jpg" class="img-responsive" alt="Iphone Application 1"></div>
							  <div class="item"><img src="img/cover/5.png" class="img-responsive" alt="Iphone Application 2"></div>
							  <div class="item"><img src="img/cover/1.png" class="img-responsive" alt="Iphone Application 3"></div>
							</div>
						</div>
					</div>
					<!--/Device Container-->
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="app-availability">
						<a href="https://itunes.apple.com/br/app/descarteslab/id1169096438?l=en&mt=8" class="btn btn-store"><img src="img/stores/btn-app-store.png" class="img-responsive" alt="app store"></a>
						<a href="https://play.google.com/store/apps/details?id=br.senai.sc.descarteslab" class="btn btn-store"><img src="img/stores/btn-google-play.png" class="img-responsive" alt="google store"></a>
					</div>
				</div>
			</div>
			<!-- /Main Content Inner -->
		</div>
		</div>		
	</section>
	<div class="container">
      <div class="modal fade" id="myModal" role="dialog" style="z-index: 20000000;">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Sélection du type d'ordures</h4>
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
                <button type="submit" class="btn btn-theme" id="seleciona" name="seleciona">Sélectionner</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

	<section id="pesquise">
		<div class="container">
			<div class="row margin-lg text-center">
				<div class="col-lg-12 text-center no-margin-top">
						<span class="section-title" style="color:white">Chercher</span>
				</div>
			<div class="col-lg-12">
			<input id="pac-input" class="controls" type="text" placeholder="rechercher les paramètres régionaux">
			 <a id="btfiltro" class="btn btn-theme03 btfiltro" data-toggle="modal" data-target="#myModal"><i class="fa fa-filter"></i></a>
    		<div id="map"></div>

			</div>
			</div>
		</div>
	</section>

	<!-- /Main Content -->
	<section id="descubra" class="bg3">
	<div class="bg2" style="width:100%">
		<div class="container">
			<!-- testimonials Content Inner -->
			<div class="row margin-lg text-center">
				<div class="col-lg-12 text-center margin-lg no-margin-top">
					<span class="section-title" style="color:white">Registre</span>
				</div>
				
					<div class="col-lg-12 bg2">
						<div class="col-lg-6" style="margin-top: 20px;">
							<div class="col-lg-4"></div>
							<div class="testimonial-img">
								<img src="img/landing/testimonials/pessoa.png" class="img-responsive img-circle" alt="person" height="150" width="150">
							</div>
							<h4 class="pull-left"><span style="font-size: 28px;"><i class="fa fa-angle-right"></i></span> Filtrer les points de collecte à partir du type de détritus que vous souhaitez jeter;</h4>
							<h4 class="pull-left"><span style="font-size: 28px;"><i class="fa fa-angle-right"></i></span> Recherchez le point de collecte le plus proche;</h4>
							<h4 class="pull-left"><span style="font-size: 28px;"><i class="fa fa-angle-right"></i></span> Planifier la collecte des déchets.</h4>
							<div class="row">
								<div class="col-md-12" style="margin-bottom: 30px;margin-top: 70px;">
									<a class="btn-store" style="padding: 15px 20px; text-decoration: none;" href="cadastro_pessoa.php">Registre</a>
								</div>
							</div>
						</div>
						<div class="col-lg-6" style="margin-top: 20px;">
							<div class="col-lg-4"></div>

							<div class="testimonial-img">
								<img src="img/landing/testimonials/ind3.png" class="img-responsive img-circle" alt="person" height="150" width="150">
							</div>
							<h4 class="pull-left"><span style="font-size: 28px;"><i class="fa fa-angle-right"></i></span> Enregistrez tous les points de collecte de votre entreprise;</h4>
							<h4 class="pull-left"><span style="font-size: 28px;"><i class="fa fa-angle-right"></i></span> Choisissez de recevoir ou non des horaires;</h4>
							<h4 class="pull-left"><span style="font-size: 28px;"><i class="fa fa-angle-right"></i></span> Carte avec des rassemblements programmés.</h4>
							<div class="row">
								<div class="col-md-12" style="margin-bottom: 30px;margin-top: 85px;">
									<a class="btn-store" style="padding: 15px 20px; text-decoration: none" href="cadastro_empresa.php">Registre</a>
								</div>
							</div>
						</div>
					</div>
			</div>

			<!-- /testimonials Content Inner -->
		</div>
		</div>
	</section>

	<section  id="sobre">
		<div class="container-fluid">
			<div class="col-lg-12 text-center margin-lg no-margin-top">
				<span class="section-title" style="color:white">Propos</span>
			</div>
			<div class="row text-center">
				<div class="col-md-12">
			    	<div class="col-md-4">
						<img src="img/Andrew.jpg" class="img-responsive img-circle" alt="person" height="200" width="200" style="margin:0px auto;display:block;border:solid;border-color: #FFD449; padding:5px;">
						<br>
						<label for="form_name" style="color: white;">Andrew Malta Silva</label>
						<br>
						<label for="form_name" style="color: white">Solutions logicielles pour les entreprises</label>
						<p style="color: white">Technicien informatique</p>
					</div>
					<div class="col-md-4">
						<img src="img/Diovanna.jpg" class="img-responsive img-circle" alt="person" height="200" width="200" style="margin:0px auto;display:block;border:solid;border-color: #FFD449; padding:5px;">
						<br>
						<label for="form_name" style="color: white">Diovanna Caroline Schell</label>
						<br>
						<label for="form_name" style="color: white">Création de sites web</label>
						<p style="color: white">Formation industrielle en informatique</p>
						<p style="color: white">Technicien informatique</p>
					</div>
					<div class="col-md-4">
						<img src="img/Edenilson.jpg" class="img-responsive img-circle" alt="person" height="200" width="200" style="margin:0px auto;display:block;border:solid;border-color: #FFD449; padding:5px;">
						<br>
						<label for="form_name" style="color: white">Edenilson Gonçalves</label>
						<br>
						<label for="form_name" style="color: white">Infrastructure et réseaux locaux</label>
						<p style="color: white">Appui à l'apprentissage industriel et à la maintenance des ordinateurs personnels et des réseaux locaux</p>
						<p style="color: white">Formation industrielle en informatique</p>
					</div>
				 </div>
			</div>
			<div class="row text-center">
				<div class="col-md-12">
					<div class="col-md-2">
					</div>
					<div class="col-md-4">
						<img src="img/Gabriel.jpg" class="img-responsive img-circle" alt="person" height="200" width="200" style="margin:0px auto;display:block;border:solid;border-color: #FFD449; padding:5px;">
						<br>
						<label for="form_name" style="color: white">Gabriel Vassoler</label>
						<br>
						<label for="form_name" style="color: white">Solutions logicielles pour les entreprises</label>
						<p style="color:white;">Appui à l'apprentissage industriel et à la maintenance des ordinateurs personnels et des réseaux locaux</p>
					    <p style="color:white;">Formation industrielle en informatique</p>
						<p style="color:white;">Technicien informatique</p>
					</div>
					<div class="col-md-4">
						<img src="img/Wagner.jpg" class="img-responsive img-circle" alt="person" height="200" width="200" style="margin:0px auto;display:block;border:solid;border-color: #FFD449; padding:5px;">
						<br>
						<label for="form_name" style="color: white;font-decoration:bold;">Wagner Titon</label>
						<br>
						<label for="form_name" style="color: white">Chef de projet</label>
						<p style="color: white">Spécialiste de l'éducation SENAI / SC<p>
					</div>
					<div class="col-md-2">
					</div>
				</div>
			</div>
			<div class="row" style="margin-bottom:20px; margin-top:20px;">
				<div class="col-md-12">
					<div class="col-md-6">
						<iframe style="margin:0px auto;display:block;width:100%; height:350px;border:solid;border-color:white; max-width:500px;" src="https://www.youtube.com/embed/jirB2jNUd5Q" allowfullscreen></iframe>
					</div>
					<div class="col-md-6">
						<iframe style="margin:0px auto;display:block;width:100%; height:350px;border:solid;border-color:white; max-width:500px;" src="https://www.youtube.com/embed/uu5SPQDiFYE" allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="contato" class="bg4">
		<div class="container-fluid">
			<div class="col-md-6">
				<p style="color:white;margin-top:30px;font-size:20px;color:#393939;">Développé par l'équipe représentant Santa Catarina dans le défi lancé par le personnel du domaine technologique de l'Inofrmação et de la Communication dans les Olympiades de la Connaissance en 2016.<p>
			 	<p style="color:white;margin-top:120px;font-size:20px;color:#393939;">Exploit:<p>
				<img src="img/olimpiada.png" class="img-responsive" alt="person" style="margin-left:10px; margin-top:10px;">
				<img src="img/senai.png" class="img-responsive" alt="person" style="margin-left:10px;margin-top:30px; height:70px; weight:100px;" >
			</div>
			<div class="col-md-6" style="padding-bottom: 20px">
				<form id="contact-form" method="post" action="#" role="form" >

			    <div class="messages"></div>
			      <div class="section-title" style="font-size: 28px; padding-left:0;color: white">Contact</div>
				   <div class="controls" style="box-shadow:none !important">
	
			        <div class="row">
			            <div class="col-md-12">
			                <div class="form-group">
			                    <label for="form_name" style="color: white; font-size:17px;">Prénom</label>
			                    <input id="form_name" type="text" name="name" class="form-control" placeholder="Prénom" required="required">
			                    <div class="help-block with-errors"></div>
			                </div>
			            </div>
			        </div>
			        <div class="row">
			            <div class="col-md-12">
			                <div class="form-group">
			                    <label for="form_email" style="color: white; font-size:17px;">Email</label>
			                    <input id="form_email" type="email" name="email" class="form-control" placeholder="Email" required="required">
			                    <div class="help-block with-errors"></div>
			                </div>
			            </div>
			        </div>
			        <div class="row">
			            <div class="col-md-12">
			                <div class="form-group">
			                    <label for="form_message" style="color: white; font-size:17px;">Message</label>
			                    <textarea id="form_message" name="message" class="form-control" placeholder="Message" rows="4" required="required"></textarea>
			                    <div class="help-block with-errors"></div>
			                </div>
			            </div>
					    <div class="col-md-12" style="margin-top: 20px; margin-bottom:0px">
						   <div class="form-group">    
							  <button type="submit" class="btn btn-store" style="padding: 15px 20px;color:#393939;">Envoyer</button>
	                       </div>					
						</div>
			        </div>
			    </div>

				</form>
			</div>
		</div>

		<div class="container">
		  <div class="modal fade" id="login_modal" role="dialog" style="z-index: 20000000;">
		    <div class="modal-dialog">
		      <!-- Modal content-->
		      <div class="modal-content">
		        <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal">&times;</button>
		            <h4 class="modal-title">S'identifier</h4>
		        </div>
		        <form action="logar.php" method="post">
		          <div class="esp1 col-md-12" style="margin:0px auto;display:block;">
						<input type="email" id="email" name="email" class="form-control" placeholder="Email" required autofocus>
						<input type="password" id="senha" name="senha" class="form-control" placeholder="mot de passe" required>	
				  </div>
		          <div class="modal-footer">
		            <button type="submit" class="btn btn-theme">entrer</button>
		            <a href="#descubra" style="color:#21D97B; margin-left:15px;" data-dismiss="modal">Inscription</a>
		          </div>
		        </form>
		      </div>
		    </div>
		  </div>
		</div>
	</section>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<!-- Compiled JS/Scripts -->
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script src="js/owl.carousel.js"></script>
<script src="js/modernizr.js"></script>
<script src="js/wow.min.js"></script>

<!-- Cover Scripts -->
<script src="js/cover/owl-cover.js"></script>
<script src="js/landing/owl-landing.js"></script>

<!-- Vendor Scripts -->
<script src="vendor/push-menu/js/jasny-bootstrap.min.js"></script>
<script src="vendor/animated-text/js/main.js"></script>
<script src="vendor/lightbox/js/lightbox.min.js"></script>
<script type="text/javascript">
	$(function() {
  $('a[href*="#"]:not([href="#"],[href="#nav-wrap"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});
</script>
<script>
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
                  $a = 0;
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
                          $pontos += "Sem tipos de lixo!";
                        else{
                          for ($j=0;$j<count($tipo_lixo_has_ponto);$j++)
                          {
                            $dados_json1 = $service->call('tipo_lixo.select_by_id',array($tipo_lixo_has_ponto[$j]->tipo_lixo_id));
                            $tipo_lixo = json_decode($dados_json1);
                            if ($j != 0)
                              $pontos .= ", ";
                            $pontos = $pontos.$tipo_lixo[0]->nome;
                          }
                          if ($i != 0 && $a != 0){
                          	echo ",";
                          }
                          $a = 1;
                            
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
                                '<p>Recueille: <?php echo $pontos; ?></p><p name="nome"> <?php echo $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais; ?></p>'+
                                '<p name="descricao"> <?php echo $ponto[$i]->observacao; ?> </p>'+
                                '<p name="descricao"> <?php echo $ponto[$i]->telefone; ?> </p>'+
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
                    $pontos += "Sem tipos de lixo!";
                  else
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

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmWPAIE9_AASg6Ijgoh0lVOZZ_VWvw6fg&libraries=places&callback=initAutocomplete&language=fr" async defer></script>

    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>

<!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information.
	<script type="text/javascript">
		
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-12345678-1']);
		_gaq.push(['_trackPageview']);
	
		(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	
	</script>
 -->
</body>
</html>