<?php require_once("permissao.php"); ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Descartes</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css--> 
    
    <script src="https://use.fontawesome.com/9c8fd2c64e.js"></script>

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/table-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>

  </head>

  <body>

  <section id="container" >
      
      <?php
          require_once("navtop.php");
      ?>    
  
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT  TABELA RESPONSIVA
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
        <section class="wrapper">
          <h3><i class="fa fa-angle-right"></i> Schedules</h3>
          <div class="row mt">
            <div class="col-lg-12">
              <div class="content-panel">
                <ul class="nav nav-tabs" style="margin-left: 20px;">
                  <li class="active"><a data-toggle="pill" href="#home" style="color: black;"><span class="fa fa-plus-circle"></span> New</a></li>
                  <li><a data-toggle="pill" href="#menu1" style="color: black;"><span class="fa fa-hourglass-start"></span> Pending</a></li>
                  <li><a data-toggle="pill" href="#menu2" style="color: black;"><span class="fa fa-hourglass-end"></span> Late</a></li>
                  <li><a data-toggle="pill" href="#menu3" style="color: black;"><span class="fa fa-calendar-check-o"></span> Accomplished</a></li>
                  <li><a data-toggle="pill" href="#menu4" style="color: black;"><span class="fa fa-calendar-times-o"></span> Canceled</a></li>
                </ul>
                  
                <div class="tab-content">
                  <div id="home" class="tab-pane fade in active">
                    <?php                            
                      $json_dados = $service->call('agendamento.select_sem_resposta_by_empresa',array($_SESSION["id"]));
                      $agendamento = json_decode($json_dados);
                      $num = count($agendamento);
                      if ($num > 0)
                      {
                    ?>
                    <section id="no-more-tables">
                       <form action="imprimir_agendamentos.php" method="post">
                          <input type="hidden" value="em_espera" id="em_espera" name="em_espera">
                          <button class="btn btn-theme03 pull-right" style="margin-right:30px;"><i class="fa fa-print"></i></button>
                       </form>
                      <table class="table table-striped table-condensed cf ">
                        <thead class="cf">
                        <tr>
                            <th class="date">Date</th>
                            <th class="time">Schedule</th>  
                            <th>Address</th>
                            <th>Requester</th>
                            <th>Phone</th>
                            <th>E-mail</th>
                            <th><center>Accept</center></th>
                            <th><center>Refuse</center></th>
                        </tr>
                        </thead>
                        <tbody>
                    <?php
                        for ($i=0;$i<$num;$i++)
                        {
                          // Dados do endereço
                          $json_dados = $service->call('endereco.select_by_id',array($agendamento[$i]->endereco_id));
                          $endereco = json_decode($json_dados);
                          // Dados do usuário
                          $json_dados = $service->call('usuario.select',array("id = ".$agendamento[$i]->usuario_id));
                          $usuario = json_decode($json_dados);
						  $data_agendamento = DateTime::createFromFormat('Y-m-d',$agendamento[$i]->data_agendamento);
						  $format = $data_agendamento->format('d/m/Y');
                          echo "<tr class='info'>
                                  <td data-title='Data'>" . $format . "</td>
                                  <td data-title='Horário'>" . $agendamento[$i]->horario . "</td>
                                  <td data-title='Endereço'>" . $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais . "</td>
                                  <td data-title='Solicitante'>" . $usuario[0]->nome . "</td>
                                  <td data-title='Telefone'>" . $usuario[0]->telefone . "</td>
                                  <td data-title='E-mail'>" . $usuario[0]->email . "</td>                    
                                  <td data-title='Aceitar'><form method='POST' action='tratar_agendamento.php'><input type='hidden' id='id' name='id' value=" . $agendamento[$i]->id . "><input type='hidden' id='aceitar' name='aceitar'><center><button type='submit' class='btn btn-theme'><i class='fa fa-check'></i></button></center></form></td>
                                  <td data-title='Recusar'><form method='POST' action='tratar_agendamento.php'><input type='hidden' id='id' name='id' value=" . $agendamento[$i]->id . "><center><button type='submit' id='recusar' name='recusar' class='btn btn-danger'><i class='fa fa-times'></i></button></center></form></td>
                                </tr>";
                        }
                    ?>
                          </tr>
                        </tbody>
                      </table>
                    </section>
                    <?php
                      }
                      else
                        echo "<center><h4>Nenhum agendamento em espera.</h4></center><br>";
                    ?>
                  </div>
                  <div id="menu1" class="tab-pane fade">
                    <?php                            

                    $json_dados = $service->call('agendamento.select_aceitos_by_empresa',array($_SESSION["id"]));
                    $agendamento = json_decode($json_dados);
                    $num = count($agendamento);
                    if ($num > 0)
                    {
                ?>
                <section id="no-more-tables">
                   <form action="imprimir_agendamentos.php" method="post">
                        <input type="hidden" value="aceito" id="aceito" name="aceito">
                        <button class="btn btn-theme03 pull-right" style="margin-right:30px;"><i class="fa fa-print"></i></button>
                   </form>
                  <table class="table table-striped table-condensed cf ">
                      <thead class="cf">
                      <tr>
                          <th class="date">Date</th>
                          <th class="time">Schedule</th>  
                          <th>Address</th>  
                          <th>Requester</th>
                          <th>Phone</th>  
                          <th>E-mail</th>
                          <th><center>Refuse</center></th>
                      </tr>
                      </thead>
                      <tbody>
                <?php
                    for($i=0;$i<$num;$i++)
                    {
                      $json_dados = $service->call('endereco.select_by_id',array($agendamento[$i]->endereco_id));
                      $endereco = json_decode($json_dados);
                      $json_dados = $service->call('usuario.select',array("id = ".$agendamento[$i]->usuario_id));
                      $usuario = json_decode($json_dados);
					  $data_agendamento = DateTime::createFromFormat('Y-m-d',$agendamento[$i]->data_agendamento);
					  $format = $data_agendamento->format('d/m/Y');
                      echo '<tr class="warning">
                              <td data-title="Data">' . $format . '</td>
                              <td data-title="Horário">' . $agendamento[$i]->horario . '</td>
                              <td data-title="Endereço">' . $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais . '</td>
                              <td data-title="Solicitante">' . $usuario[0]->nome . '</td>
                              <td data-title="Telefone">' . $usuario[0]->telefone . '</td>
                              <td data-title="E-mail">' . $usuario[0]->email . '</td>
                              <td data-title="Cancelar"><form method="POST" action="tratar_agendamento.php"><input type="hidden" id="id" name="id" value=' . $agendamento[$i]->id . '><input type="hidden" id="cancelar" name="cancelar"><center><button type="submit" class="btn btn-danger"><i class="fa fa-times"></i></button></center></form></td>
                            </tr>';
                    }
                  ?>
                      </tbody>
                    </table>
                  </section>
                  <?php
                    }
                    else
                      echo "<center><h4>Nenhum agendamento aceito.</h4></center><br>";
                  ?>
                  </div>
                  <div id="menu2" class="tab-pane fade">
                    <?php                            
                      $json_dados = $service->call('agendamento.select_atrasados_by_empresa',array($_SESSION["id"]));
                      $agendamento = json_decode($json_dados);
                      $num = count($agendamento);
                      if ($num > 0)
                      {
                  ?>
                  <section id="no-more-tables">
                      <form action="imprimir_agendamentos.php" method="post">
                        <input type="hidden" value="atrasado" id="atrasado" name="atrasado">
                          <button class="btn btn-theme03 pull-right" style="margin-right:30px;"><i class="fa fa-print"></i></button>
                      </form>
                    <table class="table table-striped table-condensed cf">
                        <thead class="cf">
                          <tr>
                            <th class="date">Date</th>
                            <th class="time">Schedule</th>  
                            <th>Address</th>
                            <th>Requester</th>
                            <th>Phone</th>
                            <th>E-mail</th>
                            <th>Refuse</th>
                          </tr>
                        </thead>
                        <tbody>
                    <?php
                        for($i=0;$i<$num;$i++)
                        {
                          $json_dados = $service->call('endereco.select_by_id',array($agendamento[$i]->endereco_id));
                          $endereco = json_decode($json_dados);
                          $json_dados = $service->call('usuario.select',array("id = ".$agendamento[$i]->usuario_id));
                          $usuario = json_decode($json_dados);
						  $data_agendamento = DateTime::createFromFormat('Y-m-d',$agendamento[$i]->data_agendamento);
						  $format = $data_agendamento->format('d/m/Y');
                          echo '<tr class="warning">
                                  <td data-title="Data">' . $format . '</td>
                                  <td data-title="Horário">' . $agendamento[$i]->horario . '</td>
                                  <td data-title="Endereço">' . $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais . '</td>
                                  <td data-title="Solicitante">' . $usuario[0]->nome . '</td>
                                  <td data-title="Telefone">' . $usuario[0]->telefone . '</td>
                                  <td data-title="E-mail">' . $usuario[0]->email . '</td>
                                  <td data-title="Recusar"><form method="POST" action="tratar_agendamento.php"><input type="hidden" id="id" name="id" value=' . $agendamento[$i]->id . '><input type="hidden" id="cancelar" name="cancelar"><center><button type="submit" class="btn btn-danger"><i class="fa fa-times"></i></button></center></form></td>
                                </tr>';
                        }
                    ?>
                        </tbody>
                      </table>
                    </section>
                    <?php
                      }
                      else
                        echo "<center><h4>Nenhhum agendamento atrasado. :)</h4></center><br>";
                    ?>
                  </div>
                  <div id="menu3" class="tab-pane fade">
                <?php                            
                  $json_dados = $service->call('agendamento.select_realizados_by_empresa',array($_SESSION["id"]));
                  $agendamento = json_decode($json_dados);
                  $num = count($agendamento);
                  if ($num > 0)
                  {
                ?>
                
                <section id="no-more-tables">
                   <form action="imprimir_agendamentos.php" method="post">
                        <input type="hidden" value="realizado" id="realizado" name="realizado">
                        <button class="btn btn-theme03 pull-right" style="margin-right:30px;"><i class="fa fa-print"></i></button>
                   </form>
                   <table class="table table-striped table-condensed cf ">
                      <thead class="cf">
                         <tr>
                            <th class="date">Date</th>
                            <th class="time">Schedule</th>  
                            <th>Address</th>
                            <th>Requester</th>
                            <th>Phone</th>
                            <th>E-mail</th>
                         </tr>
                        </thead>
                         <tbody>
                <?php
                    for($i=0;$i<$num;$i++)
                    {
                      $json_dados = $service->call('endereco.select_by_id',array($agendamento[$i]->endereco_id));
                      $endereco = json_decode($json_dados);
                      $json_dados = $service->call('usuario.select',array("id = ".$agendamento[$i]->usuario_id));
                      $usuario = json_decode($json_dados);
					  $data_agendamento = DateTime::createFromFormat('Y-m-d',$agendamento[$i]->data_agendamento);
					  $format = $data_agendamento->format('d/m/Y');
                      echo '<tr class="success">
                              <td data-title="Data">' . $format . '</td>
                              <td data-title="Horário">' . $agendamento[$i]->horario . '</td>
                              <td data-title="Endereço">' . $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais . '</td>
                              <td data-title="Solicitante">' . $usuario[0]->nome . '</td>
                              <td data-title="Telefone">' . $usuario[0]->telefone . '</td>
                              <td data-title="E-mail">' . $usuario[0]->email . '</td>
                            </tr>';
                    }
                ?>
                    </tbody>
                  </table>
                </section>
                <?php
                  }
                  else
                    echo "<center><h4>Nenhum agendamento realizado.</h4></center><br>";
                ?>
                  </div>
                  <div id="menu4" class="tab-pane fade">
                    <?php                            
                  $json_dados = $service->call('agendamento.select_cancelados_by_empresa',array($_SESSION["id"]));
                  $agendamento = json_decode($json_dados);
                  $num = count($agendamento);
                  if ($num > 0)
                  {
                ?>
                
                <section id="no-more-tables">
                   <form action="imprimir_agendamentos.php" method="post">
                        <input type="hidden" value="cancelado" id="cancelado" name="cancelado">
                        <button class="btn btn-theme03 pull-right" style="margin-right:30px;"><i class="fa fa-print"></i></button>
                   </form>
                   <table class="table table-striped table-condensed cf ">
                      <thead class="cf">
                         <tr>
                            <th class="date">Date</th>
                            <th class="time">Schedule</th>  
                            <th>Address</th>
                            <th>Requester</th>
                            <th>Phone</th>
                            <th>E-mail</th>
                         </tr>
                        </thead>
                         <tbody>
                <?php
                    for($i=0;$i<$num;$i++)
                    {
                      $json_dados = $service->call('endereco.select_by_id',array($agendamento[$i]->endereco_id));
                      $endereco = json_decode($json_dados);
                      $json_dados = $service->call('usuario.select',array("id = ".$agendamento[$i]->usuario_id));
                      $usuario = json_decode($json_dados);
					  $data_agendamento = DateTime::createFromFormat('Y-m-d',$agendamento[$i]->data_agendamento);
                      $format = $data_agendamento->format('d/m/Y');
                      echo '<tr class="danger">
                              <td data-title="Data">' . $format . '</td>
                              <td data-title="Horário">' . $agendamento[$i]->horario . '</td>
                              <td data-title="Endereço">' . $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais . '</td>
                              <td data-title="Solicitante">' . $usuario[0]->nome . '</td>
                              <td data-title="Telefone">' . $usuario[0]->telefone . '</td>
                              <td data-title="E-mail">' . $usuario[0]->email . '</td>
                            </tr>';
                    }
                ?>
                    </tbody>
                  </table>
                </section>
                <?php
                  }
                  else
                    echo "<center><h4>Nenhhum agendamento cancelado.</h4></center><br>";
                ?>
                  </div>
                </div>
              </div>
                  
									      
              </div>
            </div>
          </div>
        </section>
      </section>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
  

  </body>
</html>
