
	<!-- General Style -->
	<link href="style1.css" rel="stylesheet">
	
	<!-- Animations -->
	<link href="css/animate.css" rel="stylesheet">
		
	<!-- Device Styles -->
	<link rel="stylesheet" type="text/css" href="css/devices/style.css">
	<script src="https://use.fontawesome.com/9c8fd2c64e.js"></script>

	<!-- Cover Styles (Skin) -->
	<link rel="stylesheet" type="text/css" href="css/landing/landing.css">
	
	<!--Fonts-->
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,200,100,500,600,700,800,900' rel='stylesheet' type='text/css'>
	<link href="css/fonts/font-awesome.css" rel="stylesheet">

<style>
.mobile{
	background-color:#606060;
	}
</style>
<?php require_once("../conectar_service.php"); ?>
<header class="mobile">
  <div class="row">
    <div class="col full">
      <div style="margin-left:30px;"><a href="index.php" class="logo" style="color:white;"><img src="images/logo2.png" height="43px" width="120px" style="margin-top:-5px" class="img-responsive"></a></div>
      <nav id="nav-wrap" style="left: 19%;">
        <a class="mobile-btn" href="#nav-wrap" title="Show navigation">
        	<i class="fa fa-bars" style="color:white; margin-top:2px;margin-left:8px;font-size:36px;"></i>
        </a> 
        <a class="mobile-btn" href="#nvv" title="Hide navigation">
        	<i class="fa fa-bars" style="color:white; margin-top:2px;margin-left:8px;font-size:36px;"></i>
        </a>
        <ul id="nav" class="nav" style="margin-left:430px" >
          <li><center><a href="../../pt/master/"><img src="img/bndbr.png" width="20px;"></a></center></li>
          <li><a href="../index/logout.php">Se déconnecter</a></li>
        </ul>
      </nav>
    </div>
  </div>
</header>