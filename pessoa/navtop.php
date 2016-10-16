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
<header class="mobile">
  <div class="row">
    <div class="col full">
      <div> <a href="index.php" class="logo"><b>DescartesLab</b></a> </div>
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
		  <li id="header_inbox_bar" class="dropdown" style="margin-left:300px; margin-right:50px;">
                        <?php
                                require_once("../conectar_service.php");

                                $json_dados = $service->call('notificacao.select_by_usuario',array($_SESSION["id"]));
                                $notificacao = json_decode($json_dados);
                                $num = count($notificacao);
                                $n = $num;
                                if ($num > 0) 
                                    echo '<span class="badge bg-theme pull-right" style="margin-top:8px;margin-bottom:-40px;">'.$num.'</span>';
                                if($num > 4)
                                    $num = 4;
                            ?>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-envelope-o"></i>
                        </a>
                        
                        <ul class="dropdown-menu extended inbox dropdown-menu-right" id="notification_bar">
                            <li>
	                            <?php
	                                $header = '<p class="green">Você não possui notificações</p>';
	                                if ($num > 0)
	                                    $header = '<button class="btn btn-theme" onclick="window.location.href = `notificacoes.php`;" style="width: 100%">Ver todas as '.$n.' notificações</button>';
	                                echo $header;
	                            ?>
                            </li>
                            <?php
                                for($i=0;$i<$num;$i++)
                                {
                                    $json_dados = $service->call('empresa.select_by_id',array($notificacao[$i]->empresa_id));
                                    $empresa = json_decode($json_dados);
                                   if ($notificacao[$i]->tipo == 2) // Novo agendamento
                                        echo "<li>
                                                <form id='form_noti_".$notificacao[$i]->id."' method='POST' action='tratar_notificacoes.php'>
                                                    <input type='hidden' id='id' name='id' value=".$notificacao[$i]->id.">
                                                    <input type='hidden' id='pg' name='pg' value='index.php'>
                                                    <a onclick='document.getElementById(`form_noti_".$notificacao[$i]->id."`).submit();' href='#'>
                                                        <span class='subject'>
                                                        <span class='from'>".$empresa[0]->nome_fantasia."</span>
                                                        </span>
                                                        <span class='message'>Um agendamento foi solicitado!</span>
                                                    </a>
                                                </form>
                                            </li>";
                                    else{ // Agendamento cancelado
                                        echo "<li>
                                                <form id='form_noti_".$notificacao[$i]->id."' method='POST' action='tratar_notificacoes.php'>
                                                    <input type='hidden' id='id' name='id' value=".$notificacao[$i]->id.">
                                                    <input type='hidden' id='pg' name='pg' value='agendamento_aceitos.php'>
                                                    <a onclick='document.getElementById(`form_noti_".$notificacao[$i]->id."`).submit();' href='#'>
                                                        <span class='subject'>
                                                        <span class='from'>".$empresa[0]->nome_fantasia."</span>
                                                        </span>
                                                        <span class='message'>Um agendamento foi cancelado!</span>
                                                    </a>
                                                </form>
                                            </li>";
                                    }
                                }
                            ?>
                        </ul>
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
                            <li>
                            	<a href="editarperfil.php">Editar Perfil</a>
                            </li>
                            <li>
                            	<a class="logout" href="../inicio/logout.php">Logout</a>
                            </li>
                        </ul>
                    </li>

        </ul>
      </nav>
    </div>
  </div>
</header>