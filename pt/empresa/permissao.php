<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION["tabela"] != "empresa")
		header("location: ../inicio/login.php");
?>