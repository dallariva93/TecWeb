<?php
	Require_once('functions.php');

	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("Error 404 - ",
		"Pagina di errore 404");
	echo str_replace($searchHead ,$replaceHead,
		file_get_contents("../HTML/Template/Head.txt"));

	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("","<span>Errore 404, errore caricamento pagina</span>");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb,
		file_get_contents("../HTML/Template/Breadcrumb.txt")).

	file_get_contents("../HTML/Template/DeadLink.txt").
	file_get_contents("../HTML/Template/Footer.txt");
?>
