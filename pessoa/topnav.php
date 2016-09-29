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
                        <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                            <i class="fa fa-envelope-o"></i>
                            <?php
                                require_once("../conectar_service.php");

                                $json_dados = $service->call('notificacao.select_by_usuario',array($_SESSION["id"]));
                                $notificacao = json_decode($json_dados);
                                $num = count($notificacao);
                                if ($num > 0) 
                                    echo '<span class="badge bg-theme">$num</span>'
                            ?>
                        </a>
                        <ul class="dropdown-menu extended inbox" id="notification_bar">
                            <div class="notify-arrow notify-arrow-green"></div>
                            <li>
                            <?php
                                $header = "Você não possui notificações.";
                                if ($num > 0)
                                    $header = "Você possui " . $num . " notificações.";
                                echo '<p class="green">' . $header . '</p>';
                            ?>
                            </li>
                            <?php
                                for($i=0;$i<$num;$i++)
                                {
                                        $empresa = $service->call('empresa.select',' id = '.$notificacao[$i]->empresa_id);
                                        $empresa_nome = json_decode($empresa);
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
                                   if ($notificacao[$i]->tipo == 0) // Agendamentos aceitos
                                        echo '<li>
                                                <a href="index.php">
                                                    <span class="photo"><img alt="avatar" src="assets/img/ui-zac.jpg"></span>
                                                    <span class="subject">
                                                    <span class="from">'.$empresa_nome[0]->nome_fantasia.'</span>
                                                    <span class="time">Recentemente</span>
                                                    </span>
                                                    <span class="message">
                                                        A empresa '.$empresa_nome[0]->nome_fantasia.' aceitou o agendamento!
                                                    </span>
                                                </a>
                                            </li>';
                                    if ($notificacao[$i]->tipo == 1) // Agendamentos recusados
                                        echo '<li>
                                                <a href="index.php">
                                                    <span class="photo"><img alt="avatar" src="assets/img/ui-zac.jpg"></span>
                                                    <span class="subject">
                                                    <span class="from">'.$empresa_nome[0]->nome_fantasia.'</span>
                                                    <span class="time">Recentemente</span>
                                                    </span>
                                                    <span class="message">
                                                        A empresa '.$empresa_nome[0]->nome_fantasia.' recusou o agendamento!
                                                    </span>
                                                </a>
                                            </li>';

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