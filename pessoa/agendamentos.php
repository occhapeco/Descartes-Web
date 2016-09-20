<?php 
  require_once("permissao_pessoa.php"); 

  require_once("../conectar_service.php");

 //Pegar informações de telefone e email;
  $json_dados = $service->call('usuario.select',array("id = ".$_SESSION["id"]));
  $usuario = json_decode($json_dados);
  if(isset($_POST["agendar"]))
  {
    $input = '<input type="hidden" id="ponto" name="ponto" value="'. $_POST["id_ponto"] . '">';
  }
  
  //Cadastrar Agendamentos
    
  elseif (isset($_POST["confirmar"]))
  {
    $json_dados = $service->call('agendamento.insert',array($_POST["ponto"],$_SESSION["id"],$_POST["data_agendamento"],$_POST["horario"],0,0));
    $id_agendamento = json_decode($json_dados);
    if($id_agendamento!=0)
    {
      $json_dados = $service->call('tipo_lixo.select',array(NULL));
      $tipo_lixo = json_decode($json_dados);
      for($i=0;$i<count($tipo_lixo);$i++)
      {
        if(isset($_POST[$tipo_lixo[$i]->id]))
        { // Como os nomes dos checkboxs são o id do tipo de lixo, é só ver se está checado
          $agendamento_has_tipo_lixo = $service->call('agendamento_has_tipo_lixo.insert', array($id_agendamento, $_POST[$tipo_lixo[$i]->id], $_POST["quantidade_lixo"]));
          echo "<script>alert('Agendamento efetuado com sucesso');</script>";
        }
      }
    }
  }
  else
  {
    header("location:index.php");
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

    <title>Descartes</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->    
   
    <script src="https://use.fontawesome.com/9c8fd2c64e.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/bootstrap-select.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="dist/js/bootstrap-select.js"></script>
 
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
          	<h3><i class="fa fa-angle-right"></i> Efetuar Agendamento</h3>
          	
          	<!-- BASIC FORM ELELEMNTS -->
          	<div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel offset1">
                      <form class="form-horizontal style-form" method="post" action="#">
                          
                          <div class="form-group">
                              <label class="col-sm-2 control-label">Data do Recolhimento</label>
                              <div class="col-sm-10">
                                <input type="text" id="data_agendamento" name="data_agendamento" class="form-control" maxlength="10" value="" onkeypress="formatar("##/##/####", this)" required autofocus>
						                  </div>
                          </div>

                          <div class="form-group">
                              <label class="col-sm-2 control-label">Horário</label>
                              <div class="col-sm-10">
                                 <input type="text" id="horario" name="horario" class="form-control" maxlength="5" value="" onkeypress="formatar("##: ##", this)" required autofocus>
					                     </div>
                          </div>

						              <div class="form-group">
                              <label class="col-sm-2 control-label">Endereço para o Recolhimento</label>
                              <div class="container">
                                <form class="form-inline">
                                  <div class="form-group">
                                  <div class="col-sm-10">
                                    <select id="lunch" class="selectpicker" data-live-search="true" title="Escolha um endereço ...">
                                    <?php
                                      $json_dados = $service->call('usuario_has_endereco.select', array("usuario_id = " .$_SESSION["id"]));
                                      $endereco = json_decode($json_dados);
                                      for($i = 0; $i<count($endereco); $i++)
                                      {
                                        echo '<option>' . $endereco[$i]->nome . '</option>';
                                      }
                                    ?>
                                   </select>
                                   </div>
                                  </div>
                                </form>
                              </div>

                              <div>
                              <label class="col-sm-2 control-label">Tipo de Lixo a ser Recolhido</label>
                              <div class="col-sm-10">
                                 <select id="done" class="selectpicker" multiple data-done-button="true">
                                    <?php
                                      $json_dados = $service->call('tipo_lixo_has_ponto.select_by_ponto',array($_POST["id_ponto"]));
                                      $tipo_lixo_has_ponto = json_decode($json_dados);
                                      for($i = 0; $i<count($tipo_lixo_has_ponto); $i++)
                                      {
                                        $json_dados = $service->call('tipo_lixo.select_by_id', array($tipo_lixo_has_ponto[$i]->tipo_lixo_id));
                                        $tipo_lixo = json_decode($json_dados);
                                        echo '<option>'. $tipo_lixo[0]->nome .'</option>';
                                      }
                                    ?>
                                 </select>
                              </div>
                          </div>
                          
                          <div class="form-group"></div>
                          
                          <div>
                              <label class="col-sm-2 control-label">Quantidade de lixo a ser Recolhida</label>
                              <div class="col-sm-10">
                                  <input type="text" id="quantidade_lixo" name="quantidade_lixo" class="form-control" maxlength="20" value="" required autofocus>
                                 <span class="help-block">Valor em Kg</span>
                               </div>
                          </div>

                          <div class="form-group"></div>
                          
                          <div>
                              <label class="col-sm-2 control-label">Telefone para Contato</label>
                              <div class="col-sm-10">
                                 <?php
                                    echo '<input type="text" id="telefone" name="telefone" class="form-control" maxlength="13" value="' . $usuario[0]->telefone . '" required autofocus onkeypress="formatar("## ####-####", this)">';
                                 ?>
                               </div>
                          </div>

                          <div class="form-group"></div>

                          <div>
                              <label class="col-sm-2 control-label">E-mail</label>
                              <div class="col-sm-10">
                                 <?php
                                    echo '<input type="text" id="email" name="email" class="form-control" maxlength="13" value="' . $usuario[0]->email . '" required autofocus>';
                                 ?>
                               </div>
                          </div>
                       
                                        
                          </div>
                          <button type="submit" name="confirmar" id="confirmar" class="btn btn-sm btn-theme pull-right">Confirmar</button>    
                        <a href="pedidos.php" class="btn btn-sm btn-theme03 pull-right" id="oiem" style="margin-right: 10px;">Cancelar</a><br><br>    
                         
                          <?php
                          echo $input;
                        ?>

                          

                          
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
    $(document).ready(function() {
        $('#example-getting-started').multiselect();
    });

     $(document).ready(function () {
    var mySelect = $('#first-disabled2');
    });

    $('#special').on('click', function () {
      mySelect.find('option:selected').prop('disabled', true);
      mySelect.selectpicker('refresh');
    });

    $('#special2').on('click', function () {
      mySelect.find('option:disabled').prop('disabled', false);
      mySelect.selectpicker('refresh');
    });

    $('#basic2').selectpicker({
      liveSearch: true,
      maxOptions: 1
    });

   </script>
  </body>
</html>
