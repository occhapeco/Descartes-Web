<?php
	require_once('lib/nusoap.php');

	ini_set("soap.wsdl_cache_enabled", "1");
	$service = new nusoap_client('http://descartes.esy.es/index.php?wsdl', true);
	set_time_limit(800000000);
?>