<?php 
  require_once("permissao.php"); 

  if (isset($_POST))
  {
    if (isset($_POST['excluir']))
    {
      require_once("../conectar_service.php"); 
      $batata = $service->call('ponto.delete',array($_POST['id']));
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
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
	
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" >      
      <?php
          require_once("navtop.php");
      ?>
  </section>
  
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT  TABELA RESPONSIVA
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
        <section class="wrapper">
          <h3>
            <div class="row">
              <div class="col-sm-6">
                  <div class="pull-left">
                    <i class="fa fa-angle-right "></i>Meus Pontos
                  </div>
              </div>
            </div>
          </h3>
          <div class="row mt">
             <div class="col-lg-12">
                <div class="content-panel">
                 <?php                            
                    $json_dados = $service->call('ponto.select_by_empresa',array($_SESSION["id"]));
                    $ponto = json_decode($json_dados);
                    $num = count($ponto);
                    if ($num > 0)
                    {
                  ?>
                  <section id="no-more-tables">
                    <table class="table table-striped table-condensed cf ">
                       <thead class="cf">
                          <tr>
                             <th>Endereço</th>
                             <th class="number">Telefone</th>
                             <th class="time">Horário de atendimento</th>
                             <th>Observação</th>
                             <th><center>Editar</center></th>
                             <th><center>Excluir</center></th>
                          </tr>
                       </thead>
                       <tbody>
                    <?php
                      for($i=0;$i<$num;$i++)
                      {
                        $json_dados = $service->call('endereco.select_by_id',array($ponto[$i]->endereco_id));
                        $endereco = json_decode($json_dados);
                        echo '<tr>
                                <td data-title="Endereço">' . $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais . '</td>
                                <td data-title="Telefone">' . $ponto[$i]->telefone . '</td>
                                <td data-title="Horário">' . $ponto[$i]->atendimento_ini . ' - ' . $ponto[$i]->atendimento_fim . '</td>
                                <td data-title="Observação">' . $ponto[$i]->observacao . '</td>
                                <td data-title="Editar"><form method="POST" action="cadastro_pontos.php"><input type="hidden" id="id" name="id" value=' . $ponto[$i]->id . '><center><button type="submit" id="editar" name="editar" class="btn btn-theme"><i class="fa fa-pencil"></i></button></center></form></td>
                                <td data-title="Excluir"><form method="POST" action="#"><input type="hidden" id="id" name="id" value=' . $ponto[$i]->id . '><center><button type="submit" id="excluir" name="excluir" class="btn btn-danger"><i class="fa fa-times"></i></button></center></form></td></tr>';
                      }
                  ?>
                        </tbody>
                      </table>
                    </section>
                    <div class="container-fluid">
                       <a href="mapa_pontos.php"><button class=" btn btn-theme03 pull-right">Visualizar mapa</button></a><br><br>
                    </div>
                  <?php
                    }
                    else
                      echo "<center><h4>Você não possui pontos. Para cadastrar um, <a href='mapa_pontos.php'>clique aqui!</a></h4></center><br>";
                  ?>
                </div>
              </div>
          </div>
        </section>
      </section>

      </section>
    

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    
    
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>    
	  <script src="assets/js/zabuto_calendar.js"></script>

    <script type="text/javascript">
      $("#loco").click(function(){
          $('[data-offset="loco"').toggleClass("hidden");
      });
    </script>	
	
  </body>
</html>
