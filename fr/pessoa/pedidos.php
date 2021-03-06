<?php 
  require_once("permissao_pessoa.php"); 

  if (isset($_POST))
  {
    if (isset($_POST['agendamento_id']))
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
<html lang="fr">
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
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/bootstrap-select.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
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
      <h3><i class="fa fa-angle-right"></i> Mes horaires</h3>
      <div class="row mt">
        <div class="col-lg-12">
           <div class="content-panel">
           <div class="row">
              <form action="imprimir_agendamentos.php" method="post" id="form_imprimir">
                  <a href="#" onclick="document.getElementById('form_imprimir').submit();" class="pull-right" style="margin-right:30px;"><img src='images/icones/icone-08.png' style='height:25px; width:25px;'></a>
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
                                 <th>Date</th>
                                 <th class="time">Temps</th>
                                 <th>Adresse</th>
                                 <th>Compagnie de collecte</th>
                                 <th><center>Statut</center></th>
                                 <th><center>Annuler</center></th>
                                 <th><center>Marquer comme terminé</center></th>
                                 <th><center>Raison</center></th>
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
                                  $status = 'Pas confirmé'; 
                                }
                                if($agendamento[$i]->aceito == 1 and $agendamento[$i]->realizado == 0 and $agendamento[$i]->data_agendamento >= date("Y-m-d"))
                                {
                                  $status = 'Attendre';
                                }
                                if($agendamento[$i]->aceito == 1 and $agendamento[$i]->realizado == 0 and $agendamento[$i]->data_agendamento < date("Y-m-d"))
                                {
                                  $status = 'En retard';
                                }
                                if($agendamento[$i]->aceito == 1 and $agendamento[$i]->realizado == 1)
                                {
                                  $status = 'Fini';
                                }
                                if($agendamento[$i]->aceito == 0 and $agendamento[$i]->realizado == 1)
                                {
                                  $status = 'Annuler';
                                }
                                echo '<tr>
                                        <td data-title="Date">' . $format . '</td>
                                        <td data-title="Temps">' . $agendamento[$i]->horario . '</td>
                                        <td data-title="Adresse">' . $endereco[0]->nome . '</td>
                                        <td data-title="Compagnie de collecte">' . $empresa[0]->nome_fantasia . '</td>
                                        <td data-title="Statut"><center>' . $status . '</center></td>';
                                        if($status != 'Annuler' and $status != 'Fini')
                                        {
                                          echo '<td data-title="Annuler"><form method="POST" action="#"><input type="hidden" id="id'.$agendamento[$i]->id.'" name="id'.$agendamento[$i]->id.'" value='.$agendamento[$i]->id.'><center><a href="#" type="button" id="excluir" name="excluir" onclick="document.getElementById(`agendamento_id`).value = getElementById(`id'.$agendamento[$i]->id.'`).value;" data-toggle="modal" data-target="#myModal"><img src="images/icones/icone-13.png" style="height:25px; width:25px;"></a></center></form></td>';
                                          if($status == 'Pas confirmé')
                                            echo '<td data-title="Marquer comme terminé"><form method="POST" action="#" id="finalizar'.$agendamento[$i]->id.'"><input type="hidden" id="id" name="id" value=' . $agendamento[$i]->id . '><input type="hidden" id="realizar" name="realizar"><center>-</center></form></td><td data-title="Raison"><center>-</center></td></tr>';
                                          else
                                            echo '<td data-title="Annuler"><center>-</center></td><td data-title="Raison"><center>-</center></td></tr>';
                                        }
                                        else
                                        {
                                          echo '<td><center>-</center></td>';
                                          echo '<td data-title="Raison"><center>-</center></td>';
                                          if ($status == 'Annuler') {
                                            echo "<td data-title='Raison'><center>".$agendamento[$i]->justificativa."</center></td>";
                                          }
                                          else
                                            echo '<td data-title="Raison"><center>-</center></td>';
                                          echo "</tr>";
                                        }
                                       
                              }
                          ?>
                        </tbody>
                      </table>
                    </section>
                  <?php
                    }
                    else
                      echo "<center><h4>Vous n'avez pas d'adresse enregistrée.</h4></center><br>";
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
                                  <h4 class="modal-title">Annulation de la justification</h4>
                              </div>
                              <form action="#" method="post" id="just">
                                <div class="modal-body">
                                    
                                        <label class="col-sm-4 control-label">*Justification</label>
                                        <div class="col-sm-8">
                                              <select id="justificativa" name="justificativa" class="selectpicker" data-done-button="true">
                                                  <option value="En retard sur la collection">En retard sur la collection</option>
                                                  <option value="Je ne serai pas sur mon adresse le jour prévu">Je ne serai pas sur mon adresse le jour prévu</option>
                                                  <option value="Trash déjà ramassé">Trash déjà ramassé</option>
                                                  <option value="Une autre raison">Une autre raison</option>
                                              </select>
                                              <input type="hidden" name="agendamento_id" id="agendamento_id" value='0'>
                                        </div>
                                    <br>
                                </div>
                                <div class="modal-footer">
                                      <button onclick="document.getElementById('just').submit();" class="btn btn-theme" id="cancelar" name="cancelar" data-dismiss="modal">Envoyer</button>
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
  
  
  <script type="application/javascript">
        $(document).ready(function () {
            $("#date-popover").popover({html: true, trigger: "manual"});
            $("#date-popover").hide();
            $("#date-popover").click(function (e) {
                $(this).hide();
            });
        
            $("#my-calendar").zabuto_calendar({
                action: function () {
                    return myDateFunction(this.id, false);
                },
                action_nav: function () {
                    return myNavFunction(this.id);
                },
                ajax: {
                    url: "show_data.php?action=1",
                    modal: true
                },
                legend: [
                    {type: "text", label: "Special event", badge: "00"},
                    {type: "block", label: "Regular event", }
                ]
            });
        });
        
        
        function myNavFunction(id) {
            $("#date-popover").hide();
            var nav = $("#" + id).data("navigation");
            var to = $("#" + id).data("to");
            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }
    </script>
  

  </body>
</html>
