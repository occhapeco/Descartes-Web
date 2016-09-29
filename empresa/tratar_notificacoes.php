<?php
	require_once("../conectar_service.php");

	if(isset($_POST['id']))
	{
		if($service->call('notificacao.delete',array($_POST['id'])))
			header("location: ".$_POST['pg']);
	}
	header("location: index.php");
?>