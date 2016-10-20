<?php 
  require_once("permissao_pessoa.php"); 
  $alert='';

  // Tratando edições
  if(isset($_POST))
  {
    require_once("../conectar_service.php");
    if (isset($_POST["editar_perfil"]))
      if ($service->call('usuario.update_perfil',array($_SESSION["id"],$_POST["nome"],$_POST["email"],$_POST["telefone"])))
        $alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Seu perfil foi alterado com sucesso!</b></div>';
      else
        $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Algo deu errado!</b> Cheque sua conexão e tente novamente.</div>';
    if (isset($_POST["editar_senha"]))
    {
      if ($_POST["senha_nova1"] == $_POST["senha_nova2"] && $service->call('usuario.update_senha',array($_SESSION["id"],$_POST["senha_antiga"],$_POST["senha_nova1"])))
        $alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Sua senha foi alterada com sucesso!</b></div>';
      else
        $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Algo deu errado!</b> Cheque sua conexão e tente novamente.</div>';
    }
    else
      $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Senhas não conferem!</b> Digite novamente.</div>';
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

  </head>

  <body>

  <section id="container" >
     
     <?php 
          require_once("navtop.php");
      ?>
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT Formulário
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
  <section class="wrapper">
  	<h3><i class="fa fa-angle-right"></i> Editar Perfil</h3>
  	<?php
      if($alert != '')
        echo "<br>".$alert;
    ?>
  	<!-- BASIC FORM ELELEMNTS -->
  		<div class="col-lg-12">
          <div class="form-panel col-lg-5" style="padding-bottom: 35px;">
          	  <h4 class="mb"><i class="fa fa-angle-right"></i> Dados Pessoais</h4>
              <form class="form-horizontal style-form" method="post" action="#">
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Nome Completo</label>
                    <div class="col-sm-10">
                        <?php
                          echo '<input type="text" id="nome" name="nome" class="form-control" maxlength="30" value="' . $usuario[0]->nome . '" required autofocus>';
                        ?>
	                  </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Telefone</label>
                    <div class="col-sm-10">
  						        <?php
                        echo '<input type="text" id="telefone" name="telefone" class="form-control" maxlength="13" value="' . $usuario[0]->telefone . '" required onkeypress="formatar("## ####-####", this)">';
                      ?>
                    </div>
                </div>

		            <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">E-mail</label>
                  <div class="col-sm-10">
                      <?php
                        echo '<input type="text" id="email" name="email" class="form-control" maxlength="40" value="' . $usuario[0]->email . '" disabled required>';
                  ?>
                  </div>
                </div>
			            <button type="submit" name="editar_perfil" id="editar_perfil" class="btn btn-sm btn-theme pull-right">Confirmar</button>		
              </form>
          </div>
				  <div class="col-lg-1"></div>
				  <div class="form-panel col-lg-5" style="padding-bottom: 35px;">
        	  <h4 class="mb"><i class="fa fa-angle-right"></i> Alteração de Senha</h4>
            <form class="form-horizontal style-form" method="post" action="#">
              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Senha Atual</label>
                  <div class="col-sm-10">
                      <input type="password" id="senha_antiga" name="senha_antiga" class="form-control" maxlength="12" required>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Nova Senha</label>
                  <div class="col-sm-10">
                      <input type="password" id="senha_nova1" name="senha_nova1" class="form-control" maxlength="12" required>
                  </div>
              </div>
					    <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Confirmação da Nova Senha</label>
                <div class="col-sm-10">
                    <input type="password" id="senha_nova2" name="senha_nova2" class="form-control" maxlength="12" required>
                </div>
              </div>
              <button type="submit" name="editar_senha" id="editar_senha" class="btn btn-sm btn-theme pull-right">Confirmar</button>
            </form>
    	    </div>
				</div><!-- col-lg-12-->      	
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
    
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>    
	<script src="assets/js/zabuto_calendar.js"></script>	
	
	<script>

     function formatar(mascara, documento){
	     var i = documento.value.length;
	     var saida = mascara.substring(0,1);
	     var texto = mascara.substring(i);
		 var tecla=(window.event);

		if(tecla!=8){
			 if (texto.substring(0,1) != saida){
					documento.value += texto.substring(0,1);
			 }
		}
	}
   </script>
  </body>
</html>
