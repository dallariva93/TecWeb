<?php

	function data ($value){
		$risultato = "";
		$giorno = substr($value, 8, 2);
		$mese   = substr($value, 5, 2);
		$anno   = substr($value, 0, 4);
		$risultato = $giorno. "/". $mese. "/". $anno;
		return $risultato;
	}


?>