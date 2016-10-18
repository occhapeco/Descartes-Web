<?php
	$idioma = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
	switch($idioma){
		case 'pt': //Caso seja português
			header("Location: pt/");
		break;
		default:
			header("Location: eng/");
		break;
	}
?>