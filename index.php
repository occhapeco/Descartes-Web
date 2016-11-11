<?php
    $idioma = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);

	if($idioma == 'pt')
	    header('Location: pt/');
	else
	    header('Location: fr/');
?>