<?php
	require_once("permissao.php"); 
	require_once("../conectar_service.php");

	// Aceitar agendamento
	if (isset($_POST["aceitar"]))
		if ($service->call('agendamento.aceitar',array($_POST["id"])))
		{
			//if ($service->call('notificacao.insert',array)) ARRUMAR NOTIFICAÇÃO NO WEB SERVICE
			header("location: index.php");
		}
		else
			print_r("Erro ao aceitar!");

	// Recusar agendamento
	if (isset($_POST["recusar"]))
		if ($service->call('agendamento.recusar',array($_POST["id"])))
		{
			//if ($service->call('notificacao.insert',array)) ARRUMAR NOTIFICAÇÃO NO WEB SERVICE
			header("location: index.php");
		}
		else
			print_r("Erro ao recusar!");


	// Realizar agendamento
	if (isset($_POST["realizar"]))
		if ($service->call('agendamento.realizar',array($_POST["id"])))
		{
			//if ($service->call('notificacao.insert',array)) ARRUMAR NOTIFICAÇÃO NO WEB SERVICE
			header("location: index.php");
		}
		else
			print_r("Erro ao realizar!");


	// Cancelar agendamento
	if (isset($_POST["cancelar"]))
		if ($service->call('agendamento.cancelar',array($_POST["id"])))
		{
			//if ($service->call('notificacao.insert',array)) ARRUMAR NOTIFICAÇÃO NO WEB SERVICE
			header("location: index.php");
		}
		else
			print_r("Erro ao cancelar!");

?>