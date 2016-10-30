<?php 
  require_once("../conectar_service.php");
  
  //Cadastro
  if (isset($_POST["cadastrar"]))
  {
    // Cadastra o endereço e retorna seu id (0 se der bosta)
    $lixo_id = $service->call('tipo_lixo.insert',array($_POST["nome_lixo"]));
  }

  if(isset($_POST["excluir"]))
  {
    $lixo = $service->call('tipo_lixo.delete', array($_POST["id"]));
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
          	<h3><i class="fa fa-angle-right"></i> Trash</h3>
          	
          	<!-- BASIC FORM ELELEMNTS -->
          	<div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel offset1">
                      <form class="form-horizontal style-form" method="post" action="#">
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Waste name</label>
                              <div class="col-sm-10">
                                <input type="text" id="nome_lixo" name="nome_lixo" maxlength="20"  class="form-control" autofocus required>
                              </div>
                          </div>
                          <button type="submit" id="cadastrar" name="cadastrar" class="btn btn-sm btn-theme pull-right">Register</button>
                          <a class="btn btn-sm btn-theme03 pull-right" id="oiem" style="margin-right: 10px;" onclick="document.getElementById('nome_lixo').value=' ';">Cancel</a><br><br>
                      </form>
                  </div>
				      </div><!-- col-lg-12-->      	
           </div><!-- /row -->

           <div class="row mt">
              <div class="col-lg-12">
                  <div class="form-panel offset1">
                      <form class="form-horizontal style-form" method="post" action="#">
                         <div class="content-panel">
                            <section id="no-more-tables">
                              <table class="table table-striped table-condensed cf ">
                                 <thead class="cf">
                                    <tr>
                                       <th>Waste name</th>
                                       <th><center>Delete</center></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                  <?php
                                    $json_dados = $service->call('tipo_lixo.select', array(NULL));
                                    $lixo = json_decode($json_dados);
                                    for($i=0;$i<(count($lixo));$i++)
                                    {
                                      echo '<tr>
                                              <td data-title="Waste name">' . $lixo[$i]->nome . '</td>
                                              <td data-title="Delete"><form method="POST" action="#" id="lixo'. $lixo[$i]->id .'"><input type="hidden" id="id" name="id" value=' . $lixo[$i]->id . '><input type="hidden" id="excluir" name="excluir"><center><a href="#" onclick="document.getElementById(`lixo'. $lixo[$i]->id .'`).submit();" id="excluir"><img src="images/excluir.png" height="25px;" width="25px;"></a></center></form></td></tr>';
                                    }
                                ?>
                              </tbody>
                            </table>
                          </section>
                        </div>
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
	<script src="assets/js/zabuto_calendar.js"></script>	
	
	<script type="text/javascript">
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
	</body>
</html>
