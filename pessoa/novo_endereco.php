<?php 
  require_once("permissao_pessoa.php"); 
  require_once("../conectar_service.php");
  $alert='';

  // Tratando edições
  if(isset($_POST["edit"]))
  {
    if ($service->call('endereco.update',array($_POST["id"],$_POST["rua"],$_POST["num"],$_POST["complemento"],$_POST["cep"],$_POST["bairro"],$_POST["uf"],$_POST["cidade"],$_POST["pais"],$_POST["lat"],$_POST["long"])))
    {
      header("location: enderecos.php");
      $alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Sua endereço foi alterado com sucesso!</b></div>';
   }
    else
      $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Algo deu errado!</b> Cheque sua conexão e tente novamente.</div>';
  }

   $id_input = "";
   $rua = "";
   $num = "";
   $complemento = "";
   $cep = "";
   $bairro = "";
   $uf = "";
   $cidade = "";
   $pais = "";
   $nome_endereco = "";
   $btn = '<a onclick="codeAddress();" id="cadastrar" name="cadastrar" class="btn btn-sm btn-theme pull-right">Confirmar</a>';

  if(isset($_POST["editar"]))
  {
    $id = $_POST["id"];
    $json_dados = $service->call('endereco.select_by_id',array($id));
    $endereco = json_decode($json_dados);
    $rua = $endereco[0]->rua;
    $num = $endereco[0]->num;
    $complemento = $endereco[0]->complemento;
    $cep = $endereco[0]->cep;
    $bairro = $endereco[0]->bairro;
    $uf = $endereco[0]->uf;
    $cidade = $endereco[0]->cidade;
    $pais = $endereco[0]->pais;

    $id_input = "<input type='hidden' id='id' name='id' value=" . $id . ">";
    $btn = ' <a href="enderecos.php"><button type="submit" id="edit" name="edit" class="btn btn-sm btn-theme pull-right">Confirmar</button></a>';

    $json_dados = $service->call('usuario_has_endereco.select', array("endereco_id = " . $endereco[0]->id));
    $endereco_usu = json_decode($json_dados);
    $nome_endereco = $endereco_usu [0]->nome;
  }

  //Cadastro
  //É verificado se há o post de nome_endereco1, pois se estiver editando o nome deste campo é nome_endreco e se está em cadastro o nome é nome_endereco1, sendo um post que só vai existir caso a ação seja de cadastro.
  if (isset($_POST["nome_endereco1"]))
  {
    // Cadastra o endereço e retorna seu id (0 se der bosta)
    $endereco_id = $service->call('endereco.insert',array($_POST["rua"],$_POST['num'],$_POST['complemento'],$_POST['cep'],$_POST['bairro'],$_POST['uf'],$_POST['cidade'],$_POST['pais'],$_POST['lat'],$_POST['long']));
    if($endereco_id != 0)
    {
      $endereco_has_usuario = $service -> call('usuario_has_endereco.insert', array($_SESSION["id"], $endereco_id, $_POST["nome_endereco1"]));
      $alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Endereço inserido com sucesso!</b></div>';
      header("location: enderecos.php");
    }
    else
    {
      $deletar = $service->call('endereco.delete', array("id = " . $endereco_id));
      $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Algo deu errado!</b> Cheque sua conexão e tente novamente.</div>';
    }
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
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Novo Endereço</h3>
            <?php
              if($alert != '')
                echo "<br>".$alert;
            ?>
          	
          	<!-- BASIC FORM ELELEMNTS -->
          	<div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel offset1">
                      <form class="form-horizontal style-form" method="post" action="#" id="form_sub">
                          <?php echo $id_input; ?>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">*Nome do Endereço</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control " maxlength="20" id="nome_endereco" placeholder="Atribua um nome a este endereço para acha-lo mais facilmente" <?php echo "value='$nome_endereco'"; 
                                      if(isset($_POST["editar"]))
                                        echo 'disabled name="nome_endereco"';
                                      else
                                        echo 'name="nome_endereco1"';
                                      ?>
                                  autofocus required>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">*CEP</label>
                              <div class="col-sm-10">
                                <input type="text" id="cep" name="cep" maxlength="10" onkeypress="formatar('##.###-###', this,event)" class="form-control" placeholder="Informe o CEP deste endereço" <?php echo "value='$cep'"; ?> required>
                              </div>
                          </div>
						              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">*País</label>
                              <div class="col-sm-10">
                                 <input type="text" class="form-control" maxlength="20" id="pais" name="pais" placeholder="Informe o país" <?php echo "value='$pais'"; ?> required>
                              </div>
                          </div>
						              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">*UF</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" maxlength="2" id="uf" name="uf"  placeholder="Informe o estado" <?php echo "value='$uf'";?> required>
                              </div>
                          </div>
						              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">*Cidade</label>
                              <div class="col-sm-10">
                                  <input id="cidade" type="text" class="form-control" maxlength="40" id="cidade" name="cidade" placeholder="Informe a cidade" <?php echo "value='$cidade'"; ?> required>
                              </div>
                          </div>
						              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">*Bairro</label>
                              <div class="col-sm-10">
                                <input id="bairro" type="text" class="form-control" maxlength="40" id="bairro" name="bairro" placeholder="Informe o bairro" <?php echo "value='$bairro'"; ?> required>
                              </div>
                          </div>
						              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">*Rua</label>
                              <div class="col-sm-10">
                                <input id="rua" type="text" class="form-control" maxlength="40" id="rua" name="rua" placeholder="Informe a rua" <?php echo "value='$rua'"; ?> required>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">*Número</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" onkeypress="return numbro(event)" onload="return numbro(event)" maxlength="6" id="num" name="num" placeholder="Informe o número do endereço" <?php echo "value='$num'"; ?> required>
                              </div>
                          </div>
						              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Complemento</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control " maxlength="20" id="complemento" name="complemento" placeholder="Informe o complemento do endereço" <?php echo "value='$complemento'"; ?>>
                              </div>
                          </div>
                           <span class="help-block">*CAMPO REQUERIDO.</span> 
                          <?php
                            echo $btn;
                          ?>
                          <a href="enderecos.php" class="btn btn-sm btn-theme03 pull-right" id="oiem" style="margin-right: 10px;">Cancelar</a><br><br>
                          <input type="hidden" name="lat" id="lat">
                           <input type="hidden" name="long" id="long">
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
    
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>    
	<script src="assets/js/zabuto_calendar.js"></script>	
	
	<script type="text/javascript">
        $(document).ready(function () {
        var unique_id = $.gritter.add({
            // (string | mandatory) the heading of the notification
            //title: 'Welcome to Dashgum!',
            // (string | mandatory) the text inside the notification
            //text: 'Hover me to enable the Close Button. You can hide the left sidebar clicking on the button next to the logo. Free version for <a href="http://blacktie.co" target="_blank" style="color:#ffd777">BlackTie.co</a>.',
            // (string | optional) the image to display on the left
            image: 'assets/img/ui-sam.jpg',
            // (bool | optional) if you want it to fade out on its own or just sit there
            sticky: true,
            // (int | optional) the time you want it to be alive for before fading out
            time: '',
            // (string | optional) the class name you want to apply to that specific message
            class_name: 'my-sticky-class'
        });

        return false;
        });
		
		function numbro(e){
			var tecla=(window.event)?event.keyCode:e.which;
			if((tecla>47)&&(tecla<58)) return true;
			else{
				if((tecla==8)||(tecla==0)) return true;
				else return false;
			}
		}
	</script>
	
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
  
   <script>
     function formatar(mascara, documento,e){
     var i = documento.value.length;
     var saida = mascara.substring(0,1);
     var texto = mascara.substring(i);
	 var tecla=(window.event)?event.keyCode:e.which;

	if(tecla!=8){
		 if (texto.substring(0,1) != saida){
				documento.value += texto.substring(0,1);
		 }
	}
  
    }
	</script>
	   
	   
	<script type="text/javascript" >
  var geocoder = new google.maps.Geocoder();

  function codeAddress() {
    var address = document.getElementById( 'cidade' ).value+', '+document.getElementById( 'uf' ).value+ ', '+ document.getElementById( 'rua' ).value+' '+ document.getElementById( 'num' ).value;
    geocoder.geocode( { 'address' : address }, function( results, status ) {
        if( status == google.maps.GeocoderStatus.OK ) {
            document.getElementById( 'lat' ).value = results[0].geometry.location.lat();
            document.getElementById( 'long' ).value = results[0].geometry.location.lng();
            document.getElementById( 'form_sub' ).submit();
        } else {
            alert( 'Não podemos encontrar sua localização corretamente, por favor, reveja os dados.');
        }
    } );
  }
//    CEP
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    </script>

    
  </body>
</html>
