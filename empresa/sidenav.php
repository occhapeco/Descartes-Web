<!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="editar_perfil.php"><img src="assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
				          <center>
                    <?php
                      require_once("../conectar_service.php");
                      $json_dados = $service->call('empresa.select_by_id',array($_SESSION["id"]));
                      $empresa = json_decode($json_dados);
                      echo "<p>" . $empresa[0]->nome_fantasia . "</p>";
                    ?>
              	    <a href="editar_perfil.php"><button class="btn btn-sm btn-theme btn-round" style="font-size:14px;">Editar Perfil</button ></a>
              	  </center>	
				          <br>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-map-marker"></i>
                          <span>Pontos</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="pontos.php">Meus Pontos</a></li> 
                          <li><a  href="cadastro_pontos.php">Adicionar Pontos</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="agendamentos.php">   <!-- ligar a outra página-->
                          <i class="fa fa-bar-chart-o"></i>
                          <span>Agendamentos</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-map"></i>
                          <span>Mapas</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="mapa_coletas.php">Mapa de coletas</a></li>
                          <li><a  href="mapa_pontos.php">Mapa de pontos</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="index.php">   <!-- ligar a outra página-->
                          <i class="fa fa-bar-chart-o"></i>
                          <span>Ranking</span>
                      </a>
                  </li>
                  
              </ul>
          </div>
      </aside>