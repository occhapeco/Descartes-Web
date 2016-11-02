<link rel="stylesheet" type="text/css" href="style1.css">
<style>
.mobile{
	background-color:#606060;
	}
</style>
<?php require_once("../conectar_service.php"); ?>
<header class="mobile">
  <div class="row">
    <div class="col full">
      <div><a href="index.php" class="logo" style="color:white;"><img src="images/logo2.png" height="50px" width="130px" style="margin-top:-6px"></a></div>
      <nav id="nav-wrap" style="left: 25%;">
        <a class="mobile-btn" href="#nav-wrap" title="Show navigation">
        	<i class="fa fa-bars" style="color:white; margin-top:2px;margin-left:8px;font-size:36px;"></i>
        </a> 
        <a class="mobile-btn" href="#nvv" title="Hide navigation">
        	<i class="fa fa-bars" style="color:white; margin-top:2px;margin-left:8px;font-size:36px;"></i>
        </a>
        <ul id="nav" class="nav" >
            <li><a href="index.php">Map</a></li>
            <li><a href="enderecos.php">Addresses</a></li>
            <li><a href="pedidos.php">Schedulings</a></li>
            <li style="" class="logina">
                <a href="notificacoes.php">
                    <?php
                        $json_dados = $service->call('notificacao.select_nao_visualizados_by_usuario',array($_SESSION["id"]));
                        $notificacao = json_decode($json_dados);
                        if (count($notificacao) > 0) 
                            echo '<span class="badge bg-theme pull-right" style="margin-top:5px;margin-left:-4px;">'.count($notificacao).'</span>';
                    ?>
                    <img src="images/icones/icone-03.png" style="margin-bottom:5px;height:17px;width:25px;">
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
                        <a href="editar_perfil.php" style="color: darkgray;">Edit Profile</a>
                    </li>
                    <li style="width: 100%;">
                        <a class="logout" href="../index/logout.php" style="color: darkgray;">Logout</a>
                    </li>
                </ul>
            </li>

        </ul>
      </nav>
    </div>
  </div>
</header>