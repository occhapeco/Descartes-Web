<?php
    	if(isset($_POST['msg']))
    	{
    		$msg = $_POST['msg'];
    		$headers =  'MIME-Version: 1.0' . "\r\n"; 
			  $headers .= 'From: DescartesLab' . "\r\n";
    		mail('occhapecosenai@gmail.com', 'Adicionar tipo de lixo',$msg,$headers);
    	}
    ?>

<?php 
  require_once("permissao.php");

  $cep = "";
  $pais = "";
  $estado = "";
  $cidade = "";
  $bairro = "";
  $rua = "";
  $numero = "";
  $complemento = "";
  $atendimento_ini = 
  $atendimento_fim = "";
  $observacao =  "";
  $telefone =  "";
  $btn = '<a class="btn btn-sm btn-theme pull-right" style="margin-bottom:10px;" onclick="codeAddress();" id="cadastrar" name="cadastrar" style="margin-left:10px">Confirmar</a>';
  $input_id = "";
  $lat_long = "";
  $bab = '<input type="hidden" name="cadastrar">';

  // Puxando os dados a ser mostrados e editados
  if (isset($_POST["editar"]))
  {
    require_once("../conectar_service.php");
    $json_dados = $service->call('ponto.select_by_id',array($_POST["id"]));
    $ponto = json_decode($json_dados);
    $json_dados = $service->call('endereco.select_by_id',array($ponto[0]->endereco_id));
    $endereco = json_decode($json_dados);
    $cep = $endereco[0]->cep;
    $pais = $endereco[0]->pais;
    $estado = $endereco[0]->uf;
    $cidade = $endereco[0]->cidade;
    $bairro = $endereco[0]->bairro;
    $rua = $endereco[0]->rua;
    $numero = $endereco[0]->num;
    $complemento = $endereco[0]->complemento;
    $atendimento_ini = $ponto[0]->atendimento_ini;
    $atendimento_fim = $ponto[0]->atendimento_fim;
    $observacao = $ponto[0]->observacao;
    $telefone = $ponto[0]->telefone;
    $ponto_id = $_POST["id"];
    $input_id = "<input type='hidden' id='lat' name='lat' value=" . $endereco[0]->latitude . "><input type='hidden' id='long' name='long' value=" . $endereco[0]->longitude . "><input type='hidden' id='id' name='id' value=" . $_POST["id"] . "><input type='hidden' id='endereco_id' name='endereco_id' value=" . $ponto[0]->endereco_id . ">";
    $btn = '<button class="btn btn-sm btn-theme pull-right" type="submit" id="edit" name="edit" style="margin-left:10px;">Confirmar</button>';
    $bab = "";
  }
  
  //---------------------//
  //       Cadastro      //
  //---------------------//
  if (isset($_POST["cadastrar"]))
  {
    require_once("../conectar_service.php");
    // Cadastra o endereço e retorna seu id (0 se der bosta)
    $endereco_id = $service->call('endereco.insert',array($_POST["rua"],$_POST['num'],$_POST['complemento'],$_POST['cep'],$_POST['bairro'],$_POST['uf'],$_POST['cidade'],$_POST['pais'],$_POST['lat'],$_POST['long']));
    if ($endereco_id != 0)
    {
      // Cadastra o ponto e retorna seu id (0 se der bosta)
      $ponto_id = $service->call('ponto.insert',array($_SESSION['id'],$_POST["atendimento_ini"],$_POST["atendimento_fim"],$_POST["observacao"],$_POST["telefone"],$endereco_id));
      if ($ponto_id != 0)
      {
        // Seleciono todos os tipos de lixo
        $json_dados = $service->call('tipo_lixo.select',array(NULL));
        $tipo_lixo = json_decode($json_dados);
        for($i=0;$i<count($tipo_lixo);$i++)
          if (isset($_POST[$tipo_lixo[$i]->id])) // Como os nomes dos checkboxs são o id do tipo de lixo, é só ver se está checado
            $tipo_lixo_has_ponto_id = $service->call('tipo_lixo_has_ponto.insert',array($tipo_lixo[$i]->id,$ponto_id));
        header("location: mapa_pontos.php");
      }
      else
        echo "<script>alert('Erro 2!');</script>";
    }
    else
      echo "<script>alert('Erro 1!');</script>";
  }
 
  //---------------------//
  //        Editar       //
  //---------------------//
  if (isset($_POST["edit"]))
  {
    require_once("../conectar_service.php");
    // Atuaiza os dados do endereço e retorna booleano
    if ($service->call('endereco.update',array($_POST["endereco_id"],$_POST["rua"],$_POST['num'],$_POST['complemento'],$_POST['cep'],$_POST['bairro'],$_POST['uf'],$_POST['cidade'],$_POST['pais'],$_POST['lat'],$_POST['long'])))
    {
      // Atuaiza os dados do ponto e retorna booleano
      if ($service->call('ponto.update',array($_POST["id"],$_POST["atendimento_ini"],$_POST["atendimento_fim"],$_POST["observacao"],$_POST["telefone"])))
      {
      	$json_dados = $service->call('tipo_lixo_has_ponto.select_by_ponto',array($_POST["id"]));
      	$tipo_lixo_has_ponto = json_decode($json_dados);
      	for($i=0;$i<count($tipo_lixo_has_ponto);$i++)
      	{
      		if ($service->call('tipo_lixo_has_ponto.delete',array($tipo_lixo_has_ponto[$i]->id)))
      			echo "<script>alert('oie');</script>";
      	}
        // Seleciono todos os tipos de lixo
        $json_dados = $service->call('tipo_lixo.select',array(NULL));
        $tipo_lixo = json_decode($json_dados);
        for($i=0;$i<count($tipo_lixo);$i++)
          if (isset($_POST[$tipo_lixo[$i]->id])) // Como os nomes dos checkboxs são o id do tipo de lixo, é só ver se está checado
            $tipo_lixo_has_ponto_id = $service->call('tipo_lixo_has_ponto.insert',array($tipo_lixo[$i]->id,$_POST["id"]));
        header("location: mapa_pontos.php");
      }
      else
        echo "<script>alert('Erro 2!');</script>";
    }
    else
      echo "<script>alert('Erro 1!');</script>";
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

   <link rel="stylesheet" href="assets/css/bootstrap2.css">
    
    <script src="https://use.fontawesome.com/9c8fd2c64e.js"></script>

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/table-responsive.css" rel="stylesheet">
    
    <script src="assets/js/chart-master/Chart.js"></script>
    <script   src="https://code.jquery.com/jquery-3.1.0.js"   integrity="sha256-slogkvB1K3VOkzAI8QITxV3VzpOnkeNVsKvtkYLMjfk="   crossorigin="anonymous"></script> 
    <script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>

	
  </head>

  <body>

  <section id="container" >
      
      <?php
          require_once("topnav.php");
          require_once("sidenav.php");
      ?>
  
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT  Formulários de cadastro do ponto
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
      	<section class="wrapper">
        	<h3><i class="fa fa-angle-right"></i> Adicionar novo ponto</h3>
        	<form class="form-horizontal style-form" method="post" action="#" id="frm">
          <input type="hidden" name="lat" id="lat">
          <input type="hidden" name="long" id="long">
          <?php echo $bab; ?>
        	   <div class="row mt">
          		  <div class="col-lg-12">
          		<!-- Confirmação e Complemento do endereço do ponto -->
                	<div class="form-panel " id="endereco">
                   	<h4 class="mb"><i class="fa fa-angle-right"></i> Endereço</h4>
                    	<div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">CEP</label>
                            <div class="col-sm-10">
                               <input type="text" id="cep" name="cep" maxlength="10" onkeypress="formatar('##.###-###', this)" class="form-control" <?php echo "value='$cep'"; ?> autofocus placeholder="Ex: 89888000">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">*País</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" maxlength="20" id="pais" name="pais" <?php echo "value='$pais'"; ?> required placeholder="Ex: Brasil">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">*UF</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" maxlength="2" id="uf" name="uf"<?php echo "value='$estado'"; ?> required placeholder="Ex: SC">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">*Cidade</label>
                            <div class="col-sm-10">
                                <input id="cidade" type="text" class="form-control" maxlength="40" id="cidade" name="cidade"<?php echo "value='$cidade'"; ?> required placeholder="Ex: São Paulo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">*Bairro</label>
                            <div class="col-sm-10">
                                <input id="bairro" type="text" class="form-control" maxlength="40" id="bairro" name="bairro"<?php echo "value='$bairro'"; ?> required placeholder="Ex: Centro">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">*Rua</label>
                            <div class="col-sm-10">
                                <input id="rua" type="text" class="form-control" maxlength="40" id="rua" name="rua"<?php echo "value='$rua'"; ?> required placeholder="Ex: Rua das Margaridas.">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">*Número</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"  maxlength="6" id="num" name="num"<?php echo "value='$numero'"; ?> required placeholder="Ex: 402">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2  control-label ">Complemento</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control " maxlength="20" id="complemento" name="complemento" <?php echo "value='$complemento'"; ?> placeholder="Ex: D. Ou ponto de referência Ex: Próximo à escola">
                            </div>
                        </div>
                    *CAMPO REQUERIDO <a class="btn btn-sm btn-theme pull-right" id="oiem">Próximo</a><br><br>
                  </div>
                    
                    <!-- Dados do funcionamento do Ponto -->    
                        <div class="form-panel  abc" id="info">
		                  	  <h4 class="mb"><i class="fa fa-angle-right"></i> Dados do Ponto</h4>
		                  	   <div class="form-group">
		                           <label class="col-sm-2 col-sm-2 control-label">*Horário de início do atendimento</label>
		                            <div class="col-sm-10">
		                                <input type="time" class="form-control" maxlength="12" OnKeyPress="formatar('##:##', this,event)"  id="atendimento_ini" name="atendimento_ini" <?php echo "value='$atendimento_ini'";?> required>
		                            </div>
		                        </div>
		                        <div class="form-group">
		                           <label class="col-sm-2 col-sm-2 control-label">*Horário de final do atendimento</label>
		                            <div class="col-sm-10">
		                                <input type="time" class="form-control" maxlength="12" OnKeyPress="formatar('##:##', this,event)"  id="atendimento_fim" name="atendimento_fim"<?php echo "value='$atendimento_fim'";?> required>
		                            </div>
		                        </div>
		                        <div class="form-group">
		                              <label class="col-sm-2 col-sm-2 control-label">*Telefone</label>
		                              <div class="col-sm-10">
									                  <input type="text" maxlength="13" onkeypress="formatar('## ####-####', this)" class="form-control" id="telefone" name="telefone" <?php echo "value='$telefone'";?> required placeholder="Ex: 44 4444 4444">
		                              </div>
		                          </div>
		                        <div class="form-group">
		                           <label class="col-sm-2 col-sm-2 control-label">Observações</label>
		                            <div class="col-sm-10">
		                                <textarea class="form-control" maxlength="250" id="observacao" name="observacao" placeholder="Ex: Fecha ao meio dia etc."><?php
		                                 echo $observacao; ?></textarea>
		                            </div>
		                        </div>
                            *CAMPO REQUERIDO<a class="btn btn-sm btn-theme pull-right" id="oiem2" style="margin-left:10px;">Próximo</a>
                            <a class="btn btn-sm btn-theme03 pull-right" id="oiem1">Voltar</a><br><br>
  					         </div>

                     <!-- Tipos de lixo recolhidos pelo Ponto -->    
                        <div class="form-panel  abc" id="lixo">
                          <h4 class="mb"><i class="fa fa-angle-right"></i> Materiais Recolhidos</h4>
                          <h5 class="mb"><i class="fa fa-angle-right"></i> Selecione quais dos materiais a baixo este ponto recolhe</h5>
                           <div class="form-group">
                             
                              <table class="table table-striped col-md-8">
                                  <?php
	                                   $json_dados = $service->call('tipo_lixo.select',array(NULL));
	                                   $tipo_lixo = json_decode($json_dados);
	                                   for($i=0;$i<count($tipo_lixo);$i++)
	                                    {
	                                      if($i==0)
	                                      {
	                                          echo '<tr>';
	                                      }
	                                      elseif (($i%2)==0) 
	                                      {
	                                          echo "</tr><tr>";
	                                      }
	                                      echo '
	                                              <td>
	                                              <center> 
	                                              ' . $tipo_lixo[$i]->nome . '
	                                              </center>
	                                              </td>
	                                              <td><center>

	                                                <input type="checkbox" id="' . $tipo_lixo[$i]->id . '" name="' . $tipo_lixo[$i]->id . '" style="height:20px; width:20px;"';
	                                              if (isset($ponto_id))
	                                              {
	                                              	$json_dados = $service->call('tipo_lixo_has_ponto.select',array("ponto_id = $ponto_id AND tipo_lixo_id = " . $tipo_lixo[$i]->id));
				                                   	$tipo_lixo_has_ponto = json_decode($json_dados);
				                                  	if (count($tipo_lixo_has_ponto) == 0)
			                                   		{
			                                   			echo ' unchecked></center></td>';
			                                   		}
                                                	else
                                                	{
                                                		echo ' checked></center></td>'; 
                                                	}
	                                              }
	                                              else
	                                              	echo ' unchecked></center></td>';
                                        }	                                  
                                  ?>
                              </table>
                          
                            </div>
                            <div class="">
                          <div class="">
						  <a type="" href="#" class="btn btn-md" id="pop">Não achou o que queria?</a>

                            <?php
                              echo $lat_long;
                              echo $input_id;
                              echo $btn; 
                            ?>
                            <a type="button" class="btn btn-sm btn-theme03 pull-right" id="oiem3" style="margin-right:10px;">Voltar</a>
                        </div>
                     </div>
                     </div>

                  </div>
              </div>
           </form>
        </section>
      </section>
    </section>
	
    <script src="assets/js/jquery.js"></script>
 
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmWPAIE9_AASg6Ijgoh0lVOZZ_VWvw6fg&libraries=places"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
	
    <script type="application/javascript">

  var geocoder = new google.maps.Geocoder();

    function codeAddress() {
    var address = document.getElementById( 'cidade' ).value+', '+document.getElementById( 'uf' ).value+ ', '+ document.getElementById( 'rua' ).value+' '+ document.getElementById( 'num' ).value;
    geocoder.geocode( { 'address' : address }, function( results, status ) {
        if( status == google.maps.GeocoderStatus.OK ) {
            document.getElementById( 'lat' ).value = results[0].geometry.location.lat();
            document.getElementById( 'long' ).value = results[0].geometry.location.lng();
            alert('batatóvski')
            document.getElementById('frm').submit();
        } else {
            alert( 'Não podemos encontrar sua localização corretamente, por favor, reveja os dados.');
        }
    } );
  }

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
    
    $("#oiem").click(function(){
      if (document.getElementById("pais").value.length < 1|| document.getElementById("uf").value.length < 1|| document.getElementById("bairro").value.length < 1|| document.getElementById("cidade").value.length < 1|| document.getElementById("rua").value.length < 1||document.getElementById("num").value.length < 1) {
        alert("Por favor, preencha todos os campos antes de continuar.");
      }
      else
      {
        $("#endereco").toggle(1000);
        $("#info").toggle(1000);
      }      
    });

    $("#oiem1").click(function(){
      $("#info").toggle(1000);
      $("#endereco").toggle(1000);
    });

    $("#oiem2").click(function(){
        if (document.getElementById("atendimento_ini").value.length < 1||document.getElementById("atendimento_fim").value.length < 1||document.getElementById("telefone").value.length < 1) {
        alert("Por favor, preencha todos os campos antes de continuar.");
      }else{
      $("#info").toggle(1000);
      $("#lixo").toggle(1000);
    }
    });

    $("#oiem3").click(function(){
      $("#lixo").toggle(1000);
      $("#info").toggle(1000);
    });

    $(document).ready(function(){
      $(".abc").hide();
    });

      
    $(document).ready(function(){
      $('#pop').popover({title: "<h5>Mande sua sugestão!</h5>", content: "<form method='post' action='#'><input type='text' class='form-control' id='msg' name='msg'><br><input type='submit' class='btn btn-sm btn-default btn-round'></form>", html: true, placement: "right"});
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