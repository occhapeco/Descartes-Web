      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              <p class="centered"><a href="editarperfil.php"><img src="assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
				          <center>
                    <?php
                      require_once("../conectar_service.php");
                      $json_dados = $service->call('usuario.select',array("id = " . $_SESSION["id"]));
                      $usuario = json_decode($json_dados);
                      echo "<p>" . $usuario[0]->nome . "</p>";
                    ?>
              	    <a href="editarperfil.php"><button class="btn btn-sm btn-theme btn-round">Editar Perfil</button ></a>
              	  </center>	
				  <br>
                  <li class="sub-menu">
                      <a href="index.php" >
                          <i class="fa fa-map"></i>
                          <span>Mapa</span>
                      </a>
                  </li>
				  
				          <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-map-marker"></i>
                          <span>Endereços</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="enderecos.php">Meus Endereços</a></li>  
                          <li><a  href="novo_endereco.php">Novo Endereço</a></li>
                      </ul>
                  </li>
          
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-calendar"></i>
                          <span>Pedidos</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="pedidos.php">Meus Pedidos</a></li>  
                          <li><a  href="agendamentos.php">Novo Agendamento</a></li>
                      </ul>
                  </li>
		          </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
    