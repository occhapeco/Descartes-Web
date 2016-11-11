<?php 
  require_once("../conectar_service.php");

  session_start();
  
  //Cadastro
  if (isset($_POST["cadastrar"]))
  {
    // Cadastra o endereço e retorna seu id (0 se der bosta)
    $lixo_id = $service->call('tipo_lixo.insert',array($_POST["nome_lixo"],$_POST["nome_eng"]));
  }

  if(isset($_POST["excluir"]))
  {
    $lixo = $service->call('tipo_lixo.delete', array($_POST["id"]));
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
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    
    <script src="https://use.fontawesome.com/9c8fd2c64e.js"></script>

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/table-responsive.css" rel="stylesheet">

  </head>

  <body>

  <section id="container" >
     <?php 
          require_once("topnav.php");
      ?>
  
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT Formulário
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section class="wrapper">
      	<h3><i class="fa fa-angle-right"></i> Les types de déchets</h3>
      	
      	<!-- BASIC FORM ELELEMNTS -->
      	<div class="row mt">
      		<div class="col-lg-12">
              <div class="form-panel offset1">
                  <form class="form-horizontal style-form" method="post" action="#">
                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Nom de déchets</label>
                          <div class="col-sm-10">
                            <input type="text" id="nome_lixo" name="nome_eng" maxlength="20"  class="form-control" autofocus required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Nom du déchet (portugais)</label>
                          <div class="col-sm-10">
                            <input type="text" id="lixo" name="nome_lixo" maxlength="20"  class="form-control" autofocus required>
                          </div>
                      </div>
                      <button type="submit" id="cadastrar" name="cadastrar" class="btn btn-sm btn-theme pull-right">Registre</button>
                      <a class="btn btn-sm btn-theme03 pull-right" id="oiem" style="margin-right: 10px;" onclick="document.getElementById('nome_lixo').value=' ';document.getElementById('lixo').value=' ';">Annuler</a><br><br>
                  </form>
              </div>
		      </div><!-- col-lg-12-->      	
       </div><!-- /row -->

       <div class="row mt">
          <div class="col-lg-12">
              <div class="form-panel offset1">
               <div class="content-panel">
                  <section id="no-more-tables">
                    <table class="table table-striped table-condensed cf ">
                       <thead class="cf">
                          <tr>
                             <th>Nom du déchet</th>
                             <th>Nom du déchet (portugais)</th>
                             <th><center>Effacer</center></th>
                          </tr>
                       </thead>
                       <tbody>
                        <?php
                          $json_dados = $service->call('tipo_lixo.select', array(NULL));
                          $lixo = json_decode($json_dados);
                          for($i=0;$i<(count($lixo));$i++)
                          {
                            echo '<tr>
                                    <td data-title="Nom du déchet">' . $lixo[$i]->nome_eng . '</td>
                                    <td data-title="Nom du déchet (portugais)">' . $lixo[$i]->nome . '</td>
                                    <td data-title="Effacer"><form method="POST" action="#" id="lixo'. $lixo[$i]->id .'"><input type="hidden" id="id" name="id" value=' . $lixo[$i]->id . '><input type="hidden" id="excluir" name="excluir"><center><a href="#" onclick="document.getElementById(`lixo'. $lixo[$i]->id .'`).submit();" id="excluir"><img src="images/excluir.png" height="25px;" width="25px;"></a></center></form></td></tr>';
                          }
                      ?>
                    </tbody>
                  </table>
                </section>
              </div>
            </div>
          </div><!-- col-lg-12-->       
       </div><!-- /row -->
	</section><! --/wrapper -->

			
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
    
	</body>
</html>