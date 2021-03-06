<?php 
  require_once("permissao_pessoa.php"); 

  require_once("../conectar_service.php");

 //Pegar informações de telefone e email;
  $input = "";
  $json_dados = $service->call('usuario.select',array("id = ".$_SESSION["id"]));
  $usuario = json_decode($json_dados);
  if(isset($_POST["agendar"]))
  {
    $input = '<input type="hidden" id="empresa_id" name="empresa_id" value="'. $_POST["empresa_id"] . '"><input type="hidden" id="ponto_id" name="ponto_id" value="'. $_POST["ponto_id"] . '">';
  }
  
  //Cadastrar Agendamentos
    
  elseif (isset($_POST["confirmar"]))
  {
    $data_agendamento = $_POST["data_agendamento"];
    $id_agendamento = $service->call('agendamento.insert',array($_POST["empresa_id"],$_SESSION["id"],$data_agendamento,$_POST["horario"],$_POST["endereco"]));
    if($id_agendamento!=0)
    {
      $tipo_lixo = $_POST["lixo"];
      for($i=0;$i<count($tipo_lixo);$i++)
      {
        // Como os nomes dos checkboxs são o id do tipo de lixo, é só ver se está checado
        $agendamento_has_tipo_lixo = $service->call('agendamento_has_tipo_lixo.insert', array($tipo_lixo[$i],$id_agendamento,$_POST["quantidade_lixo"]));
      }
      header("location:pedidos.php");
    }
  }
  else
  {
    header("location:index.php");
  }
   
?>
<html lang="fr">
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
          require_once("navtop.php");
      ?>
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT Formulário
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
          <section class="wrapper">
          <a href="enderecos.php" class="btn btn-sm btn-theme03 pull-right" id="oiem" style="margin-right: 10px; margin-top:15px;">Nouvelle adresse</a>
            <h3><i class="fa fa-angle-right"></i> Efetuar agendamento</h3>
            
            
            <!-- BASIC FORM ELELEMNTS -->
            <div class="row mt">
              <div class="col-lg-12">
                  <div class="form-panel offset1">
                    <p style="color: red; margin-left: 20px;">*CAMPO OBRIGATÓRIO</p>

                      <form class="form-horizontal style-form" method="post" action="#">
                          
                          <div class="form-group">
                              <label class="col-sm-2 control-label">*Data do recolhimento</label>
                              <div class="col-sm-10">
                                <input type="date" id="data_agendamento" name="data_agendamento" class="form-control" maxlength="10" value="" required autofocus placeholder="Entre a data do recolhimento">
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="col-sm-2 control-label">*Horário</label>
                              <div class="col-sm-10">
                                 <input type="text" id="horario" name="horario" class="form-control" maxlength="5" value="" placeholder="Entre a hora do recolhimento" required autofocus>
                               </div>
                          </div>

                          <div class="form-group">
                              <label class="col-sm-2 control-label">*Endereço para o recolhimento</label>
                              <div class="container">
                                
                                  <div class="form-group">
                                  <div class="col-sm-10">
                                    <select id="endereco" name="endereco" class="selectpicker" data-live-search="true" title="Selecione um endereço ...">
                                    <?php
                                      $json_dados = $service->call('usuario_has_endereco.select', array("usuario_id = " .$_SESSION["id"]));
                                      $endereco = json_decode($json_dados);
                                      for($i = 0; $i<count($endereco); $i++)
                                      {
                                        echo '<option value=' . $endereco[$i]->endereco_id . '>' . $endereco[$i]->nome . '</option>';
                                      }
                                    ?>
                                   </select>
                                   </div>
                                  </div>
                                
                              </div>

                              <div>
                                <label class="col-sm-2 control-label">* Tipo de lixo a ser recolhido</label>
                                <div class="col-sm-10">
                                   <select id="lixo" name="lixo[]" class="selectpicker" multiple data-done-button="false" title="Nada Selecionado">
                                      <?php
                                        $json_dados = $service->call('tipo_lixo_has_ponto.select_by_ponto',array($_POST["ponto_id"]));
                                        $tipo_lixo_has_ponto = json_decode($json_dados);
                                        for($i = 0; $i<count($tipo_lixo_has_ponto); $i++)
                                        {
                                          $json_dados = $service->call('tipo_lixo.select_by_id', array($tipo_lixo_has_ponto[$i]->tipo_lixo_id));
                                          $tipo_lixo = json_decode($json_dados);
                                          echo '<option value=' . $tipo_lixo[0]->id . '>'. $tipo_lixo[0]->nome .'</option>';
                                        }
                                      ?>
                                   </select>
                                </div>
                            </div>
                          
                          <div class="form-group"></div>
                          
                          <div>
                              <label class="col-sm-2 control-label">*Quantidade de lixo a ser recolhido</label>
                              <div class="col-sm-10">
                                  <input type="text" id="quantidade_lixo" name="quantidade_lixo" class="form-control" maxlength="20" value="" placeholder="Entre a quantidade de lixo a ser recolhido" required autofocus>
                                 <span class="help-block">Valor em kg</span>
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
//    $(document).ready(function() {
//        $('#example-getting-started').multiselect();
//    });

//    $('#basic2').selectpicker({
//      liveSearch: true,
//      maxOptions: 1
//    });

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

    $(function() {

    var $body = $(document);
    $body.bind('scroll', function() {
        // "Disable" the horizontal scroll.
        if ($body.scrollLeft() !== 0) {
            $body.scrollLeft(0);
        }
    });

}); 

   </script>
  </body>
</html>
