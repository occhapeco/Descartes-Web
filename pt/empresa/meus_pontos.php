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
  $alert = '';
  $active = "home";
  $disabled = ' data-toggle="pill"';
  $ativo = '';
  $ponto_id = 0;

  if (isset($_POST))
  {
    if (isset($_POST['excluir']))
    {
      require_once("../conectar_service.php"); 
      $batata = $service->call('ponto.delete',array($_POST['id']));
    }
    elseif(isset($_POST['msg']))
    {
      $msg = $_POST['msg'];
      $headers =  'MIME-Version: 1.0' . "\r\n"; 
      $headers .= 'From: DescartesLab' . "\r\n";
      mail('occhapecosenai@gmail.com', 'Adicionar tipo de lixo',$msg,$headers);
    }
    elseif (isset($_POST["editar"]))
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
      $active = "menu2";
      $input_id = "<input type='hidden' id='lat' name='lat' value=" . $endereco[0]->latitude . "><input type='hidden' id='long' name='long' value=" . $endereco[0]->longitude . "><input type='hidden' id='id' name='id' value=" . $_POST["id"] . "><input type='hidden' id='endereco_id' name='endereco_id' value=" . $ponto[0]->endereco_id . ">";
      $btn = '<button class="btn btn-sm btn-theme pull-right" type="submit" id="edit" name="edit" style="margin-left:10px;">Confirmar</button>';
      $bab = "";
      $disabled = "";
      $ativo = ' disabled';

    }
    elseif (isset($_POST["cadastrar"]))
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
            $alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Ponto cadastrado com sucesso!</b></div>';
        }
        else
          $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Algo deu errado!</b> Cheque sua conexão e tente novamente.</div>';
      }
      else
          $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Algo deu errado!</b> Cheque sua conexão e tente novamente.</div>';
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
            $delete = $service->call('tipo_lixo_has_ponto.delete',array($tipo_lixo_has_ponto[$i]->id));
          }
          // Seleciono todos os tipos de lixo
          $json_dados = $service->call('tipo_lixo.select',array(NULL));
          $tipo_lixo = json_decode($json_dados);
          for($i=0;$i<count($tipo_lixo);$i++)
            if (isset($_POST[$tipo_lixo[$i]->id])) // Como os nomes dos checkboxs são o id do tipo de lixo, é só ver se está checado
              $tipo_lixo_has_ponto_id = $service->call('tipo_lixo_has_ponto.insert',array($tipo_lixo[$i]->id,$_POST["id"]));
          $alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Ponto editado com sucesso!</b></div>';
        }
        else
          $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Algo deu errado!</b> Cheque sua conexão e tente novamente.</div>';
      }
      else
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
    
    <script src="https://use.fontawesome.com/9c8fd2c64e.js"></script>

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/table-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>
  
    <style type="text/css">

      #map {
        height: 550px;
        margin: 5px 5px 5px 5px;
      }

      .controls {
        position: relative;
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        position: relative;
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #target {
        width: 345px;
      }

      .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus
      {
        color: #fff;
        background-color: #2A3F54;
      }

    </style>
    <script src="js/markerclusterer.js"></script>

  </head>

  <body>

  <section id="container" >
      
      <?php
          require_once("navtop.php");
      ?>    
  
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT  TABELA RESPONSIVA
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
        <section class="wrapper">
          <h4><i class="fa fa-angle-right"></i> Meus pontos</h3>
          <div class="row mt">
            <div class="col-lg-12">
              <div class="content-panel">
                <ul class="nav nav-tabs" style="margin-left: 5px;">
                  <li class="<?php if($active == "home") echo ' active'; echo $ativo; ?>"><a <?php echo $disabled; ?> href="#home" style="color: black;">Mapa</a></li>
                  <li <?php echo "class='$ativo'";?> ><a <?php echo $disabled; ?> href="#menu1" style="color: black;">Lista</a></li>
                  <li <?php if($active == "menu2") echo ' class="active"'; ?>><a data-toggle="pill" href="#menu2" style="color: black;">Novo</a></li>
                </ul>
                  
                <div class="tab-content" style="margin-top: 20px;">
                  <div id="home" class="tab-pane fade <?php if($active == "home") echo "in active"; ?>">
                    <input id="pac-input" class="controls" type="text" placeholder="Pesquise a localidade"> </input>
                    <div id="map"></div>
                  </div>
                  <div id="menu1" class="tab-pane fade" style="padding-left: 5px; padding-right: 5px;">
                    <?php                            
                    $json_dados = $service->call('ponto.select_by_empresa',array($_SESSION["id"]));
                    $ponto = json_decode($json_dados);
                    $num = count($ponto);
                    if ($num > 0)
                    {
                  ?>
                  <section id="no-more-tables">
                    <table class="table table-striped table-condensed cf ">
                       <thead class="cf">
                          <tr>
                             <th>Endereço</th>
                             <th class="number">Telefone</th>
                             <th class="time">Horário de atendimento</th>
                             <th>Observação</th>
                             <th><center>Editar</center></th>
                             <th><center>Excluir</center></th>
                          </tr>
                       </thead>
                       <tbody>
                    <?php
                      for($i=0;$i<$num;$i++)
                      {
                        $json_dados = $service->call('endereco.select_by_id',array($ponto[$i]->endereco_id));
                        $endereco = json_decode($json_dados);
                        echo '<tr>
                                <td data-title="Endereço">' . $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais . '</td>
                                <td data-title="Telefone">' . $ponto[$i]->telefone . '</td>
                                <td data-title="Horário">' . $ponto[$i]->atendimento_ini . ' - ' . $ponto[$i]->atendimento_fim . '</td>
                                <td data-title="Observação">' . $ponto[$i]->observacao . '</td>
                                <td data-title="Editar"><form method="POST" action="#"><input type="hidden" id="id" name="id" value=' . $ponto[$i]->id . '><center><button type="submit" id="editar" name="editar" class="btn btn-theme"><i class="fa fa-pencil"></i></button></center></form></td>
                                <td data-title="Excluir"><form method="POST" action="#"><input type="hidden" id="id" name="id" value=' . $ponto[$i]->id . '><center><button type="submit" id="excluir" name="excluir" class="btn btn-danger"><i class="fa fa-times"></i></button></center></form></td></tr>';
                      }
                  ?>
                        </tbody>
                      </table>
                    </section>
                  <?php
                    }
                    else
                      echo "<center><h4>Você não possui pontos. Para cadastrar um, <a href='mapa_pontos.php'>clique aqui!</a></h4></center><br>";
                  ?>
                  </div>
                  <div id="menu2" class="tab-pane fade <?php if($active == "menu2") echo "in active"; ?>">
                    <div class="row mt">
                      <p style="color: red; margin-left: 20px;">*CAMPO REQUERIDO</p>
                      <form class="form-horizontal style-form" method="post" action="#" id="frm">
                        <input type="hidden" name="lat" id="lat">
                        <input type="hidden" name="long" id="long">
                        <?php echo $bab; ?>
                        <!-- Confirmação e Complemento do endereço do ponto -->
                        <div class="col-lg-6" style="padding: 0px 25px 0px 25px;">
                          <h5 class="mb"><i class="fa fa-angle-right"></i> Endereço</h5>
                            <div class="form-group">
                                  <label class="col-sm-2 col-sm-2 control-label">*CEP</label>
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
                        </div>
                          
                          <!-- Dados do funcionamento do Ponto -->    
                          <div class="col-lg-6" style="padding: 0px 25px 0px 25px;">
                            <h5 class="mb"><i class="fa fa-angle-right"></i> Dados do Ponto</h5>
                             <div class="form-group">
                                 <label class="col-sm-2 col-sm-2 control-label">*Horário de início do atendimento</label>
                                  <div class="col-sm-10">
                                      <input type="time" class="form-control" maxlength="12" OnKeyPress="formatar('##:##', this,event)"  id="atendimento_ini" name="atendimento_ini" <?php echo "value='$atendimento_ini'";?> required>
                                  </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-2 col-sm-2 control-label">*Horário de final do atendimento</label>
                                  <div class="col-sm-10">
                                      <input type="time" class="form-control" maxlength="12" id="atendimento_fim" name="atendimento_fim"<?php echo "value='$atendimento_fim'";?> required>
                                  </div>
                              </div>
                              <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Telefone</label>
                                    <div class="col-sm-10">
                                      <input type="text" maxlength="13" class="form-control" id="telefone" name="telefone" <?php echo "value='$telefone'";?> placeholder="Ex: 44 4444 4444">
                                    </div>
                                </div>
                              <div class="form-group">
                                 <label class="col-sm-2 col-sm-2 control-label">Observações</label>
                                  <div class="col-sm-10">
                                      <textarea class="form-control" maxlength="250" id="observacao" name="observacao" placeholder="Ex: Fecha ao meio dia etc."><?php
                                       echo $observacao; ?></textarea>
                                  </div>
                              </div>
                           </div>
                           <!-- Tipos de lixo recolhidos pelo Ponto -->    
                          <div class="col-lg-12" style="padding: 0px 50px 0px 50px;">
                            <h5 class="mb"><i class="fa fa-angle-right"></i> Selecione quais dos materiais a baixo este ponto recolhe</h5>
                             <div class="form-group">
                               
                                <table class="table col-md-6">
                                  <?php
                                     $json_dados = $service->call('tipo_lixo.select',array(NULL));
                                     $tipo_lixo = json_decode($json_dados);
                                     for($i=0;$i<count($tipo_lixo);$i++)
                                    {
                                      if($i==0)
                                      {
                                          echo '<tr>';
                                      }
                                      elseif (($i%4)==0) 
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
                                              if ($ponto_id != 0)
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
                          </div>
                          <div class="col-lg-12" style="padding: 0px 30px 0px 30px;">
                            <a type="" href="#" class="btn btn-default" id="pop">Não achou o que queria?</a>
                            <?php
                              echo $lat_long;
                              echo $input_id;
                              echo $btn; 
                            ?>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </section>

      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Seleção de tipo de lixo</h4>
              </div>
              <div class="modal-body" style="overflow: auto; max-height: 400px;">
                <form action="#" method="post">
                  <table class="table table-stripped">                                    
                   <?php 
                      $dados_json = $service->call('tipo_lixo.select',array(NULL));
                      $tipo_lixo = json_decode($dados_json);
                      $num = count($tipo_lixo);
                      for ($i=0; $i < $num ; $i++) { 
                        echo "<tr><td><input type='checkbox' name='tipos[]' value='".$tipo_lixo[$i]->id."'></td><td>".$tipo_lixo[$i]->nome."</td></tr>";
                      }
                   ?> 
                  </table>
              </div>
              <div class="modal-footer">
                    <button type="submit" class="btn btn-theme" id="seleciona" name="seleciona">Selecionar</button>
                 </form>
              </div>
          </div>
        </div>
      </div>

      <script>
        
        var geocoder;

        function codeAddress() {
        var address = document.getElementById( 'cidade' ).value+', '+document.getElementById( 'uf' ).value+ ', '+ document.getElementById( 'rua' ).value+' '+ document.getElementById( 'num' ).value;
          geocoder.geocode( { 'address' : address }, function( results, status ) {
            if( status == google.maps.GeocoderStatus.OK ) {
                document.getElementById( 'lat' ).value = results[0].geometry.location.lat();
                document.getElementById( 'long' ).value = results[0].geometry.location.lng();
                document.getElementById('frm').submit();
            } else {
                alert( 'Não podemos encontrar sua localização corretamente, por favor, reveja os dados.');
            }
        } );
      }
      
     

      function initAutocomplete() {
        geocoder = new google.maps.Geocoder();
        var poder = true; // somente utilizada quando a empresa for criar um ponto para selecionar o local
        var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 2,
                center: new google.maps.LatLng(16.770881080415, 12.3046875),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: [
                  {
                    "stylers": [
                      { "visibility": "on" },
                      { "weight": 1 },
                      { "hue": "#64B5F6" },
                      { "gamma": 0.75 }
                    ]
                  },
                  {
                    featureType: 'landscape',
                    elementType: 'geometry',
                    stylers: [
                      { hue: '#00ff00' }
                    ]
                  },
                  {
                    featureType: 'poi.park',
                    elementType: 'geometry',
                    stylers: [
                      { hue: '#00ff00' }
                    ]
                  }
                ]
        });

        //responsivo
        google.maps.event.addDomListener(window, "resize", function() {
           var center = map.getCenter();
           google.maps.event.trigger(map, "resize");
           map.setCenter(center);
        });

        //cria o input para pesquisar no mapa
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Encontra o lugar pesquisado
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            //coloca o lugar em uma variável para dar fit no mapa
            if (place.geometry.viewport) {
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });

        //local dos ícones utilizados
        var icons = {
                mark1: {
                  icon: 'images/mark1.png'
                },
                mark2: {
                  icon: 'images/mark2.png'
                }
        };

        //função que adiciona marcadores
        function addMarker(feature) {
          var marker = new google.maps.Marker({
            position: feature.position,
            icon: icons[feature.type].icon,
            map: map,
            draggable:feature.draggable, // se pode ser arrastado
            info: feature.info //conteudo do marcador
          });

          google.maps.event.addListener(marker, 'click', function () {
            infowindow.setContent(this.info); //conteúdo do marcador
            infowindow.open(map, this);
          });

          markers.push(marker);
        }

        //criação da infowindow
        var infowindow = new google.maps.InfoWindow(); // variável para criar a tela quando clica no marcador

        <?php
          $json_dados = $service->call('ponto.select_by_empresa',array($_SESSION["id"]));
          $ponto = json_decode($json_dados);
          $num = count($ponto);
        ?>

        //uso de ícone personalizado e conteúdo de cada marker
        var features = [
          <?php
            for ($i=0;$i<$num;$i++)
            {
              $json_dados = $service->call('endereco.select_by_id',array($ponto[$i]->endereco_id));
              $endereco = json_decode($json_dados);
              $json_dados = $service->call('tipo_lixo_has_ponto.select_by_ponto',array($ponto[$i]->id));
              $tipo_lixo_has_ponto = json_decode($json_dados);
              $tipos_lixo = "";
              if (count($tipo_lixo_has_ponto) == 0)
                $tipos_lixo = "Sem tipos de lixo!";
              else
                for ($j=0;$j<count($tipo_lixo_has_ponto);$j++)
                {
                  $json_dados = $service->call('tipo_lixo.select_by_id',array($tipo_lixo_has_ponto[$j]->tipo_lixo_id));
                  $tipo_lixo = json_decode($json_dados);
                  if ($j != 0)
                    $tipos_lixo .= ", ";
                  $tipos_lixo .= $tipo_lixo[0]->nome;
                }
              if ($i != 0)
                echo ",";
              ?>
              {
                position: new google.maps.LatLng(<?php echo $endereco[0]->latitude.','.$endereco[0]->longitude; ?>), 
                type: 'mark1',
                info:'<div id="content">'+
                      '<div id="siteNotice">'+
                      '</div>'+
                      '<h3 id="firstHeading" class="firstHeading"><?php echo $tipos_lixo; ?></h3>'+
                      '<div id="bodyContent" class="col-sm-12">'+
                      '<p name="nome" class="col-sm-6"><?php echo $endereco[0]->rua.', '.$endereco[0]->num.' '.$endereco[0]->complemento.', '.$endereco[0]->bairro.', '.$endereco[0]->cidade.' - '.$endereco[0]->uf.', '.$endereco[0]->pais; ?></p>'+
                      '<p name="descricao" class="col-sm-6"><?php echo $ponto[$i]->observacao; ?> </p>'+
                      '<form action="#" method="post">'+
                      '</form>'+
                      '</div>'+
                      '</div>',
                draggable:false
              }
          <?php
            }
          ?>
        ];

        //cria as variáveis chamando as funções
        for (var i = 0, feature; feature = features[i]; i++) {
          addMarker(feature);
        }

        //cluster de marcadores
        var options = {
                  imagePath: 'images/m'
        };

        var markerCluster = new MarkerClusterer(map, markers, options); // cria cluster
      }

      function submeter()
      {
        var geocoder = new google.maps.Geocoder;
        var lati = document.getElementById('lat').value;
        var long = document.getElementById('long').value;
        var latlng = {lat: parseFloat(lati), lng: parseFloat(long)};

        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === google.maps.GeocoderStatus.OK) {
            if (results[1]) {
              var address = "", city = "", state = "", zip = "", country = "", formattedAddress = "";
              for (var i = 0; i < results[0].address_components.length; i++) {
                          var addr = results[0].address_components[i];
                          // check if this entry in address_components has a type of country
                          if (addr.types[0] == 'country')
                              country = addr.long_name;
                          else if (addr.types[0] == 'street_address') // address 1
                              address = address + addr.long_name;
                          else if (addr.types[0] == 'establishment')
                              address = address + addr.long_name;
                          else if (addr.types[0] == 'route')  // address 2
                              address = address + addr.long_name;
                          else if (addr.types[0] == 'postal_code')       // Zip
                              zip = addr.short_name;
                          else if (addr.types[0] == ['administrative_area_level_1'])       // State
                              state = addr.long_name;
                          else if (addr.types[0] == ['locality'])       // City
                              city = addr.long_name;
              }
              document.getElementById('estado').value = state;
              document.getElementById('endereco').value = address;
              document.getElementById('cep').value = zip;
              document.getElementById('pais').value = country;
              document.getElementById('cidade').value = city;
              document.getElementById("submete").submit();
            } else {
             //window.alert('No results found');
            }
          } else {
            //window.alert('Geocoder failed due to: ' + status);
          }
        });
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmWPAIE9_AASg6Ijgoh0lVOZZ_VWvw6fg&libraries=places&callback=initAutocomplete" async defer></script>  

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
  

  </body>
</html>
