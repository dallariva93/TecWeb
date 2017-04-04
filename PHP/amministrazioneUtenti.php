<?php

	Require_once('connect.php');
	Require_once('functions.php');

	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("<title>Amministrazione Utenti - FaceOnTheBook </title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("","<span xml:lang='en'> <a href='index.php'>Home</a></span>/<span> <a href='amministrazione.php'>Amministrazione</a></span>/Utenti");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb, file_get_contents("../HTML/Template/Breadcrumb.txt"));
	
	echo "<div class='centrato content'>";
	echo "<a href='#insert' id = 'new'>&#43;&nbsp;Nuovo Utente</a>";

	if($Utenti = $db->query("SELECT * FROM Utente ORDER BY Cognome")){
		echo file_get_contents("../HTML/Template/InizioTabellaUtente.txt");
		while ($Utente = $Utenti->fetch_array(MYSQLI_ASSOC)){
		
			$search=array("{{Email}}","{{Cognome}}","{{Nome}}","{{Nickname}}","{{Data}}","{{Residenza}}");
			$replace=array($Utente['Email'],$Utente['Cognome'],$Utente['Nome'],$Utente['Nickname'],Data($Utente['Data_Nascita']),$Utente['Residenza']);
			echo str_replace($search ,$replace, file_get_contents("../HTML/Template/TabellaUtente.txt"));
		}
		$Utenti->free();
	}
	echo "</tbody></table></div>";

	//Form inserimento

	echo file_get_contents("../HTML/Template/FormInserimentoUtente.txt");


	$db->close();

	echo "</div>";//Fine content

	echo file_get_contents("../HTML/Template/Footer.txt");

?>
