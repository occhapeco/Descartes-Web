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
      MAIN CONTENT Formulário
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
        <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Endereços</h3>
          	
          	<!-- BASIC FORM ELELEMNTS -->
                     <div class="form-panel offset1" >
                        <form class="form-horizontal style-form" method="get">
                           <div class="panel-group" id="accordion">
						     <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                               <div class="panel panel-default">
                                 <div class="panel-heading">
                                  <h4 class="panel-title">
                                    Casa
                                  </h4></a>
                               </div>
							   <div id="collapse1" class="panel-collapse collapse">
								 <div class="panel-body">
									<div class="row mt">
                                      <div class="col-lg-12">
                                        <div class="content-panel">
                                         <section id="no-more-tables">
                                           <table class="table table-striped table-condensed cf" style="">
                                             <thead class="cf">
                                               <tr>
                                                 <th>Rua</th>
                                                 <th>Número</th>  
                                                 <th>Complemento</th>  
									             <th>CEP</th>
                                                 <th>Bairro</th>  
                                                 <th>UF</th>
												 <th>Cidade</th>
												 <th>País</th>
                                                 <th><center>Editar</center></th>
												 <th><center>Excluir</center></th>
                                               </tr>
                                             </thead>
                                             <tbody>
                                              <tr>
                                                <td data-title="Rua">Avenida</td>
                                                <td data-title="Número">15</td>
                                                <td data-title="Complemento">D</td>
									            <td data-title="CEP">89000000</td>
									            <td data-title="Bairro">Centro</td>
									            <td data-title="UF">SC</td>
									            <td data-title="Cidade">Chapecó</td>
									            <td data-title="País">Brasil</td>
									            <td data-title="Editar"><center><button type="button" class="btn btn-theme"><i class="fa fa-pencil"></i></button></center></td>
									            <td data-title="Excluir"><center><button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button></center></td>
                                              </tr>
                                             </tbody>
                                           </table>
                                         </section>
                                        </div><!-- /content-panel -->
                                      </div><!-- /col-lg-12 -->
									  </div><!-- /row -->
									 </div>
                                    </div>
								  </div>
							 
							 <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
							 <div class="panel panel-default">
                                 <div class="panel-heading">
                                  <h4 class="panel-title">
                                    Trabalho
                                  </h4></a>
                               </div>
							   <div id="collapse2" class="panel-collapse collapse">
								 <div class="panel-body">
									<div class="row mt">
                                      <div class="col-lg-12">
                                        <div class="content-panel">
                                         <section id="no-more-tables">
                                           <table class="table table-striped table-condensed cf" style="">
                                             <thead class="cf">
                                               <tr>
                                                 <th>Rua</th>
                                                 <th>Número</th>  
                                                 <th>Complemento</th>  
									             <th>CEP</th>
                                                 <th>Bairro</th>  
                                                 <th>UF</th>
												 <th>Cidade</th>
												 <th>País</th>
                                                 <th><center>Editar</center></th>
												 <th><center>Excluir</center></th>
                                               </tr>
                                             </thead>
                                             <tbody>
                                              <tr>
                                                <td data-title="Rua">Avenida</td>
                                                <td data-title="Número">15</td>
                                                <td data-title="Complemento">D</td>
									            <td data-title="CEP">89000000</td>
									            <td data-title="Bairro">Centro</td>
									            <td data-title="UF">SC</td>
									            <td data-title="Cidade">Chapecó</td>
									            <td data-title="País">Brasil</td>
									            <td data-title="Editar"><center><button type="button" class="btn btn-theme"><i class="fa fa-pencil"></i></button></center></td>
									            <td data-title="Excluir"><center><button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button></center></td>
                                              </tr>
                                             </tbody>
                                           </table>
                                         </section>
                                        </div><!-- /content-panel -->
                                      </div><!-- /col-lg-12 -->
									  </div><!-- /row -->
									 </div>
                                    </div>
								  </div>
							 
							<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
							 <div class="panel panel-default">
                                 <div class="panel-heading">
                                  <h4 class="panel-title">
                                    Escola
                                  </h4></a>
                               </div>
							   <div id="collapse3" class="panel-collapse collapse">
								 <div class="panel-body">
									<div class="row mt">
                                      <div class="col-lg-12">
                                        <div class="content-panel">
                                         <section id="no-more-tables">
                                           <table class="table table-striped table-condensed cf" style="">
                                             <thead class="cf">
                                               <tr>
                                                 <th>Rua</th>
                                                 <th>Número</th>  
                                                 <th>Complemento</th>  
									             <th>CEP</th>
                                                 <th>Bairro</th>  
                                                 <th>UF</th>
												 <th>Cidade</th>
												 <th>País</th>
                                                 <th><center>Editar</center></th>
												 <th><center>Excluir</center></th>
                                               </tr>
                                             </thead>
                                             <tbody>
                                              <tr>
                                                <td data-title="Rua">Avenida</td>
                                                <td data-title="Número">15</td>
                                                <td data-title="Complemento">D</td>
									            <td data-title="CEP">89000000</td>
									            <td data-title="Bairro">Centro</td>
									            <td data-title="UF">SC</td>
									            <td data-title="Cidade">Chapecó</td>
									            <td data-title="País">Brasil</td>
									            <td data-title="Editar"><center><button type="button" class="btn btn-theme"><i class="fa fa-pencil"></i></button></center></td>
									            <td data-title="Excluir"><center><button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button></center></td>
                                              </tr>
                                             </tbody>
                                           </table>
                                         </section>
                                        </div><!-- /content-panel -->
                                      </div><!-- /col-lg-12 -->
									  </div><!-- /row -->
									 </div>
                                    </div>
								  </div>
                      </form>
					  <br> 	
					  <a href="NovoEndereco.html" class="btn btn-sm btn-theme03 pull-right botao03">Adicionar Novo Endereço</a><br>
              	    </div>
				  
				  
				</div><!-- col-lg-12-->      	
          	</div><!-- /row -->
			</section>
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
