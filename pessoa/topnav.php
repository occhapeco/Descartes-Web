 <header class="header black-bg">
            <!--logo start-->
            <a href="index.php" class="logo"><b>DescartesLab</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
  				<a href="index.php" style="font-size:17px; color:#797979; margin-left:200px; text-decoration:underline;">Mapa</a>
                <a href="enderecos.php" style="font-size:17px; color:#797979; margin-left:50px; text-decoration:underline;">Endereços</a>
                <a href="pedidos.php" style="font-size:17px; color:#797979; margin-left:50px; text-decoration:underline;">Agendamentos</a>
            </div>
            
            <div class="top-menu">
            	<ul class="nav top-menu pull-right">
                    <li id="header_inbox_bar" class="dropdown pull-left" style="margin-top:15px; margin-right:30px;">
                        <?php
                                require_once("../conectar_service.php");

                                $json_dados = $service->call('notificacao.select_by_usuario',array($_SESSION["id"]));
                                $notificacao = json_decode($json_dados);
                                $num = count($notificacao);
                                $n = $num;
                                if ($num > 0) 
                                    echo '<span class="badge bg-theme pull-right">'.$num.'</span>';
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

                    <li id="header_inbox_bar" class="dropdown" style="margin-top:15px;">
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
            </div>
        </header>