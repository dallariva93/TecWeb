<?php
	if(!isset($_SESSION))
		session_start();
	if(isset($_SESSION['type']) && $_SESSION['type'] == "admin"){
		Require_once('connect.php');
		Require_once('functions.php');
		$searchHead=array("{{title}}","{{description}}");
		$replaceHead=array("Amministrazione - ",
			"Men&ugrave; per l'amministrazione di FaceOnTheBook");
		echo str_replace($searchHead ,$replaceHead,
		 	file_get_contents("../HTML/Template/Head.txt"));

		echo menu();

		$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
		$replaceBreadcrumb=array("","<span xml:lang='en'>
			<a href='index.php'>Home</a></span> &gt; Amministrazione");
		echo str_replace($searchBreadcrumb ,$replaceBreadcrumb,
		 file_get_contents("../HTML/Template/Breadcrumb.txt")).

		file_get_contents("../HTML/Template/SchedeAmministrazione.txt").

		file_get_contents("../HTML/Template/LinkAlMenu.txt").

		file_get_contents("../HTML/Template/Footer.txt");
	}
	else{
		header("Location: page_not_found.php");
		exit();
	}
?>
