

	<!-- General Style -->
	<link href="style1.css" rel="stylesheet">
	
	<!-- Animations -->
	<link href="css/animate.css" rel="stylesheet">
		
	<!-- Device Styles -->
	<link rel="stylesheet" type="text/css" href="css/devices/style.css">
	<script src="https://use.fontawesome.com/9c8fd2c64e.js"></script>
	
	<!--Fonts-->
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,200,100,500,600,700,800,900' rel='stylesheet' type='text/css'>
	<link href="css/fonts/font-awesome.css" rel="stylesheet">

	<style>
	.mobile{
		background-color:#606060;
		}
	</style>
<?php require_once("../conectar_service.php"); ?>
<header class="mobile">
  <div class="row">
    <div class="col full">
      <div style="margin-left:30px;"><a href="index.php" class="logo" style="color:white;"><img src="images/logo2.png" height="43px" width="120px" style="margin-top:-5px"></a></div>
      <nav id="nav-wrap" style="left: 10%;">
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
		  <li style="margin-left:150px;margin-right:20px;">
				<a href="notificacoes.php">
					<?php
	                    $json_dados = $service->call('notificacao.select_nao_visualizados_by_empresa',array($_SESSION["id"]));
	                    $notificacao = json_decode($json_dados);
	                    if (count($notificacao) > 0) 
	                        echo '<span class="badge bg-theme pull-right">'.count($notificacao).'</span>';
	                ?>
					<img src="images/icones/icone-03.png" style="margin-bottom:5px;height:17px;width:25px;">
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
						<a class="logout" href="../index/logout.php" style="color: darkgray;">Logout</a>
					</li>
					<li style="width: 100%;"><center><a href="../../fr/empresa/"><img src="images/bndfr.png" width="20px;"></a></center></li>
				</ul>
			</li>

        </ul>
      </nav>
    </div>
  </div>
</header>