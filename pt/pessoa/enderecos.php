<?php 
  require_once("permissao_pessoa.php"); 
  require_once("../conectar_service.php");
  $alert='';

  if(isset($_POST["excluir"]))
  {
    if($service->call('endereco.delete',array($_POST["id"])))
        $alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Endereço deletado com sucesso!</b></div>';
    else
      $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Algo deu errado!</b> Cheque sua conexão e tente novamente.</div>';
  }
  elseif(isset($_POST["edit"]))
  {
    if ($service->call('endereco.update',array($_POST["id"],$_POST["rua"],$_POST["num"],$_POST["complemento"],$_POST["cep"],$_POST["bairro"],$_POST["uf"],$_POST["cidade"],$_POST["pais"],$_POST["lat"],$_POST["long"])))
    {
      header("location: enderecos.php");
      $alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Seu endereço foi alterado com sucesso!</b></div>';
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
   $active = "home";
   $disabled = ' data-toggle="pill"';
   $ativo = '';
   $btn = '<a onclick="codeAddress();" id="cadastrar" name="cadastrar" class="btn btn-sm btn-theme pull-right" style="margin-right:10px;">Confirmar</a><br><br>';

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
    $active = "menu1";
    $disabled = "";
    $ativo = ' disabled';

    $id_input = "<input type='hidden' id='id' name='id' value=" . $id . ">";
    $btn = ' <a href="enderecos.php"><button type="submit" id="edit" name="edit" class="btn btn-sm btn-theme pull-right" style="10px;">Confirmar</button></a><br><br>';

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
      <h3><i class="fa fa-angle-right"></i> Endereços</h3>
      <?php
        if($alert != '')
          echo "<br>".$alert;
      ?>
      <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
            <ul class="nav nav-tabs" style="margin-left: 20px;">
              <li class="<?php if($active == "home") echo ' active'; echo $ativo; ?>"><a <?php echo $disabled; ?> href="#home" style="color: #797979;">Ver todos</a></li>
              <li <?php if($active == "menu1") echo ' class="active"'; ?>><a data-toggle="pill" href="#menu1" style="color: #797979;">Criar novo</a></li>
            </ul>
          <div class="tab-content">
            <div id="home" class="tab-pane fade <?php if($active == "home") echo 'in active'; ?>">
              <div class="form-panel offset1" >
                
              <div class="panel-group" id="accordion">
                
              <?php
                $json_dados = $service->call('usuario_has_endereco.select',array("usuario_id = " . $_SESSION["id"]));
                $endereco_usu = json_decode($json_dados);
                if(count($endereco_usu)>0)
                 {
                  for($i = 0; $i<count($endereco_usu);$i++) 
                  {
                    $endereco_id = $endereco_usu[$i]->endereco_id;
                    $json_dados = $service->call('endereco.select_by_id',array($endereco_id));
                    $endereco = json_decode($json_dados);
                 ?>
                   <a data-toggle="collapse" data-parent="#accordion" <?php echo "href='#id_". $endereco_usu[$i]->endereco_id."'"; ?> >
                     <div class="panel panel-default">
                       <div class="panel-heading">
                        <h4 class="panel-title">
                          <?php echo $endereco_usu[$i]->nome; ?>
                        </h4></div></div></a>
                     
    							   <div class="panel-collapse collapse" id='id_<?php echo $endereco_usu[$i]->endereco_id; ?>' >
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
                                      <td data-title="Rua"><?php echo $endereco[0]->rua; ?></td>
                                      <td data-title="Número"><?php echo $endereco[0]->num; ?></td>
                                      <td data-title="Complemento"><?php echo $endereco[0]->complemento; ?></td>
        									            <td data-title="CEP"><?php echo $endereco[0]->cep; ?></td>
        									            <td data-title="Bairro"><?php echo $endereco[0]->bairro; ?></td>
        									            <td data-title="UF"><?php echo $endereco[0]->uf; ?></td>
        									            <td data-title="Cidade"><?php echo $endereco[0]->cidade; ?></td>
        									            <td data-title="País"><?php echo $endereco[0]->pais; ?></td>
        									            <td data-title="Editar">
                                        <form method="POST" action="#" id="formeditar<?php echo $endereco[0]->id ?>">
                                          <input type="hidden" id="id" name="id" value="<?php echo $endereco[0]->id; ?>">
                                          <input type="hidden" id="editar" name="editar">
                                          <center>
                                          <a <?php echo 'onclick="document.getElementById(`formeditar'. $endereco[0]->id .'`).submit();"'; ?> href="#">
                                            <img src="images/editar.png" height="25px" width="25px">
                                          </a>
                                          </center>
                                        </form>
                                      </td>
                                      <td data-title="excluir">
                                        <form method="POST" action="#" id="formexcluir<?php echo $endereco[0]->id ?>">
                                          <input type="hidden" id="id" name="id" value="<?php echo $endereco[0]->id; ?>">
                                          <input type="hidden" id="excluir" name="excluir">
                                          <center>
                                            <a <?php echo 'onclick="document.getElementById(`formexcluir'. $endereco[0]->id .'`).submit();"'; ?> href="#">
                                              <img src="images/excluir.png" height="25px" width="25px">
                                            </a>
                                          </center>
                                        </form>
                                        </td>
                                    </tr>
                                   </tbody>
                                 </table>
                               </section>
                              </div><!-- /content-panel -->
                            </div><!-- /col-lg-12 -->
  									     </div><!-- /row -->
  									   </div>
                      </div>
                    <?php
                      }
                     } 
                      else
                        echo "<center><h4>Você não possui endereços cadastrados.</h4></center><br>";
                    ?>
                </div>
      	        </div>
            </div>
            <div id="menu1" class="tab-pane fade <?php if($active == "menu1") echo 'in active'; ?>">
              <form class="form-horizontal style-form" method="post" action="#" id="form_sub" style="margin-left:10px; margin-right:10px;">
                  <p style="color: red; margin-left: 20px;">*REQUIRED FIELD</p>
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
                        <input type="text" id="cep" name="cep" maxlength="10" class="form-control" placeholder="Informe o CEP deste endereço" <?php echo "value='$cep'"; ?> required>
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
                          <input type="text" class="form-control" maxlength="6" id="num" name="num" placeholder="Informe o número do endereço" <?php echo "value='$num'"; ?> required>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Complemento</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control " maxlength="20" id="complemento" name="complemento" placeholder="Informe o complemento do endereço" <?php echo "value='$complemento'"; ?>>
                      </div>
                  </div>
                  <?php
                    echo $btn;
                  ?>
                  <input type="hidden" name="lat" id="lat">
                  <input type="hidden" name="long" id="long">
              </form>
            </div>
		      </div>
		    </div>     	
      </div>
    </div>
  </section>

	
 </section><!-- Conteiner-->

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmWPAIE9_AASg6Ijgoh0lVOZZ_VWvw6fg&libraries=places" async defer></script>

	<script type="application/javascript">

        function codeAddress() {
          var geocoder = new google.maps.Geocoder();
        var address = document.getElementById( 'cidade' ).value+', '+document.getElementById( 'uf' ).value+ ', '+ document.getElementById( 'rua' ).value+' '+ document.getElementById( 'num' ).value;
          geocoder.geocode( { 'address' : address }, function( results, status ) {
            if( status == google.maps.GeocoderStatus.OK ) {
                document.getElementById( 'lat' ).value = results[0].geometry.location.lat();
                document.getElementById( 'long' ).value = results[0].geometry.location.lng();
                document.getElementById('form_sub').submit();
            } else {
                alert( 'Não podemos encontrar sua localização corretamente, por favor, reveja os dados.');
            }
        } );
      }
      

    </script>
  </body>
</html>
