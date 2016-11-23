<?php
	require_once('lib/nusoap.php');

	ini_set("soap.wsdl_cache_enabled", "1");
	$service = new nusoap_client('http://descarteslab.sc.senai.br/service/index.php?wsdl', true);
	
?>