<?php
	require_once("permissao.php"); 
	require_once("../conectar_service.php");

	// Aceitar agendamento
	if (isset($_POST["aceitar"]))
	{
		$bool = $service->call('agendamento.aceitar',array($_POST["id"]));
		header("location: agendamentos_aceitos.php");
	}

	// Recusar agendamento
	if (isset($_POST["recusar"]))
	{
		$bool = $service->call('agendamento.recusar',array($_POST["id"]));
		header("location: index.php");
	}


	// Realizar agendamento
	if (isset($_POST["realizar"]))
	{
		$bool = $service->call('agendamento.realizar',array($_POST["id"]));
		header("location: agendamentos_realizados.php");
	}

	// Cancelar agendamento
	if (isset($_POST["cancelar"]))
	{
		$bool = $service->call('agendamento.cancelar',array($_POST["id"]));
		header("location: index.php");
	}

	//header("location: index.php");
?>