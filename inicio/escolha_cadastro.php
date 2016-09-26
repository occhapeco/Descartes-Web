<?php 
  require_once("../conectar_service.php");
?>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmWPAIE9_AASg6Ijgoh0lVOZZ_VWvw6fg&libraries=places"></script> 


    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/table-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>

    <style>
      .esquerda{
        margin-top:10px;
        height:350px;
        width:350px;
      }

      .direita{
        margin-top:10px;
        height:350px;
        width:350px;
      }

    </style>
	
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
      <section >
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Cadastro</h3>
          	
          	<!-- BASIC FORM ELELEMNTS -->
          	<div class="row mt">
          		<div class="form-panel offset1 col-lg-12">
                <form method="post" action="#">
                  <div class="col-lg-2">
                  </div>
                    <div class="col-lg-4 esquerda" style="margin-top:10px;">
                       <a href="cadastro_pessoa.php"><img src="pessoa.png" class="img-responsive img-rounded pull-right"></a>
                    </div>
                    <div class="col-lg-4 direita" style="margin-top:10px;">
                      <a href="cadastro_empresa.php"><img src="ind3.png" class="img-responsive img-rounded"></a>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </form>
				      </div><!-- col-lg-12-->      	
           </div><!-- /row -->
        </section><!--/wrapper -->
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

  </body>
</html>
