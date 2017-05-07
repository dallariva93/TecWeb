<?php
	if(true || isset($_SESSION) && $_SESSION['type'] == "admin"){ //true da togliere!!!!!!!!!!(messo per test)
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
	}
	else{
		header("Location: page_not_found.php");
		exit();
	}
?>
