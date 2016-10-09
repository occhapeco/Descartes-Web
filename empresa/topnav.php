      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->

      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips"></div>
              </div>
            <!--logo start-->
            <a href="index.php" class="logo"><b>DescartesLab</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">
                    <!-- inbox dropdown start-->
                    <li id="header_inbox_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-envelope-o"></i>
                            <?php
                                require_once("../conectar_service.php");

                                $json_dados = $service->call('notificacao.select_by_empresa',array($_SESSION["id"]));
                                $notificacao = json_decode($json_dados);
                                $num = count($notificacao);
                                $n = $num;
                                if ($num > 0) 
                                    echo '<span class="badge bg-theme">'.$num.'</span>';
                                if($num > 4)
                                    $num = 4;
                            ?>
                        </a>
                        <ul class="dropdown-menu extended inbox" id="notification_bar">
                            <div class="notify-arrow notify-arrow-green"></div>
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
                                    $json_dados = $service->call('usuario.select',array('id = '.$notificacao[$i]->usuario_id));
                                    $usuario = json_decode($json_dados);
                                    /*if ($notificacao[$i]->tipo == 0) // Agendamentos pendentes
                                        echo '<li>
                                                <a href="index.php">
                                                    <span class="subject">
                                                    <span class="from">Zac Snider</span>
                                                    <span class="time">Just now</span>
                                                    </span>
                                                    <span class="message">
                                                        Você possui um novo agendamento pendente!
                                                    </span>
                                                </a>
                                            </li>';
                                    if ($notificacao->tipo == 1) // Agendamentos em espera
                                        echo '<li>
                                                <a href="agendamentos_aceitos.php">
                                                    <span class="subject">
                                                    <span class="from">Zac Snider</span>
                                                    <span class="time">Just now</span>
                                                    </span>
                                                    <span class="message">
                                                        Você possui n agendamentos aprovados!
                                                    </span>
                                                </a>
                                            </li>';*/
                                   if ($notificacao[$i]->tipo == 2) // Novo agendamento
                                        echo "<li>
                                                <form id='form_noti_".$notificacao[$i]->id."' method='POST' action='tratar_notificacoes.php'>
                                                    <input type='hidden' id='id' name='id' value=".$notificacao[$i]->id.">
                                                    <input type='hidden' id='pg' name='pg' value='index.php'>
                                                    <a onclick='document.getElementById(`form_noti_".$notificacao[$i]->id."`).submit();' href='#'>
                                                        <span class='subject'>
                                                        <span class='from'>".$usuario[0]->nome."</span>
                                                        </span>
                                                        <span class='message'>Um agendamento foi solicitado!</span>
                                                    </a>
                                                </form>
                                            </li>";
                                    if ($notificacao[$i]->tipo == 3){ // Agendamento cancelado
                                        echo "<li>
                                                <form id='form_noti_".$notificacao[$i]->id."' method='POST' action='tratar_notificacoes.php'>
                                                    <input type='hidden' id='id' name='id' value=".$notificacao[$i]->id.">
                                                    <input type='hidden' id='pg' name='pg' value='agendamento_aceitos.php'>
                                                    <a onclick='document.getElementById(`form_noti_".$notificacao[$i]->id."`).submit();' href='#'>
                                                        <span class='subject'>
                                                        <span class='from'>".$usuario[0]->nome."</span>
                                                        </span>
                                                        <span class='message'>Um agendamento foi cancelado!</span>
                                                    </a>
                                                </form>
                                            </li>";
                                    }

                                    /*if ($notificacao->tipo == 4) // Agendamentos cancelados
                                        echo '<li>
                                                    <span class="photo"><img alt="avatar" src="assets/img/ui-zac.jpg"></span>
                                                    <span class="subject">
                                                    <span class="from">Zac Snider</span>
                                                    <span class="time">Just now</span>
                                                    </span>
                                                    <span class="message">
                                                        O !
                                                    </span>
                                            </li>';*/
                                }
                            ?>
                        </ul>
                    </li>
                    <!-- inbox dropdown end -->
                </ul>
                <!--  notification end -->
            </div>
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="../inicio/logout.php">Logout</a></li>
            	</ul>
            </div>
        </header>
      <!--header end-->
      <script type="application/javascript">
        
        $("#notification_bar").click(function(){
            $(".offset1").toggle(1000);
        });

    </script>