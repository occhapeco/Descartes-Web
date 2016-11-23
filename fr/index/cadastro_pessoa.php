<?php 
  require_once("permissao.php");
  require_once("../conectar_service.php");
  
  $alert = "";
  //Cadastro
  if (isset($_POST["cadastrar_pessoa"]))
  {
    // Cadastra o endereço e retorna seu id (0 se der bosta)
    if($_POST["senha"] == $_POST["senha1"])
    {
      $usuario = $service->call('usuario.insert', array($_POST["nome"],$_POST["email"],$_POST["senha"],$_POST["cpf"],$_POST["telefone"]));
      if ($usuario > 0)
      {
          session_start();
          $_SESSION["id"] = $usuario;
          $_SESSION["tabela"] = "usuario";
          header("location: ../pessoa/");
      }
      elseif ($usuario == -1)
        $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>CPF INVÁLIDO!</b></div>';
      elseif ($usuario == -2)
        $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>EMAIL JÁ UTILIZADO!</b></div>';
      elseif ($usuario == -3)
        $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>CPF JÁ CADASTRADO!</b></div>';
    }
    else
    {
      $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Les mots de passe ne correspondent pas!</b></div>';
    }
  }


?>
<html lang="fr">
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
            <h3><i class="fa fa-angle-right"></i> Registre</h3>
            <?php echo $alert; ?>
            <!-- BASIC FORM ELELEMNTS -->
            <div class="row mt">
              <div class="col-lg-12">
                  <div class="form-panel offset1">
                    <span style="color: red">*CHAMP NÉCESSAIRE</span><br>
                      <form class="form-horizontal style-form" method="post" action="#">
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">*Nom complet</label>
                              <div class="col-sm-10">
                                <input type="text" id="nome" name="nome" maxlength="30"  class="form-control" autofocus required>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">*CPF</label>
                              <div class="col-sm-10">
                                <input type="text" id="cpf" name="cpf" maxlength="11"  class="form-control" autofocus required>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">*Téléphone</label>
                              <div class="col-sm-10">
                                <input type="text" id="telefone" name="telefone" maxlength="25"  class="form-control" autofocus required>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">*Email</label>
                              <div class="col-sm-10">
                                <input type="email" id="email" name="email" maxlength="40"  class="form-control" autofocus required>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">*Mot de passe</label>
                              <div class="col-sm-10">
                                <input type="password" id="senha" name="senha" maxlength="12"  class="form-control" autofocus required>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">*Rédigez le mot de passe</label>
                              <div class="col-sm-10">
                                <input type="password" id="senha1" name="senha1" maxlength="12"  class="form-control" autofocus required>
                              </div>
                          </div>
                          <button type="submit" id="cadastrar_pessoa" name="cadastrar_pessoa" class="btn btn-sm btn-theme pull-right">Registre</button>
                          <a href="index.php" class="btn btn-sm btn-theme03 pull-right" id="oiem" style="margin-right: 10px;">Annuler</a><br><br>
                      </form>
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

  </body>
</html>
