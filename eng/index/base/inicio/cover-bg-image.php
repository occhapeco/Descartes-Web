<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Infinity - Mobile App HTML5 Template">
	<meta name="keywords" content="keywords">
	<meta name="author" content="Audain Designs">
	<title>DescartesLab</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- General Style -->
	<link href="style.css" rel="stylesheet">
	
	<!--Custom CSS-->
	<link href="custom.css" rel="stylesheet">

	<!-- Animations -->
	<link href="css/animate.css" rel="stylesheet">
	
	<!-- Owl Carousel -->
	<link href="css/owl.carousel.css" rel="stylesheet">
	<link href="css/owl.theme.css" rel="stylesheet">
	<link href="css/owl.transitions.css" rel="stylesheet">
	
	<!-- Vendor Styles -->
	<link rel="stylesheet" type="text/css" href="vendor/push-menu/css/jasny-bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="vendor/push-menu/css/push-menu.css" />
	<link rel="stylesheet" type="text/css" href="vendor/animated-text/css/style.css" />
	
	<!-- Device Styles -->
	<link rel="stylesheet" type="text/css" href="css/devices/style.css">
	<script src="https://use.fontawesome.com/9c8fd2c64e.js"></script>

	<!-- Cover Styles (Skin) -->
	<link rel="stylesheet" type="text/css" href="css/landing/landing.css">
	
	<!--Fonts-->
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,200,100,500,600,700,800,900' rel='stylesheet' type='text/css'>
	<link href="css/fonts/font-awesome.css" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<style>
	h4{
		color:white;
	}
	.verde{
		color:#11ABB0;
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

<body data-spy="scroll" data-target="#nav-wrap" style="overflow-y: auto; overflow-x: hidden;" class="bg5">
<header class="mobile">
  <div class="row">
    <div class="col full">
      <div class="logo"> <a href="#"><img alt=""></a> </div>
      <nav id="nav-wrap" style="left: 25%;">
        <a class="mobile-btn" href="#nav-wrap" title="Show navigation">
        	<i class="fa fa-bars" style="color:white; margin-top:2px;margin-left:8px;font-size:36px;"></i>
        </a> 
        <a class="mobile-btn" href="#nvv" title="Hide navigation">
        	<i class="fa fa-bars" style="color:white; margin-top:2px;margin-left:8px;font-size:36px;"></i>
        </a>
        <ul id="nav" class="nav" >
          <li><a href="#landing">Início</a></li>
          <li><a href="#pesquise">Pesquise</a></li>
          <li><a href="#descubra">Cadastre-se</a></li>
          <li><a href="#sobre">Sobre nós</a></li>
          <li><a href="#contato">Contato</a></li>
          <li class="visible-xs-block portfolio-item">
                    <a class="portfolio-link btn" data-toggle="modal" href="#login_modal">Login</a>
                </li>
				<!--Login dropdown-->
				<li class="dropdown">
                    <a href="#" class="dropdown-toggle btn hidden-xs" data-toggle="dropdown">Login <b class="caret"></b></a>
                    <ul class="dropdown-menu" style="min-width: 200px;min-height: 180px;">
                        <li>                               
							<div class="container-fluid text-center" style="  margin-top:20px;">
                                <form method="POST" action="#">
									<div class="esp1" align="center">
										<input type="email" id="email" name="email" class="form-control" placeholder="Email" required autofocus style="margin-bottom:10px;">
										<input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required style="margin-bottom:20px;">	
									</div>
									<div class="col-xs-12 col-sm-12">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary" id="login" name="login">Entrar</button>
                                        </div>
                                    </div>  
                                </form>
							</div>
                        </li>
                    </ul>
                </li>
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
				<div class="col-lg-4 col-md-4 visible-lg visible-md">
					<div class="cd-intro">
						<div class="cd-headline letters rotate-3">
							<div class="landing-heading padding-sm" style="//background-color: rgba(0,0,0,0.5);color: white">
								<span class="txt-lg" style="margin-left: 10px;">DescartesLab: </span>
								<span class="txt-lg cd-words-wrapper text-right">
									<b class="is-visible">Pense</b>
									<b>Procure</b>
									<b>Descarte</b>
								</span>
							</div>
							<div class="landing-text text-right">
								<span class="txt-md">Uma aplicação simples e fácil de usar para encontrar pontos de coleta perto de você.</span>
							</div>
						</div>
						<div class="text-right h-quote">
							<div class="landing-quote quote-text">
								<span>"Encontre os pontos de coleta e facilite sua vida, além de ajudar o meio ambiente"</span>
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
									<b class="is-visible">Pense</b>
									<b>Procure</b>
									<b>Descarte</b>
							</div>
							<div class="landing-text text-right">
								<span class="txt-md">Uma aplicação simples e fácil de usar para encontrar pontos de coleta perto de você.</span>
							</div>
						</div>
						<div class="text-center h-quote">
							<div class="landing-quote quote-text">
								<span>"Encontre os pontos de coleta e facilite sua vida, além de ajudar o meio ambiente"</span>
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
							  <div class="item"><img src="img/cover/batata.png" class="img-responsive" alt="Iphone Application 1"></div>
							  <div class="item"><img src="img/cover/batata.png" class="img-responsive" alt="Iphone Application 2"></div>
							  <div class="item"><img src="img/cover/batata.png" class="img-responsive" alt="Iphone Application 3"></div>
							</div>
						</div>
					</div>
					<!--/Device Container-->
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="app-availability">
						<a href="#" class="btn btn-store"><img src="img/stores/btn-app-store.png" class="img-responsive" alt="app store"></a>
						<a href="#" class="btn btn-store"><img src="img/stores/btn-google-play.png" class="img-responsive" alt="google store"></a>
					</div>
				</div>
			</div>
			<!-- /Main Content Inner -->
		</div>
		</div>		
	</section>

	<section id="pesquise" class="">
	<div class="">
		<div class="container">
			<div class="row margin-lg text-center">
				<div class="col-lg-12 text-center no-margin-top">
						<span class="section-title" style="color:white">Pesquise</span>
				</div>
			<div class="col-lg-12">
			<input id="pac-input" class="controls" type="text" placeholder="Pesquise a localidade">
    		<div id="map"></div>

			</div>
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
					<span class="section-title" style="color:white">Cadastre-se</span>
				</div>
				
					<div class="col-lg-12 bg2">
						<div class="col-lg-6 divider-vertical" style="margin-top: 20px;">
							<center>
								<div class="testimonial-img">
									<img src="img/landing/testimonials/pessoa.png" class="img-responsive img-circle" alt="person" height="150px" width="150px">
								</div>
							</center>
							<h4 class="pull-left"><span style="font-size: 28px;"><i class="fa fa-angle-right"></i></span> Filtre os pontos de coleta a partir do tipo de lixo que deseja descartar;</h4>
							<h4 class="pull-left"><span style="font-size: 28px;"><i class="fa fa-angle-right"></i></span> Procure o ponto de coleta mais próximo a você;</h4>
							<h4 class="pull-left"><span style="font-size: 28px;"><i class="fa fa-angle-right"></i></span> Agende o recolhimento do lixo.</h4>
							<div class="row">
								<div class="col-md-12" style="margin-bottom: 30px;margin-top: 30px;">
									<a class="btn-store" style="padding: 15px 20px; text-decoration: none" href="cadastro_pessoa">Cadastre-se</a>
								</div>
							</div>
						</div>
						<div class="col-lg-6" style="margin-top: 20px;">
						<center>
							<div class="testimonial-img">
								<img src="img/landing/testimonials/ind3.png" class="img-responsive img-circle" alt="person" height="150px" width="150px">
							</div>
						</center>
							<h4 class="pull-left"><span style="font-size: 28px;"><i class="fa fa-angle-right"></i></span> Cadastre todos os pontos de coleta da sua empresa;</h4>
							<h4 class="pull-left"><span style="font-size: 28px;"><i class="fa fa-angle-right"></i></span> Escolha se deseja receber agendamentos ou não;</h4>
							<h4 class="pull-left"><span style="font-size: 28px;"><i class="fa fa-angle-right"></i></span> Mapa com os recolhimentos agendados.</h4>
							<div class="row">
								<div class="col-md-12" style="margin-bottom: 30px;margin-top: 40px;">
									<a class="btn-store" style="padding: 15px 20px; text-decoration: none" href="cadastro_empresa">Cadastre-se</a>
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
			<center><div class="section-title" style="font-size: 28px; padding-left:0;color: white">Sobre Nós</div></center>
			<div class="row">
				<div class="col-md-12">
				    <center>
				    	<div class="col-md-4">
							<img src="img/Andrew.jpg" class="img-responsive img-circle" height="200px" width="200px" style="border:solid;border-color: #FFD449; padding:5px;">
							<br>
							<label for="form_name" style="color: #393939">Andrew Malta Silva</label>
							<br>
							<label for="form_name" style="color: white">Soluções de software para negócios</label>
							<p style="color: white">Técnico em Informática</p>
						</div>
						<div class="col-md-4">
							<img src="img/Diovanna.jpg" class="img-responsive img-circle" height="200px" width="200px" style="border:solid;border-color: #FFD449; padding:5px;">
							<br>
							<label for="form_name" style="color: white">Diovanna Caroline Schell</label>
							<br>
							<label for="form_name" style="color: white">Web Design</label>
							<p style="color: white">Aprendizagem industrial em informática</p>
							<p style="color: white">Técnico em informática</p>
						</div>
						<div class="col-md-4">
							<img src="img/Edenilson.jpg" class="img-responsive img-circle" height="200px" width="200px" style="border:solid;border-color: #FFD449; padding:5px;">
							<br>
							<label for="form_name" style="color: white">Edenilson Gonçalves</label>
							<br>
							<label for="form_name" style="color: white">Infraestrutura e redes locais</label>
							<p style="color: white">Aprendizagem industrial em suporte e manutenção de microcomputadores e redes locais</p>
							<p style="color: white">Aprendizagem industrial em informática</p>
						</div>
				 	</center>
				 </div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<center>
					<div class="col-md-2">
					</div>
					<div class="col-md-4">
						<img src="img/Gabriel.jpg" class="img-responsive img-circle" height="200px" width="200px" style="border:solid;border-color: #FFD449; padding:5px;">
						<br>
						<label for="form_name" style="color: white">Gabriel Vassoler</label>
						<br>
						<label for="form_name" style="color: white">Soluções de software para negócios</label>
						<p style="color:white;">Aprendizagem industrial em suporte e manutenção de microcomputadores e redes locais</p>
					    <p style="color:white;">Aprendizagem industrial em informática</p>
						<p style="color:white;">Técnico em informática</p>
					</div>
					<div class="col-md-4">
						<img src="img/Wagner.jpg" class="img-responsive img-circle" height="200px" width="200px" style="border:solid;border-color: #FFD449; padding:5px;">
						<br>
						<label for="form_name" style="color: white;font-decoration:bold;">Wagner Titon</label>
						<br>
						<label for="form_name" style="color: white">Gestor do Projeto</label>
						<p style="color: white">Especialista de ensino SENAI/SC<p>
					</div>
					<div class="col-md-2">
					</div>
					</center>
				</div>
			</div>
		</div>
	</section>
	<section id="contato" class="bg4">
		<div class="container-fluid">
			<div class="col-md-6">
				<p style="color:white;margin-top:30px;font-size:20px;">Desenvolvido pelos competidores da olimpíada do conhecimento da ocupação de técnologia da informação e comunicação<p>
			 	<p style="color:white;margin-top:170px;font-size:20px;">Realização:<p>
				<img src="img/olimpiada.png" class="img-responsive" style="margin-left:30px; margin-top:10px;">
				<img src="img/senai.png" class="img-responsive" style="margin-left:30px;margin-top:30px;" >
			</div>
			<div class="col-md-6" style="padding-bottom: 20px">
				<form id="contact-form" method="post" action="validar.php" role="form" >

			    <div class="messages"></div>
			    <div class="section-title" style="font-size: 28px; padding-left:0;color: white">Entre em contato</div>

			    <div class="controls" style="box-shadow:none !important">

			        <div class="row">
			            <div class="col-md-6">
			                <div class="form-group">
			                    <label for="form_name" style="color: white">Nome</label>
			                    <input id="form_name" type="text" name="name" class="form-control" placeholder="Nome" required="required" data-error="Firstname is required.">
			                    <div class="help-block with-errors"></div>
			                </div>
			            </div>
			        </div>
			        <div class="row">
			            <div class="col-md-6">
			                <div class="form-group">
			                    <label for="form_email" style="color: white">Email</label>
			                    <input id="form_email" type="email" name="email" class="form-control" placeholder="Email" required="required" data-error="Valid email is required.">
			                    <div class="help-block with-errors"></div>
			                </div>
			            </div>
			        </div>
			        <div class="row">
			            <div class="col-md-12">
			                <div class="form-group">
			                    <label for="form_message" style="color: white">Mensagem</label>
			                    <textarea id="form_message" name="message" class="form-control" placeholder="Mensagem" rows="4" required="required" data-error="Please,leave us a message."></textarea>
			                    <div class="help-block with-errors"></div>
			                </div>
			            </div>
					    <img src="captcha.php?l=150&a=50&tf=20&ql=5" class="pull-left" style="margin-left:15px; margin-top:15px;">
						<div class="col-md-6">
							<label for="form_message" style="color: white">Palavra</label>
					        <input type="text" name="palavra" class="form-control" placeholder="Insira aqui a palavra ao lado" />
					    </div>
					    <div class="col-md-12" style="margin-bottom: 20px;margin-top: 20px;margin-left: 15px;">
							<button type="submit" class="btn-store" style="padding: 15px 20px;" value="Validar Captcha">Enviar</button>
						</div>
			        </div>
			    </div>

				</form>
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
      function initAutocomplete() {
        var poder = true; // somente utilizada quando a empresa for criar um ponto para selecionar o local
        var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 11,
                center: new google.maps.LatLng(-23.5833158, -46.6339829),
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

        //usuário clica e cria marcador - evento de clique
        google.maps.event.addListener(map, 'click', function(event) {
          if(poder)
          {
            var temp =[
              {
                position: event.latLng,
                type: 'mark1',
                info: contentString,
                draggable:true
              }
            ];
            addMarker(temp[0]);
            poder = false;
          }else{
            alert("ponto já adicionado!");
          }
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

          if (feature.draggable == true) {

            document.getElementById('lat').value = marker.position.lat();
            document.getElementById('long').value = marker.position.lng();

            google.maps.event.addListener(marker,'dragend', function() {
                document.getElementById('lat').value = marker.position.lat();
                document.getElementById('long').value = marker.position.lng();
            });
          }

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

          var contentString1 = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading">NOME DO PONTO '+2+'</h1>'+
            '<div id="bodyContent" class="col-sm-12">'+
            '<p class="col-sm-6"> OLHA O CONTEÚDO DO PONTO MAHOE</p>'+
            '<p class="col-sm-6"> OEIOEIOEIOEOEIOEIEOIEOEI </p><p><a href="index.php"><button class="btn btn-primary">SUCÉSSO!</button></a></p>'+
            '</div>'+
            '</div>';

        //uso de ícone personalizado e conteúdo de cada marker
        var features = [

         /* <?php
                $pontos = mysql_query("SELECT * FROM pontos order by id");
                $lin = mysql_num_rows($pontos);

                for ($i=0; $i <$lin ; $i++)
                {
                  $reg=mysql_fetch_row($pontos);
                  ?>
                  {
                    position: new google.maps.LatLng(<?php echo "$reg[2],$reg[3]" ?>),
                    type: 'mark1',
                    info:'<div id="content">'+
                          '<div id="siteNotice">'+
                          '</div>'+
                          '<h1 id="firstHeading" class="firstHeading"><?php echo utf8_encode($reg[1]); ?></h1>'+
                          '<div id="bodyContent" class="col-sm-12">'+
                          '<p class="col-sm-6"> <?php echo utf8_encode($reg[1]); ?></p>'+
                          '<p class="col-sm-6"> <?php echo utf8_encode($reg[4]); ?> </p>'+
                          '<form action="#" method="post">'+
                          '<p>'+
                          '<button class="btn btn-primary" type="submit">SUCESSO!</button>'+
                          ''+
                          '</p></form>'+
                          '</div>'+
                          '</div>',
                    draggable:false
                  }
                  <?php
                  if ($i!=$lin-1) {
                    echo ",";
                  }
                }
          ?>*/
        ];

        //cria as variáveis chamando as funções
        for (var i = 0, feature; feature = features[i]; i++) {
          addMarker(feature);
        }

        //cluster de marcadores
        var options = {
                  imagePath: 'images/m'
        };

       // var markerCluster = new MarkerClusterer(map, markers, options); // cria cluster
      }

      function submeter()
      {
        var geocoder = new google.maps.Geocoder;
        var lati = document.getElementById('lat').value;
        var long = document.getElementById('long').value;
        var latlng = {lat: parseFloat(lati), lng: parseFloat(long)};

        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === google.maps.GeocoderStatus.OK) {
            if (results[1]) {
              alert(results[1].formatted_address);
              var address = "", city = "", state = "", zip = "", country = "", formattedAddress = "";
              for (var i = 0; i < results[0].address_components.length; i++) {
                          var addr = results[0].address_components[i];
                          // check if this entry in address_components has a type of country
                          if (addr.types[0] == 'country')
                              country = addr.long_name;
                          else if (addr.types[0] == 'street_address') // address 1
                              address = address + addr.long_name;
                          else if (addr.types[0] == 'establishment')
                              address = address + addr.long_name;
                          else if (addr.types[0] == 'route')  // address 2
                              address = address + addr.long_name;
                          else if (addr.types[0] == 'postal_code')       // Zip
                              zip = addr.short_name;
                          else if (addr.types[0] == ['administrative_area_level_1'])       // State
                              state = addr.long_name;
                          else if (addr.types[0] == ['locality'])       // City
                              city = addr.long_name;
              }
              alert(country);
              alert(address);
              alert(zip);
              alert(state);
              alert(city);
              document.getElementById('estado').value = state;
              document.getElementById('endereco').value = address;
              document.getElementById('cep').value = zip;
              document.getElementById('pais').value = country;
              document.getElementById('cidade').value = city;
            } else {
             //window.alert('No results found');
            }
          } else {
            //window.alert('Geocoder failed due to: ' + status);
          }
        });
       //document.getElementById("submete").submit();
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmWPAIE9_AASg6Ijgoh0lVOZZ_VWvw6fg&libraries=places&callback=initAutocomplete" async defer></script>

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