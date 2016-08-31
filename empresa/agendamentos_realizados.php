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
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">    
    
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
          require_once("topnav.php");
          require_once("sidenav.php");
      ?>
  
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT  TABELA RESPONSIVA
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Agendamentos</h3>
        <div class="row mt">
          <div class="col-lg-12">
            <div class="content-panel">
                <h4><i class="fa fa-angle-right fa-d"></i> Realizados</h4>
                <?php                            
                  $json_dados = $service->call('agendamento.select_realizados_by_empresa',array($_SESSION["id"]));
                  $agendamento = json_decode($json_dados);
                  $num = count($agendamento);
                  if ($num > 0)
                  {
                ?>
                <section id="no-more-tables">
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
                      $json_dados = $service->call('usuario.select_by_id',array($agendamento[$i]->usuario_id));
                      $usuario = json_decode($json_dados);
                      echo '<tr class="warning">
                              <td data-title="Data">' . $agendamento[$i]->data_agendamento . '</td>
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
                    echo "<center><h4>Você não possui agendamentos realizados.</h4></center><br>";
                ?>
            </div><!-- /content-panel -->
          </div><!-- /col-lg-12 -->
        </div><!-- /row -->
      </section><! --/wrapper -->
    </section><!-- /MAIN CONTENT -->

  </section><!-- Conteiner-->
    

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
	
	<script type="text/javascript">
        $(document).ready(function () {
        var unique_id = $.gritter.add({
            image: 'assets/img/ui-sam.jpg',
            sticky: true,
            time: '',
            class_name: 'my-sticky-class'
        });

        return false;
        });
	</script>
	
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
