<?php
	Require_once('connect.php');
	Require_once('functions.php');

	if(isset($_POST['testo']) && !$_POST['testo']=="" && 
	isset($_POST['oggetto']) && isset($_POST['email']) 
	&& !$_POST['email']=="" && isset($_POST['nome'])){
		$header = "Da: ". $_POST['nome'];
		//Invio la stessa E-mail a tutti gli amministratori
		if($Redazione = $db->query("SELECT Email FROM Redazione")) {
			while($admin = $Redazione->fetch_array(MYSQLI_ASSOC)){
				mail($admin['Email'],$_POST['oggetto'],$_POST['testo'],$header);
			}
		$Redazione->free();
		}		
	}

	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("<title>Contatti - FaceOnTheBook</title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

	echo menu().

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array(""," <span xml:lang='en'>Home</span>/Contatti");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb, file_get_contents("../HTML/Template/Breadcrumb.txt")).

	file_get_contents("../HTML/Template/ContattiForm.txt").
	
	file_get_contents("../HTML/Template/Footer.txt");
?>
