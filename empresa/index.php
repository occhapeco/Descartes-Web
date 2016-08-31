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
	
	
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
                  <h4><i class="fa fa-angle-right fa-d"></i> Em espera</h4>
                  <?php                            
                      $json_dados = $service->call('agendamento.select_pendentes_by_empresa',array($_SESSION["id"]));
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
                            <th><center>Aceitar</center></th>
                            <th><center>Recusar</center></th>
                        </tr>
                        </thead>
                        <tbody>
                          <tr class="info">
                    <?php
                        for ($i=0;$i<$num;$i++)
                        {
                          // Dados do endereço
                          $json_dados = $service->call('endereco.select',array("id = $endereco_id"));
                          $endereco = json_decode($json_dados);
                          // Dados do usuário
                          $json_dados = $service->call('usuario.select',array("id = $agendamento->usuario_id"));
                          $usuario = json_decode($json_dados);
                          echo "<td data-title='Data'>" . $agendamento[$i]->data_agendamento . "</td>
                                <td data-title='Horário'>" . $agendamento[$i]->horario . "</td>
                                <td data-title='Endereço'>" . $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais . "</td>
                                <td data-title='Solicitante'>" . $usuario[0]->nome . "</td>
                                <td data-title='Telefone'>" . $usuario[0]->telefone . "</td>
                                <td data-title='E-mail'>" . $usuario[0]->email . "</td>                    
                                <td data-title='Aceitar'><form method='POST' action='tratar_agendamento.php'><input type='hidden' id='id' value=" . $agendamento[$i]->id . "><center><button type='submit' id='aceitar' class='btn btn-theme'><i class='fa fa-check'></i></button></center></form></td>
                                <td data-title='Recusar'><form method='POST' action='tratar_agendamento.php'><input type='hidden' id='id' value=" . $agendamento[$i]->id . "><center><button type='submit' id='recusar' class='btn btn-danger'><i class='fa fa-times'></i></button></center></form></td>";
                        }
                    ?>
                          </tr>
                        </tbody>
                      </table>
                    </section>
                    <?php
                      }
                      else
                        echo "<center><h4>Você não possui agendamentos em espera.</h4></center><br>";
                    ?>
									      
              </div>
            </div>
          </div>
        </section>
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
