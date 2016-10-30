<?php require_once("permissao.php"); 
  require_once("../conectar_service.php"); 
$active='home';

if (isset($_POST["aceitar"]))
  {
    $bool = $service->call('agendamento.aceitar',array($_POST["aceitar"]));
    $active='menu1';
  }
  
if (isset($_POST["recusar"]))
  {
    $bool = $service->call('agendamento.recusar',array($_POST["recusar"]));
  }
  
if (isset($_POST["cancelar"]))
  {
    $bool = $service->call('agendamento.cancelar',array($_POST["cancelar"]));
    $active="menu4";
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>DescartesLab</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css--> 
    
    <script src="https://use.fontawesome.com/9c8fd2c64e.js"></script>

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/table-responsive.css" rel="stylesheet">

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
          <h3><i class="fa fa-angle-right"></i> Agendamentos</h3>
          <div class="row mt">
            <div class="col-lg-12">
              <div class="content-panel">
                <ul class="nav nav-tabs" style="margin-left: 20px;">
                  <li class="<?php if($active == "home") echo ' active';?>"><a data-toggle="pill" href="#home" style="color: #797979;"><img src="images/agenda5.png" height="15px" width="15px"> Novo</a></li>
                  <li <?php if($active == "menu1") echo ' class="active"'; ?>><a data-toggle="pill" href="#menu1" style="color: #797979;"><img src="images/agenda1.png" height="15px" width="15px"> Pendentes</a></li>
                  <li <?php if($active == "menu2") echo ' class="active"'; ?>><a data-toggle="pill" href="#menu2" style="color: #797979"><img src="images/agenda3.png" height="15px" width="15px"> Atrasados</a></li>
                  <li <?php if($active == "menu3") echo ' class="active"'; ?>><a data-toggle="pill" href="#menu3" style="color: #797979;"><img src="images/agenda2.png" height="15px" width="15px"> Concluídos</a></li>
                  <li <?php if($active == "menu4") echo ' class="active"'; ?>><a data-toggle="pill" href="#menu4" style="color: #797979;"><img src="images/agenda4.png" height="15px" width="15px"> Cancelados</a></li>
                </ul>
                  
                <div class="tab-content">
                  <div id="home" class="tab-pane fade <?php if($active == "home") echo 'in active'; ?>">
                    <?php                            
                      $json_dados = $service->call('agendamento.select_sem_resposta_by_empresa',array($_SESSION["id"]));
                      $agendamento = json_decode($json_dados);
                      $num = count($agendamento);
                      if ($num > 0)
                      {
                    ?>
                    <section id="no-more-tables" style="margin-right:10px;margin-left:10px;">
                      <form action="imprimir_agendamentos.php" method="post" id="form_imprimir0">
                          <input type="hidden" value="em_espera" id="em_espera" name="em_espera">
                         <a href="#" onclick="document.getElementById('form_imprimir0').submit();" class="pull-right" style="margin-right:30px;"><img src='images/icones/icone-08.png' style='margin-top:5px;height:25px; width:25px;'></a>
                       </form>
                      <table class="table table-striped table-condensed cf ">
                        <thead class="cf">
                        <tr>
                            <th class="date">Data</th>
                            <th class="time">Horário</th>  
                            <th>Endereço</th>
                            <th>Solicitante</th>
                            <th>Telefone</th>
                            <th>E-mail</th>
                            <th><center>Aceitar</center></th>
                            <th><center>Recusar</center></th>
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
                          echo "<tr>
                                  <td data-title='Data'>" . $format . "</td>
                                  <td data-title='Horário'>" . $agendamento[$i]->horario . "</td>
                                  <td data-title='Endereço'>" . $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais . "</td>
                                  <td data-title='Solicitante'>" . $usuario[0]->nome . "</td>
                                  <td data-title='Telefone'>" . $usuario[0]->telefone . "</td>
                                  <td data-title='E-mail'>" . $usuario[0]->email . "</td>                    
                                   <td data-title='Accept'><form method='POST' id='aceitar_agendamento". $agendamento[$i]->id ."' action='#'><input type='hidden' id='id' name='aceitar' value=" . $agendamento[$i]->id . "><center><a href='#' onclick=\"aceitara('aceitar_agendamento". $agendamento[$i]->id ."');\"><img src='images/icones/icone-02.png' style='height:25px; width:25px;'></a></center></form></td>
                                  <td data-title='Refuse'><form method='POST' id='recusar_agendamento". $agendamento[$i]->id ."' action='#'><input type='hidden' id='id' name='recusar' value=" . $agendamento[$i]->id . "><center><a href='#' onclick=\"aceitara('recusar_agendamento". $agendamento[$i]->id ."');\" id='recusar' name='recusar'><img src='images/icones/icone-01.png' style='height:25px; width:25px;'></a></center></form></td>
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
                 <div id="menu1" class="tab-pane fade <?php if($active == "menu1") echo 'in active'; ?>">
                    <?php                            

                    $json_dados = $service->call('agendamento.select_aceitos_by_empresa',array($_SESSION["id"]));
                    $agendamento = json_decode($json_dados);
                    $num = count($agendamento);
                    if ($num > 0)
                    {
                ?>
                <section id="no-more-tables" style="margin-right:10px;margin-left:10px;">
                   <form action="imprimir_agendamentos.php" method="post" id="form_imprimir1">
                        <input type="hidden" value="aceito" id="aceito" name="aceito">
                        <a href="#" onclick="document.getElementById('form_imprimir1').submit();" class="pull-right" style="margin-right:30px;"><img src='images/icones/icone-08.png' style='margin-top:5px;height:25px; width:25px;'></a>
                   </form>
                  <table class="table table-striped table-condensed cf ">
                      <thead class="cf">
                      <tr>
                          <th class="date">Data</th>
                          <th class="time">Horário</th>  
                          <th>Endereço</th>  
                          <th>Solicitante</th>
                          <th>Telefone</th>  
                          <th>E-mail</th>
                          <th><center>Cancelar</center></th>
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
                      echo '<tr>
                              <td data-title="Data">' . $format . '</td>
                              <td data-title="Horário">' . $agendamento[$i]->horario . '</td>
                              <td data-title="Endereço">' . $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais . '</td>
                              <td data-title="Solicitante">' . $usuario[0]->nome . '</td>
                              <td data-title="Telefone">' . $usuario[0]->telefone . '</td>
                              <td data-title="E-mail">' . $usuario[0]->email . '</td>
                              <td data-title="Cancelar"><form method="POST" id="cancelar_agendamento'. $agendamento[$i]->id .'" action="#"><input type="hidden" id="id" name="cancelar" value="' . $agendamento[$i]->id . '"><center><a href="#" onclick="aceitara(`cancelar_agendamento'. $agendamento[$i]->id .'`);"><img src="images/icones/icone-01.png" style="height:25px; width:25px;"></a></center></form></td>
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
                  <div id="menu2" class="tab-pane fade <?php if($active == "menu2") echo 'in active'; ?>">
                    <?php                            
                      $json_dados = $service->call('agendamento.select_atrasados_by_empresa',array($_SESSION["id"]));
                      $agendamento = json_decode($json_dados);
                      $num = count($agendamento);
                      if ($num > 0)
                      {
                  ?>
                  <section id="no-more-tables" style="margin-right:10px;margin-left:10px;">
                      <form action="imprimir_agendamentos.php" method="post" id="form_imprimir2">
                        <input type="hidden" value="atrasado" id="atrasado" name="atrasado">
                            <a href="#" onclick="document.getElementById('form_imprimir2').submit();" class="pull-right" style="margin-right:30px;"><img src='images/icones/icone-08.png' style='margin-top:5px;height:25px; width:25px;'></a>
                      </form>
                    <table class="table table-striped table-condensed cf">
                        <thead class="cf">
                          <tr>
                            <th class="date">Data</th>
                            <th class="time">Horário</th>  
                            <th>Endereço</th>
                            <th>Solicitante</th>
                            <th>Telefone</th>
                            <th>E-mail</th>
                            <th><center>Cancelar</center></th>
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
                          echo '<tr>
                                  <td data-title="Data">' . $format . '</td>
                                  <td data-title="Horário">' . $agendamento[$i]->horario . '</td>
                                  <td data-title="Endereço">' . $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais . '</td>
                                  <td data-title="Solicitante">' . $usuario[0]->nome . '</td>
                                  <td data-title="Telefone">' . $usuario[0]->telefone . '</td>
                                  <td data-title="E-mail">' . $usuario[0]->email . '</td>
                                  <td data-title="Cancelar"><form method="POST" id="cancelar_agendamento'. $agendamento[$i]->id .'" action="#"><input type="hidden" id="id" name="cancelar" value="' . $agendamento[$i]->id . '"><center><a href="#" onclick="aceitara(`cancelar_agendamento'. $agendamento[$i]->id .'`);");\"><img src="images/icones/icone-01.png" style="height:25px; width:25px;"></a></center></form></td>
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
                  <div id="menu3" class="tab-pane fade <?php if($active == "menu3") echo 'in active'; ?>">
                <?php                            
                  $json_dados = $service->call('agendamento.select_realizados_by_empresa',array($_SESSION["id"]));
                  $agendamento = json_decode($json_dados);
                  $num = count($agendamento);
                  if ($num > 0)
                  {
                ?>
                
                <section id="no-more-tables" style="margin-right:10px;margin-left:10px;">
                   <form action="imprimir_agendamentos.php" method="post" id="form_imprimir3">
                        <input type="hidden" value="realizado" id="realizado" name="realizado">
                        <a href="#" onclick="document.getElementById('form_imprimir3').submit();" class="pull-right" style="margin-right:30px;"><img src='images/icones/icone-08.png' style='margin-top:5px;height:25px; width:25px;'></a>
                   </form>
                   <table class="table table-striped table-condensed cf ">
                      <thead class="cf">
                         <tr>
                            <th class="date">Data</th>
                            <th class="time">Horário</th>  
                            <th>Endereço</th>
                            <th>Solicitante</th>
                            <th>Telefone</th>
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
                      echo '<tr>
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
                 <div id="menu4" class="tab-pane fade <?php if($active == "menu4") echo 'in active'; ?>">
                    <?php                            
                  $json_dados = $service->call('agendamento.select_cancelados_by_empresa',array($_SESSION["id"]));
                  $agendamento = json_decode($json_dados);
                  $num = count($agendamento);
                  if ($num > 0)
                  {
                ?>
                
                <section id="no-more-tables" style="margin-right:10px;margin-left:10px;">
                   <form action="imprimir_agendamentos.php" method="post" id="form_imprimir4">
                        <input type="hidden" value="cancelado" id="cancelado" name="cancelado">
                        <a href="#" onclick="document.getElementById('form_imprimir4').submit();" class="pull-right" style="margin-right:30px;"><img src='images/icones/icone-08.png' style='margin-top:5px;height:25px; width:25px;'></a>
                   </form>
                   <table class="table table-striped table-condensed cf ">
                      <thead class="cf">
                         <tr>
                            <th class="date">Data</th>
                            <th class="time">Horário</th>  
                            <th>Endereço</th>
                            <th>Solicitante</th>
                            <th>Telefone</th>
                            <th>E-mail</th>
                            <th>Justificativa</th>
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
                      echo '<tr>
                              <td data-title="Data">' . $format . '</td>
                              <td data-title="Horário">' . $agendamento[$i]->horario . '</td>
                              <td data-title="Endereço">' . $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais . '</td>
                              <td data-title="Solicitante">' . $usuario[0]->nome . '</td>
                              <td data-title="Telefone">' . $usuario[0]->telefone . '</td>
                              <td data-title="E-mail">' . $usuario[0]->email . '</td>
                              <td data-title="Justificativa">' . $agendamento[$i]->justificativa . '</td>
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

    <!--common script for all pages-->
  <script>
    function aceitara(ide)
    {
      document.getElementById(ide).submit();    
    }
  </script>  

  </body>
</html>
