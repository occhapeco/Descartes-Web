<?php 
  require_once("permissao.php"); 
  $alert = '';
  // Tratando edições
  if(isset($_POST))
  {
    require_once("../conectar_service.php");
    if (isset($_POST["editar_perfil"]))
      if ($service->call('empresa.update_perfil',array($_SESSION["id"],$_POST["razao_social"],$_POST["nome_fantasia"],$_POST["email"],$_POST["agendamento"])))
        $alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Seu perfil foi alterado com sucesso!</b></div>';
      else
        $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Algo deu errado!</b> Cheque sua conexão e tente novamente.</div>';
    if (isset($_POST["editar_senha"]))
    {
       if($_POST["senha_nova1"] == $_POST["senha_nova2"])
       {
            if (($_POST["senha_nova1"] == $_POST["senha_nova2"]) && $service->call('empresa.update_senha',array($_SESSION["id"],$_POST["senha_antiga"],$_POST["senha_nova1"])))
              $alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Sua senha foi alterada com sucesso!</b></div>';
            else
              $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Algo deu errado!</b> Cheque sua conexão e tente novamente.</div>';
      }
       else
      $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Senhas não conferem!</b> Digite novamente.</div>';
    }
  }
?>
<html lang="pt">
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
	
  </head>

  <body>

  <section id="container" >
      
      <?php
          require_once("navtop.php");
      ?>
     
  
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT Formulário
      *********************************************************************************************************************************************************** -->
    <section class="wrapper">
    	<h3><i class="fa fa-angle-right"></i> Editar Perfil</h3>
    	<?php
        if($alert != '')
          echo "<br>".$alert;
      ?>
        <div class="form-panel col-lg-12">
          <div class="col-lg-5" style="padding-bottom: 35px;">
          	  <h4 class="mb"><i class="fa fa-angle-right"></i> Dados da Empresa</h4>
              <form class="form-horizontal style-form" method="POST" action="#">
                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Razão Social</label>
                      <div class="col-sm-10">
                      <?php
                        echo '<input type="text" id="razao_social" name="razao_social" class="form-control" maxlength="40" value="' . $empresa[0]->razao_social . '" required autofocus>';
                      ?>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Nome Fantasia</label>
                      <div class="col-sm-10">
                      <?php
                        echo '<input type="text" id="nome_fantasia" name="nome_fantasia" class="form-control" maxlength="40" value="' . $empresa[0]->nome_fantasia . '"required>';
                      ?>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">E-mail</label>
                      <div class="col-sm-10">
                      <?php
                        echo '<input type="text" id="email" name="email" class="form-control" maxlength="50" value="' . $empresa[0]->email . '" readonly required>';
                      ?>
                      </div>
                  </div>
                  <div class="form-group">
                    <?php 
                      $sim = "checked";
                      $nao = "";
                      if($empresa[0]->agendamento == 0)
                      {
                        $nao = "checked";
                        $sim = "";
                      }
                    ?>
                    <label class="col-sm-2 col-sm-2 control-label">*Aceitar agendamentos</label>
                    <div class="col-sm-10">
                      <div class="col-sm-2"></div>
                      <div class="col-sm-4">
                        <input type="radio" name="agendamento" id="agendamento" value="1" <?php echo $sim; ?>> Sim
                      </div>
                      <div class="col-sm-4">
                        <input type="radio" name="agendamento" id="agendamento" value="0" <?php echo $nao; ?>> Não
                      </div>
                    </div>
                  </div>
                  <button type="submit" id="editar_perfil" name="editar_perfil" class="btn btn-sm btn-theme pull-right">Confirmar</button>
              </form>
          </div>
      		<div class="col-lg-1"></div>
      	  <div class="col-lg-5" style="padding-bottom: 35px;">
        	  <h4 class="mb"><i class="fa fa-angle-right"></i> Alteração de Senha</h4>
            <form class="form-horizontal style-form" method="POST" action="#">
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Senha Atual</label>
                    <div class="col-sm-10">
                        <input type="password" id="senha_antiga" name="senha_antiga" class="form-control"  maxlength="12" required>
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
                <button type="submit" id="editar_senha" name="editar_senha" class="btn btn-sm btn-theme pull-right">Confirmar</button>
            </form>
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
    <script src="assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
  
  </body>
</html>
