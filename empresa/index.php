<?php 
  require_once("permissao.php");
  require_once("../conectar_service.php");

  $json = $service->call("agendamento.select_realizados_by_empresa",array($_SESSION["id"]));
  $num_realizados = count(json_decode($json));
  $json = $service->call("agendamento.select_cancelados_by_empresa",array($_SESSION["id"]));
  $num_cancelados = count(json_decode($json));
  $total_finalizados = $num_realizados + $num_cancelados;
  if($num_realizados > 0)
    $realizados = $num_realizados*100/$total_finalizados;
  else
    $realizados = 0;
  if($num_cancelados > 0)
    $cancelados = $num_cancelados*100/$total_finalizados;
  else
    $cancelados = 0;

  $json = $service->call("agendamento.select_sem_resposta_by_empresa",array($_SESSION["id"]));
  $num_solicitados = count(json_decode($json));
  $json = $service->call("agendamento.select_pendentes_by_empresa",array($_SESSION["id"]));
  $num_pendentes = count(json_decode($json));
  $json = $service->call("agendamento.select_atrasados_by_empresa",array($_SESSION["id"]));
  $num_atrasados = count(json_decode($json));
?>

<html lang="en" style="overflow: hidden;"><head>
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
  
    <style type="text/css">
      .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus
      {
        color: #fff;
        background-color: #2A3F54;
      }
    </style>

  </head>

  <body>

  <section id="container" class="sidebar-close">
    <?php
      require_once("topnav.php");
    ?>    
    <section class="wrapper site-min-height">
      <h3><i class="fa fa-angle-right"></i> Estatísticas</h3>
      <div class="col-md-5">
        <div class="content-panel">
          <div id="finalizados" class="graph"></div>
        </div>
      </div>
      <a href="agendamentos.php">
        <div class="col-md-2 col-sm-2 box0">
          <div class="box1">
            <span class="fa fa-plus-circle"></span>
            <h3><?php echo $num_solicitados; ?></h3>
                  </div>
            <p><?php echo $num_solicitados; ?> agendamentos solicitados.</p>
        </div>
      </a>
      <a href="agendamentos.php">
      <div class="col-md-2 col-sm-2 box0">
        <div class="box1">
          <span class="fa fa-hourglass-start"></span>
          <h3><?php echo $num_pendentes; ?></h3>
                </div>
          <p><?php echo $num_pendentes; ?> agendamentos pendentes.</p>
      </div>
      </a>
      <a href="agendamentos.php">
      <div class="col-md-2 col-sm-2 box0">
        <div class="box1">
          <span class="fa fa-hourglass-end"></span>
          <h3><?php echo $num_atrasados; ?></h3>
                </div>
          <p><?php echo $num_atrasados; ?> agendamentos atrasados.</p>
      </div>
      </a>
      <a href="agendamentos.php">
      <div class="col-md-2 col-sm-2 box0">
        <div class="box1">
          <span class="fa fa-calendar-check-o"></span>
          <h3><?php echo $num_realizados; ?></h3>
                </div>
          <p><?php echo $num_realizados; ?> agendamentos relizados.</p>
      </div>
      </a>
      <a href="agendamentos.php">
      <div class="col-md-2 col-sm-2 box0">
        <div class="box1">
          <span class="fa fa-calendar-times-o"></span>
          <h3><?php echo $num_cancelados; ?></h3>
                </div>
          <p><?php echo $num_cancelados; ?> agendamentos cancelados.</p>
      </div>
    </section>

  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
  <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
  <script src="assets/js/common-scripts.js"></script>

  <script>
    var Script = function () {
      $(function () {
        Morris.Donut({
          element: 'finalizados',
          <?php 
            if($total_finalizados > 0)
              echo "data: [
                      {label: 'Realizados', value: $realizados},
                      {label: 'Cancelados', value: $cancelados}
                    ],
                      colors: ['#0288D1', '#D32F2F'],
                    formatter: function (y) { return y + `%` }";
            else
              echo "data: [
                      {label: 'Sem agendamentos', value: 100}
                    ],
                      colors: ['#0288D1'],
                    formatter: function (y) {return 'finalizados'}";
          ?>
        });
      });
    }();
  </script>
  
</body></html>