<?php
	require_once('lib/nusoap.php');

	ini_set("soap.wsdl_cache_enabled", "1");
	$service = new nusoap_client('http://192.168.1.254/service/index.php?wsdl', true);

	$variavel = $service->call('endereco.update',array(29,"cristo redentor","466","d","89803150","sao cristovao","sc","chapeco","brasil",-26.950504372188,-48.629693984985));
	var_dump($variavel);
?>