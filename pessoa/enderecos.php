<?php 
  require_once("permissao_pessoa.php"); 
  require_once("../conectar_service.php");
  $alert='';

  if(isset($_POST["excluir"]))
  {
    if($service->call('endereco.delete',array($_POST["id"])))
      {
        $alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Endereço deletado com sucesso!</b></div>';
      }
      else
        $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Algo deu errado!</b> Cheque sua conexão e tente novamente.</div>';
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
          <a href="novo_endereco.php" class="btn btn-sm btn-theme03 pull-right" id="oiem" style="margin-right: 10px; margin-top:15px">Novo Endereço</a>
          	<h3><i class="fa fa-angle-right"></i> Endereços</h3>
            <?php
              if($alert != '')
                echo "<br>".$alert;
            ?>

          	
          	<!-- BASIC FORM ELELEMNTS -->
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
                                                    <form method="POST" action="novo_endereco.php" id="formeditar">
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
                                    echo "<center><h4>Você não possui endereços cadastrados.</h4></center><br>";
                                ?>
                            </div>
							           <!--</form>-->
              	    </div>
				  
				  
				        </div><!-- col-lg-12-->      	
          	</div><!-- /row -->
        </a>
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
