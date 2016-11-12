<?php 
  require_once("permissao.php");
  require_once("../conectar_service.php");

  function dia_semana($data)
  {
    $ano =  substr($data,0,4);
    $mes =  substr($data,5,-3);
    $dia =  substr($data,8,9);
    return date("w", mktime(0,0,0,$mes,$dia,$ano) );
  }

  function semanas_mes() 
  {
    $data = new DateTime();
    $data->setDate(date("Y"),date("m"),01);
    $dataFimMes = new DateTime();
    $dataFimMes->setDate(date("Y"),date("m"),date("t"));

    $numSemanaInicio = $data->format('W');
    $numSemanaFinal  = $dataFimMes->format('W') + 1;

    // Última semana do ano pode ser semana 1
    $numeroSemanas = ($numSemanaFinal < $numSemanaInicio)  
        ? (52 + $numSemanaFinal) - $numSemanaInicio
        : $numSemanaFinal - $numSemanaInicio;
    return $numeroSemanas;
  }

  $realizados_semana = [];
  $json = $service->call("agendamento.select_realizados_by_empresa",array($_SESSION["id"]));
  $realizados = json_decode($json);
  $num_realizados = count($realizados);
  for($i=0;$i<$num_realizados;$i++)
  {
    $data_agendamento = DateTime::createFromFormat('Y-m-d',$realizados[$i]->data_agendamento);
    $format = $data_agendamento->format('Y-m');
    $semana1 = DateTime::createFromFormat('Y-m-d',$format.'-01');
    $semana1 = $semana1->format("W");
    $semana1--;
    if($data_agendamento->format("Y-m") == date("Y-m"))
    {
      $semana = $data_agendamento->format("W");
      $semana = $semana - $semana1;
      if($data_agendamento->format("N") == 7)
        $semana++;
      if(isset($realizados_semana["semana".$semana]))
        $realizados_semana["semana$semana"]++;
      else
        $realizados_semana["semana$semana"] = 1;
    }
  }

  $json = $service->call("agendamento.select_cancelados_by_empresa",array($_SESSION["id"]));
  $num_cancelados = count(json_decode($json));
  $total_finalizados = $num_realizados + $num_cancelados;
  if($num_realizados > 0)
    $realizados = round($num_realizados*100/$total_finalizados,1);
  else
    $realizados = 0;
  if($num_cancelados > 0)
    $cancelados = round($num_cancelados*100/$total_finalizados,1);
  else
    $cancelados = 0;

  $json = $service->call("agendamento.select_sem_resposta_by_empresa",array($_SESSION["id"]));
  $num_solicitados = count(json_decode($json));
  $json = $service->call("agendamento.select_aceitos_by_empresa",array($_SESSION["id"]));
  $num_pendentes = count(json_decode($json));
  $json = $service->call("agendamento.select_atrasados_by_empresa",array($_SESSION["id"]));
  $num_atrasados = count(json_decode($json));
?>

<html lang="fr" style="overflow: hidden;"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>DescartesLab</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">    
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    
    <script src="https://use.fontawesome.com/9c8fd2c64e.js"></script>

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/table-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>
  
   <style type="text/css">
     h4{
      text-align: center;
     }
   </style>
  </head>

  <body>

  <section id="container" class="sidebar-close">
    <?php
      require_once("navtop.php");
    ?>    
    <section class="wrapper" style="margin-top:60px;">
      <h3><i class="fa fa-angle-right"></i> Statistiques</h3>
      <div class="col-md-1">
      </div>
      <a href="agendamentos.php">
        <div class="col-md-2 box0">
          <div class="box1">
            <img src="images/agenda5.png" height="35" alt="agenda" width="35">
            <h3><?php echo $num_solicitados; ?></h3>
                  </div>
            <p><?php echo $num_solicitados; ?> horaires demandés.</p>
        </div>
      </a>
      <a href="agendamentos.php">
        <div class="col-md-2 box0">
          <div class="box1">
            <img src="images/agenda1.png" height="35" alt="agenda 1" width="35">
            <h3><?php echo $num_pendentes; ?></h3>
                  </div>
            <p><?php echo $num_pendentes; ?> calendriers en attente.</p>
        </div>
      </a>
      <a href="agendamentos.php">
        <div class="col-md-2 box0">
          <div class="box1">
            <img src="images/agenda3.png" height="35" alt="agenda 2" width="35">
            <h3><?php echo $num_atrasados; ?></h3>
                  </div>
            <p><?php echo $num_atrasados; ?> schedules late.</p>
        </div>
      </a>
      <a href="agendamentos.php">
        <div class="col-md-2 box0">
          <div class="box1">
            <img src="images/agenda2.png" alt="agenda 3" height="35" width="35">
            <h3><?php echo $num_realizados; ?></h3>
                  </div>
            <p><?php echo $num_realizados; ?> calendriers effectués.</p>
        </div>
      </a>
      <a href="agendamentos.php">
        <div class="col-md-2 box0">
          <div class="box1">
            <img src="images/agenda4.png" alt="agenda 4" height="35" width="35">
            <h3><?php echo $num_cancelados; ?></h3>
                  </div>
            <p><?php echo $num_cancelados; ?> horaires annulés.</p>
        </div>
      </a>
      <div class="col-md-1">
      </div>
      <div class="col-md-5" style="margin-top: 10px">
        <div class="content-panel">
          <center><h4>Calendrier finalisé</h4></center>
          <div id="finalizados" class="graph"></div>
        </div>
      </div>
      <div class="col-md-7" style="margin-top: 10px">
        <div class="content-panel" style="padding-bottom: 46px;">
          <center><h4>Programmes effectués dans le mois</h4></center>
          <div id="finalizados_mes" class="graph" style="height: 300px; margin-left: 10px;"></div>
        </div>
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
                      {label: 'Réalisé', value: $realizados},
                      {label: 'Annulé', value: $cancelados}
                    ],
                      colors: ['#0288D1', '#D32F2F'],
                    formatter: function (y) { return y + `%` }";
            else
              echo "data: [
                      {label: 'Sans horaires', value: 100}
                    ],
                      colors: ['#0288D1'],
                    formatter: function (y) {return 'finalizados'}";
          ?>
        });

        Morris.Line({
          element: 'finalizados_mes',
          data: [
            <?php
              $data = '';
              for($i=1;$i<=semanas_mes(date("Y"),date("m"));$i++)
              {
                if($i > 1)
                  $data = ",".$data;
                if(isset($realizados_semana["semana$i"]))
                  $data = "{ 'semaine': '${i}º semaine', value: ".$realizados_semana["semana$i"]." }".$data;
                else
                  $data = "{ 'semaine': '${i}º semaine', value: 0 }".$data;
              }
              echo $data;
            ?>
          ],
          xkey: 'semaine',
          ykeys: ['value'],
          ymin: 0,
          yLabelFormat: function(y){return y != Math.round(y)?'':y;},
          xLabelFormat: function(){return "";},
          labels: ['Total']
        });
      });
    }();
  </script>
  
</body></html>