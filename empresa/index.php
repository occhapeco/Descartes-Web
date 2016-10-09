<?php require_once("permissao.php"); ?>

<html lang="en" style="overflow: hidden;"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>DASHGUM - Bootstrap Admin Template</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">    
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" class="sidebar-close">
      <?php
        require_once("topnav.php");
        require_once("sidenav.php");
      ?>    
      <section id="main-content">
          <section class="wrapper site-min-height">
          <h3><i class="fa fa-angle-right"></i> Morris Charts</h3>
              <!-- page start-->
              <div id="morris">
                  <div class="row mt">
                      <div class="col-lg-6">
                          <div class="content-panel">
                              <h4><i class="fa fa-angle-right"></i> Chart Example 1</h4>
                              <div class="panel-body">
                                  <div id="hero-graph" class="graph" style="position: relative;"></div>
                              </div>
                          </div>
                      </div>
            
                  <div class="row mt">
                      
                      <div class="col-lg-6">
                          <div class="content-panel">
                              <h4><i class="fa fa-angle-right"></i> Chart Example 4</h4>
                              <div class="panel-body">
                                  <div id="hero-donut" class="graph"><svg height="342" version="1.1" width="675" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#3498db" d="M337.5,282.5A109,109,0,0,0,446.4999996638166,173.50856083997223" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#3498db" stroke="#ffffff" d="M337.5,285.5A112,112,0,0,0,449.49999965456385,173.508796459421L495.99999951114614,173.51244856087703A158.5,158.5,0,0,1,337.5,332Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#2980b9" d="M446.4999996638166,173.50856083997223A109,109,0,0,0,251.12725385519667,107.01128875210951" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path><path fill="#2980b9" stroke="#ffffff" d="M449.49999965456385,173.508796459421A112,112,0,0,0,248.75002230992686,105.18132422235105L207.940880782795,73.76693312816425A163.5,163.5,0,0,1,500.99999949572486,173.51284125995835Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#34495e" d="M251.12725385519667,107.01128875210951A109,109,0,0,0,271.0045052575654,259.8675238672434" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#34495e" stroke="#ffffff" d="M248.75002230992686,105.18132422235105A112,112,0,0,0,269.1743540261223,262.2446116801033L240.8070099387534,299.0894727794319A158.5,158.5,0,0,1,211.9029333582447,76.81687401109501Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#3498db" d="M271.0045052575654,259.8675238672434A109,109,0,0,0,337.46575664063926,282.49999462106564" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#3498db" stroke="#ffffff" d="M269.1743540261223,262.2446116801033A112,112,0,0,0,337.4648141628587,285.4999944730216L337.4502057572598,331.9999921783386A158.5,158.5,0,0,1,240.8070099387534,299.0894727794319Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="337.5" y="163.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-style: normal; font-variant: normal; font-weight: 800; font-stretch: normal; font-size: 15px; line-height: normal; font-family: Arial;" font-size="15px" font-weight="800" transform="matrix(2.4773,0,0,2.4773,-498.5565,-257.7841)" stroke-width="0.4036697247706422"><tspan dy="6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Frosted</tspan></text><text x="337.5" y="183.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 14px; line-height: normal; font-family: Arial;" font-size="14px" transform="matrix(2.2708,0,0,2.2708,-428.9063,-223.0313)" stroke-width="0.4403669724770642"><tspan dy="5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">40%</tspan></text></svg></div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- page end-->
          </section>
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2014 - Alvarez.is
              <a href="morris.html#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
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

    <!--script for this page-->
    <script src="assets/js/morris-conf.js"></script>
    
  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  

</body></html>