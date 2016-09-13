<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION["tabela"] != "usuario")
		header("location: ../inicio/login.php");
?>