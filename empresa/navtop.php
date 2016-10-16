<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Infinity - Mobile App HTML5 Template">
	<meta name="keywords" content="keywords">
	<meta name="author" content="Audain Designs">

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- General Style -->
	<link href="style1.css" rel="stylesheet">
	
	<!--Custom CSS-->
	<link href="custom.css" rel="stylesheet">

	<!-- Animations -->
	<link href="css/animate.css" rel="stylesheet">
		
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
.mobile{
	background-color:#606060;
	}
</style>
<?php require_once("../conectar_service.php"); ?>
<header class="mobile">
  <div class="row">
    <div class="col full">
      <div style="margin-left:30px;"><a href="index.php" class="logo" style="color:white;"><b>DescartesLab</b></a></div>
      <nav id="nav-wrap" style="left: 25%;">
        <a class="mobile-btn" href="#nav-wrap" title="Show navigation">
        	<i class="fa fa-bars" style="color:white; margin-top:2px;margin-left:8px;font-size:36px;"></i>
        </a> 
        <a class="mobile-btn" href="#nvv" title="Hide navigation">
        	<i class="fa fa-bars" style="color:white; margin-top:2px;margin-left:8px;font-size:36px;"></i>
        </a>
        <ul id="nav" class="nav" >
          <li><a href="index.php">Estatísticas</a></li>
          <li><a href="meus_pontos.php">Meus pontos</a></li>
          <li><a href="mapa_coletas.php">Coletas</a></li>
          <li><a href="agendamentos.php">Agendamentos</a></li>
		  <li style="margin-left:250px;margin-right:20px;">
				<a href="notificacoes.php">
					<?php
	                    $json_dados = $service->call('notificacao.select_nao_visualizados_by_empresa',array($_SESSION["id"]));
	                    $notificacao = json_decode($json_dados);
	                    if (count($notificacao) > 0) 
	                        echo '<span class="badge bg-theme pull-right">'.count($notificacao).'</span>';
	                ?>
					<i class="fa fa-envelope-o" style="margin-bottom:5px;"></i>
				</a>
			</li>
			<li id="header_inbox_bar" class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#">
				   <?php
						$json_dados = $service->call('empresa.select_by_id',array($_SESSION["id"]));
						$empresa = json_decode($json_dados);
						echo  $empresa[0]->nome_fantasia;
					?>
					<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu dropdown-menu-right" id="notification_bar">
					<li style="width: 100%;">
						<a href="editar_perfil.php" style="color: darkgray;">Editar Perfil</a>
					</li>
					<li style="width: 100%;">
						<a class="logout" href="../inicio/logout.php" style="color: darkgray;">Logout</a>
					</li>
				</ul>
			</li>

        </ul>
      </nav>
    </div>
  </div>
</header>