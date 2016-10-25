<?php 
  require_once("permissao_pessoa.php"); 

  if (isset($_POST))
  {
    if (isset($_POST['cancelar']))
    {
      require_once("../conectar_service.php"); 
      $batata = $service->call('agendamento.cancelar',array($_POST['agendamento_id'],$_POST['justificativa']));
    }
    if (isset($_POST['realizar']))
    {
      require_once("../conectar_service.php"); 
      $batata = $service->call('agendamento.realizar',array($_POST['id']));
    }

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
    
    <script src="https://use.fontawesome.com/9c8fd2c64e.js"></script>

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <script src="dist/js/bootstrap-select.js"></script>
 
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
      <h3><i class="fa fa-angle-right"></i> Meus Agendamentos</h3>
      <div class="row mt">
        <div class="col-lg-12">
           <div class="content-panel">
           <div class="row">
              <form action="imprimir_agendamentos.php" method="post">
                  <a class="pull-right" style="margin-right:30px;"><img src='images/icones/icone-08.png' style='height:25px; width:25px;'></a>
              </form>
              </div>
                 <?php                            
                    $json_dados = $service->call('agendamento.select',array('usuario_id = '. $_SESSION["id"]));
                    $agendamento = json_decode($json_dados);
                    if (count($agendamento) > 0)
                    {
                 ?>
                      <section id="no-more-tables" style="margin-right:10px;margin-left:10px;">
                        <table class="table table-striped table-condensed cf ">
                           <thead class="cf">
                              <tr>
                                 <th>Data</th>
                                 <th class="time">Horário</th>
                                 <th>Endereço</th>
                                 <th>Coletadora</th>
                                 <th><center>Status</center></th>
                                 <th><center>Cancelar</center></th>
                                 <th><center>Marcar como Realizado</center></th>
                              </tr>
                           </thead>
                           <tbody>
                            <?php
                              for($i=0;$i<(count($agendamento));$i++)
                              {
                                $json_dados = $service->call('usuario_has_endereco.select', array('usuario_id = '.$_SESSION["id"].' AND endereco_id = '. $agendamento[$i]->endereco_id));
                                $endereco = json_decode($json_dados);
                                $json_dados = $service->call('empresa.select', array('id = '. $agendamento[$i]->empresa_id));
                                $empresa = json_decode($json_dados);
                                $status = "";
								                $data_agendamento = DateTime::createFromFormat('Y-m-d',$agendamento[$i]->data_agendamento);
								                $format = $data_agendamento->format('d/m/Y');

                                if($agendamento[$i]->aceito == 0 and $agendamento[$i]->realizado == 0)
                                {
                                  $status = 'Não Confirmado'; 
                                }
                                if($agendamento[$i]->aceito == 1 and $agendamento[$i]->realizado == 0 and $agendamento[$i]->data_agendamento >= date("Y-m-d"))
                                {
                                  $status = 'Em Espera';
                                }
                                if($agendamento[$i]->aceito == 1 and $agendamento[$i]->realizado == 0 and $agendamento[$i]->data_agendamento < date("Y-m-d"))
                                {
                                  $status = 'Atrasado';
                                }
                                if($agendamento[$i]->aceito == 1 and $agendamento[$i]->realizado == 1)
                                {
                                  $status = 'Realizado';
                                }
                                if($agendamento[$i]->aceito == 0 and $agendamento[$i]->realizado == 1)
                                {
                                  $status = 'Cancelado';
                                }
                                echo '<tr>
                                        <td data-title="Data">' . $format . '</td>
                                        <td data-title="Horário">' . $agendamento[$i]->horario . '</td>
                                        <td data-title="Endereço">' . $endereco[0]->nome . '</td>
                                        <td data-title="Coletadora">' . $empresa[0]->nome_fantasia . '</td>
                                        <td data-title="Coletadora"><center>' . $status . '</center></td>';
                                        if($status != 'Cancelado' and $status != 'Realizado')
                                        {
                                          echo '<td data-title="Cancelar"><form method="POST" action="#"><input type="hidden" id="id'.$agendamento[$i]->id.'" name="id'.$agendamento[$i]->id.'" value='.$agendamento[$i]->id.'><center><a type="button" id="excluir" name="excluir" onclick="getElementById(`agendamento_id`).value = getElementById(`id'.$agendamento[$i]->id.'`).value" data-toggle="modal" data-target="#myModal"><img src="images/icones/icone-13.png" style="height:25px; width:25px;"></a></center></form></td>';
                                          echo '<td data-title="Marcar como Realizado"><form method="POST" action="#"><input type="hidden" id="id" name="id" value=' . $agendamento[$i]->id . '><center><a type="submit" id="realizar" name="realizar"><img src="images/icones/icone-06.png" style="height:25px; width:25px;"></a></center></form></td></tr>';
                                        }
                                        else
                                        {
                                          echo '<td></td>';
                                          echo '<td></td></tr>';
                                        }
                                       
                              }
                          ?>
                        </tbody>
                      </table>
                    </section>
                  <?php
                    }
                    else
                      echo "<center><h4>Você não possui agendamentos.</h4></center><br>";
                  ?>
                </div>
                  </div><!-- /col-lg-12 -->
              </div><!-- /row -->

              <!--modal -->
              <div class="container">
                  <!-- Modal -->
                  <div class="modal fade" id="myModal" role="dialog" style="z-index:99999999">
                        <div class="modal-dialog">
       
                          <!-- Modal content-->
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Justificativa do Cancelamento</h4>
                              </div>
                                 <form action="#" method="post">
                                    <div class="modal-body">
                                        <label class="col-sm-4 control-label">*Justificativa</label>
                                        <div class="col-sm-8">
                                              <select id="justificativa" name="justificativa" class="selectpicker" data-done-button="true">
                                                  <option value="Atraso no recolhimento">Atraso no recolhimento</option>
                                                  <option value="Não estarei no dia agendado">Não estarei no dia agendado</option>
                                                  <option value="Lixo já recolhido">Lixo já recolhido</option>
                                                  <option value="Outro motivo">Outro motivo</option>
                                              </select>
                                        </div>
                                        <br>
                                  </div>
                                  <div class="modal-footer">
                                        <button type="submit" class="btn btn-theme" id="cancelar" name="cancelar" data-dismiss="modal">Enviar</button>
                                  </div>
                              </form>
                          </div>
       
                        </div>
                  </div>
   
              </div>


    </section><! --/wrapper -->

      </section><!-- container-->

    

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
    
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>    
  <script src="assets/js/zabuto_calendar.js"></script>  
  
  </body>
</html>
