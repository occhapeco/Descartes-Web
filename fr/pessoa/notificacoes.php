<?php 
  require_once("permissao_pessoa.php");
  require_once("../conectar_service.php");

  $service->call("notificacao.visualizar_todos_by_usuario", array($_SESSION["id"]));
?>

<!DOCTYPE html>
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

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/table-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>
	
  	<style type="text/css">
      .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus
      {
        color: #fff;
        background-color: #2A3F54;
      }
    </style>

  </head>

  <body>

  <section id="container" >
      
      <?php require_once("navtop.php"); ?>    
  
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT  TABELA RESPONSIVA
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
        <section class="wrapper">
          <h3><i class="fa fa-angle-right"></i> Notifications centrales</h3>
            <div class="col-lg-12 ds">
              <?php
                $json = $service->call("notificacao.select_by_usuario", array($_SESSION["id"]));
                $notificacao = json_decode($json);
                $num = count($notificacao);
                for($i=0;$i<$num;$i++)
                {
                    $json_dados = $service->call('empresa.select',array("id = ".$notificacao[$i]->empresa_id));
                    $empresa = json_decode($json_dados);
                   if ($notificacao[$i]->tipo == 1) // Novo agendamento
                        echo '<a href="pedidos.php" style="color: #11ABB0;">
                                <div class="desc">
                                  <div class="thumb">
                                    <span class="badge bg-theme"><i class="fa fa-plus-circle"></i></span>
                                  </div>
                                  <div class="details" style="width: 80%">
                                    <p style="font-size: 17px">
                                      <b>'.$empresa[0]->nome_fantasia.'</b> refusé un calendrier.<br>
                                    </p>
                                  </div>
                                </div>
                              </a>';
                    else{ // Agendamento cancelado
                        echo '<a href="pedidos.php" style="color: #11ABB0;">
                                <div class="desc">
                                  <div class="thumb">
                                    <span class="badge bg-theme"><i class="fa fa-calendar-times-o"></i></span>
                                  </div>
                                  <div class="details" style="width: 80%">
                                    <p style="font-size: 17px">
                                      <b>'.$empresa[0]->nome_fantasia.'</b> accepté un calendrier.<br>
                                    </p>
                                  </div>
                                </div>
                              </a>';
                    }
                }
            ?>
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

  </body>
</html>
