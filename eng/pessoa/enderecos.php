<?php 
  require_once("permissao_pessoa.php"); 
  require_once("../conectar_service.php");
  $alert='';
   $active = "home";  

  if(isset($_POST["excluir"]))
  {
    if($service->call('endereco.delete',array($_POST["id"])))
        $alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Successfully deleted your address!</b></div>';
    else
      $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Something gone wrong!</b> Check your connection and try again.</div>';
  }
  elseif(isset($_POST["edit"]))
  {
    if ($service->call('endereco.update',array($_POST["id"],$_POST["rua"],$_POST["num"],$_POST["complemento"],$_POST["cep"],$_POST["bairro"],$_POST["uf"],$_POST["cidade"],$_POST["pais"],$_POST["lat"],$_POST["long"])))
    {
      header("location: enderecos.php");
      $alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Your address has been successfully edited!</b></div>';
   }
    else
      $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Something gone wrong!</b> Check your connection and try again.</div>';
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
   $disabled = ' data-toggle="pill"';
   $ativo = '';

   $btn = '<a onclick="codeAddress();" id="cadastrar" name="cadastrar" class="btn btn-sm btn-theme pull-right" style="margin-right:10px;">Confirm</a><br><br>';

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
    $btn = ' <a href="enderecos.php"><button type="submit" id="edit" name="edit" class="btn btn-sm btn-theme pull-right" style="margin-right:10px;">Confirm</button></a><br><br>';

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
      $alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Address was successfully inserted!</b></div>';
      header("location: enderecos.php");
    }
    else
    {
      $deletar = $service->call('endereco.delete', array("id = " . $endereco_id));
      $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Something gone wrong!</b> Check your connection and try again.</div>';
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
      <h3><i class="fa fa-angle-right"></i> Addresses</h3>
      <?php
        if($alert != '')
          echo "<br>".$alert;
      ?>
      <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
            <ul class="nav nav-tabs" style="margin-left: 20px;">
              <li class="<?php if($active == "home") echo ' active'; echo $ativo; ?>"><a <?php echo $disabled; ?> href="#home" style="color: #797979;">See all</a></li>
              <li <?php if($active == "menu1") echo ' class="active"'; ?>><a data-toggle="pill" href="#menu1" style="color: #797979;">Create new</a></li>
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
                                       <th>Street</th>
                                       <th>Number</th>  
                                       <th>Complement</th>  
				                               <th>Postal Code</th>
                                       <th>Neighbourhood</th>  
                                       <th>State</th>
              												 <th>City</th>
              												 <th>Country</th>
                                       <th><center>Edit</center></th>
							                         <th><center>Delete</center></th>
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
                                        <form method="POST" action="#" id="formeditar">
                                          <input type="hidden" id="id" name="id" value="<?php echo $endereco[0]->id; ?>">
                                          <center>
                                          <button type="submit" id="editar" name="editar" class="btn btn-theme">
                                            <i class="fa fa-pencil"></i>
                                          </button>
                                          </center>
                                        </form>
                                      </td>
                                      <td data-title="excluir"><form method="POST" action="#"><input type="hidden" id="id" name="id" value="<?php echo $endereco[0]->id; ?>"><center><button type="submit" id="excluir" name="excluir" class="btn btn-danger"><i class="fa fa-times"></i></button></center></form></td>
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
                        echo "<center><h4>You do not have any registered addresses.</h4></center><br>";
                    ?>
                </div>
      	        </div>
            </div>
            <div id="menu1" class="tab-pane fade <?php if($active == "menu1") echo 'in active'; ?>">
              <form class="form-horizontal style-form" method="post" action="#" id="form_sub" style="margin-left:10px; margin-right:10px;">
                   <p style="color: red; margin-left: 20px;">*REQUIRED FIELD</p> 
                  <?php echo $id_input; ?>
                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">*Name of the address</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control " maxlength="20" id="nome_endereco" placeholder="Give this address a name to find it easily" <?php echo "value='$nome_endereco'"; 
                              if(isset($_POST["editar"]))
                                echo 'disabled name="nome_endereco"';
                              else
                                echo 'name="nome_endereco1"';
                              ?>
                          autofocus required>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">*Postal Code</label>
                      <div class="col-sm-10">
                        <input type="text" id="cep" name="cep" maxlength="10" onkeypress="formatar('##.###-###', this,event)" class="form-control" placeholder="Enter this address Postal Code" <?php echo "value='$cep'"; ?> required>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">*Country</label>
                      <div class="col-sm-10">
                         <input type="text" class="form-control" maxlength="20" id="pais" name="pais" placeholder="Enter the country" <?php echo "value='$pais'"; ?> required>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">*State</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" maxlength="2" id="uf" name="uf"  placeholder="Enter the state" <?php echo "value='$uf'";?> required>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">*City</label>
                      <div class="col-sm-10">
                          <input id="cidade" type="text" class="form-control" maxlength="40" id="cidade" name="cidade" placeholder="Enter the city" <?php echo "value='$cidade'"; ?> required>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">*Neighbourhood</label>
                      <div class="col-sm-10">
                        <input id="bairro" type="text" class="form-control" maxlength="40" id="bairro" name="bairro" placeholder="Enter the neighbourhood" <?php echo "value='$bairro'"; ?> required>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">*Street</label>
                      <div class="col-sm-10">
                        <input id="rua" type="text" class="form-control" maxlength="40" id="rua" name="rua" placeholder="Enter the street" <?php echo "value='$rua'"; ?> required>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">*Number</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" onkeypress="return numbro(event)" onload="return numbro(event)" maxlength="6" id="num" name="num" placeholder="Enter the number of the address" <?php echo "value='$num'"; ?> required>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Complement</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control " maxlength="20" id="complemento" name="complemento" placeholder="Enter the complement of the address" <?php echo "value='$complemento'"; ?>>
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
