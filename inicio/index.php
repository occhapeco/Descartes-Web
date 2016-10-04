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

    <script src="js/cbpAnimatedHeader.js"></script>

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/table-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>
    
  </head>

  <style>
    html, body{
      height: auto;
    }
    .section1{
      width: 100%;
      height:100%;
      min-height: 100%;
      background-color: #393939;
    }
  </style>

  <body>
  <?php 
    require_once("topnav.php");
  ?>
  
  <section id="section1" class="container">
     
  <!-- ***********************************************************************************************************************************************
      MAIN CONTENT Formulário
      *********************************************************************************************************************************************-->
      <!--main content start-->
      <section id="section1" class="section1">
          <section class="wrapper">
              <img src="img_inicio.png" class="img-responsive"> 
          </section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <section id="section2" class="section2">
        <section class="wrapper">
          <?php
              require_once("carousel.html");
          ?>
        </section>
      </section>

      <section id="section3" class="section3">
        <section class="wrapper">
          <?php
             // mapa;
          ?>
        </section>
      </section>

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
    </body>
</html>
