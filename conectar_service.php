<?php
	require_once('lib/nusoap.php');

	ini_set("soap.wsdl_cache_enabled", "1");
	$service = new nusoap_client('http://descartes.esy.es/index.php?wsdl', true);
	$service->timeout = 0;
	$service->response_timeout = 50000;
?>