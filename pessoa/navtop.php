<!-- Bootstrap -->
<link href="assets/css/bootstrap.css" rel="stylesheet">

<!-- General Style -->
<link href="style1.css" rel="stylesheet">

<script src="https://use.fontawesome.com/9c8fd2c64e.js"></script>
<style>
.mobile{
	background-color:#606060;
	}
</style>
<?php require_once("../conectar_service.php"); ?>
<header class="mobile">
  <div class="row">
    <div class="col full">
      <div style="margin-left:10px;"><a href="index.php" class="logo" style="color:white;"><b>DescartesLab</b></a></div>
      <nav id="nav-wrap" style="left: 25%;">
        <a class="mobile-btn" href="#nav-wrap" title="Show navigation">
        	<i class="fa fa-bars" style="color:white; margin-top:2px;margin-left:8px;font-size:36px;"></i>
        </a> 
        <a class="mobile-btn" href="#nvv" title="Hide navigation">
        	<i class="fa fa-bars" style="color:white; margin-top:2px;margin-left:8px;font-size:36px;"></i>
        </a>
        <ul id="nav" class="nav" >
            <li><a href="index.php">Mapa</a></li>
            <li><a href="enderecos.php">Endereços</a></li>
            <li><a href="pedidos.php">Agendamentos</a></li>
            <li style="" class="logina">
                <a href="notificacoes.php">
                    <?php
                        $json_dados = $service->call('notificacao.select_nao_visualizados_by_usuario',array($_SESSION["id"]));
                        $notificacao = json_decode($json_dados);
                        if (count($notificacao) > 0) 
                            echo '<span class="badge bg-theme pull-right">'.count($notificacao).'</span>';
                    ?>
                    <i class="fa fa-envelope-o hidden-xm" style="margin-bottom:5px;"></i>
                </a>
            </li>
					
			<li id="header_inbox_bar" class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                   <?php
                   		$json_dados = $service->call('usuario.select',array('id = '.$_SESSION["id"]));
                        $usuario = json_decode($json_dados);
                        echo  $usuario[0]->nome;
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