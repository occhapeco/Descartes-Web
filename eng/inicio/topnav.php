      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->

      <style>
      .top{
          padding: 5px 15px;
          margin-right: 15px;
          margin-top: 15px;
        }
      </style>

      <!--header start-->
      <header class="header black-bg">
            <!--logo start-->
            <a href="index.php" class="logo"><b>DescartesLab</b></a>
            <!--logo end-->

            <div class="top-menu">
            	<ul class="nav pull-right top-menu top">
                 <li><a href=""> Home </a></li>
                 <li><a href=""> Mapa </a></li>
                 <li><a href=""> Sobre </a></li>
                 <?php
                  if(isset($_SESSION["id"]))
                    echo "<li><a class='logout' href='../inicio/logout.php'>Logout</a></li>";
                  else
                    echo "<li><a class='logout' href='../inicio/logout.php'>Login</a></li>";
                 ?>
            	</ul>
            </div>
        </header>
      <!--header end-->
