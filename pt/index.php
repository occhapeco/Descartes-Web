<?php
	session_start();
	if(isset($_SESSION["tabela"]))
	{
		if($_SESSION["tabela"] == "empresa")
			header("location: empresa/");
		else
			header("location: pessoa/");
	}
	else
		header("location: index/");
?>