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
      <h3><i class="fa fa-angle-right"></i> Meus Pedidos</h3>
      <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
                          <section id="no-more-tables">
                              <table class="table table-striped table-condensed cf ">
                                  <thead class="cf">
                                  <tr>
                                      <th class="date">Data</th>
                                      <th class="time">Horário</th>  
                                      <th>Endereço</th>  
									  <th>Coletadora</th>
                                      <th>Telefone</th>  
                                      <th>Status</th>
                                      <th><center>Cancelar</center></th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td data-title="Data">02/02/2002</td>
                                      <td data-title="Horário">15:30</td>
                                      <td data-title="Endereço">Centro</td>
									  <td data-title="Solicitante">Verde Vida</td>
									  <td data-title="Telefone">9999-9999</td>
									  <td data-title="E-mail">Aguardando Recolhimento</td>
									  <td data-title="Recusar"><center><button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button></center></td>
                                    </tr>
                                  </tbody>
                              </table>
                          </section>
                      </div><!-- /content-panel -->
                  </div><!-- /col-lg-12 -->
              </div><!-- /row -->

    </section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      </section><!-- container-->

		

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
