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
          	<h3><i class="fa fa-angle-right"></i> Editar Perfil</h3>
          	
          	<!-- BASIC FORM ELELEMNTS -->
          	<div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel offset1">
                  	  <h4 class="mb"><i class="fa fa-angle-right"></i> Dados Pessoais</h4>
                      <form class="form-horizontal style-form" method="get">
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Nome Completo</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" maxlength="30">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Telefone</label>
                              <div class="col-sm-10">
							                   <input id='o' type="text" name="tel" maxlength="13" onkeypress="formatar('## ####-####', this)" class="form-control">
                              </div>
                          </div>
						              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">E-mail</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" maxlength="40">
                              </div>
                          </div>
                      </form>
              	         <a href="indexPessoa.html"><button class="btn btn-sm btn-theme pull-right">Confirmar</button></a>
              	         <button class="btn btn-sm btn-theme03 pull-right" id="oiem" style="margin-right: 10px;">Editar Senha</button><br><br>
                  </div>
				  
					
				  <div class="form-panel offset1 abc" >
                  	  <h4 class="mb"><i class="fa fa-angle-right"></i> Alteração de Senha</h4>
                      <form class="form-horizontal style-form" method="get">
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Senha Atual</label>
                              <div class="col-sm-10">
                                  <input type="password" class="form-control" maxlength="12">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Nova Senha</label>
                              <div class="col-sm-10">
                                  <input type="password" class="form-control" maxlength="12">
                              </div>
                          </div>
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Confirmação da Nova Senha</label>
                              <div class="col-sm-10">
                                  <input type="password" class="form-control" maxlength="12">
                              </div>
                          </div>
                      </form>
					  <button class="btn btn-sm btn-theme pull-right" id="oiem1">Confirmar</button><br><br>
              	    </div>
				</div><!-- col-lg-12-->      	
          	</div><!-- /row -->
			</section><! --/wrapper -->
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
    
    $("#oiem").click(function(){
      $(".offset1").toggle(1000);
    });
    $("#oiem1").click(function(){
      $(".offset1").toggle(1000);
    });

    $(document).ready(function(){
      $(".abc").hide();
    });
    </script>
	
	<script>
     function formatar(mascara, documento){
     var i = documento.value.length;
     var saida = mascara.substring(0,1);
     var texto = mascara.substring(i);
	 var tecla=(window.event)?event.keyCode:e.which;

//	if(tecla!=8){
		 if (texto.substring(0,1) != saida){
				documento.value += texto.substring(0,1);
		 }
//	}
  
    }
   </script>
  </body>
</html>
