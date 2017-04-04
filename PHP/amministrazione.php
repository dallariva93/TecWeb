<?php
	Require_once('functions.php');
	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("<title>Amministrazione - FaceOnTheBook</title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("","<span xml:lang='en'> <a href='index.php'>Home</a></span>/Amministrazione");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb, file_get_contents("../HTML/Template/Breadcrumb.txt"));
	
	echo file_get_contents("../HTML/Template/SchedeAmministrazione.txt").

	file_get_contents("../HTML/Template/Footer.txt");

?>

