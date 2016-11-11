<?php
	require_once('lib/nusoap.php');

	ini_set("soap.wsdl_cache_enabled", "1");
	$service = new nusoap_client('http://192.168.1.138/descarteslab/service/index.php?wsdl', true);

?>