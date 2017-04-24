<?php

	Require_once('connect.php');
	Require_once('functions.php');

	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("<title>Amministrazione Notizie - FaceOnTheBook </title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("","<span xml:lang='en'> <a href='index.php'>Home</a></span>/<span><a href ='amministrazione.php'>Amministrazione</a></span>/Notizie");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb, file_get_contents("../HTML/Template/Breadcrumb.txt"));

	echo "<div class='centrato content'>";
	echo "<a href='#insert' id = 'new'>&#43;&nbsp;Nuova Notizia</a>";
	//Tabella con tutte le notizie
	if($Notizie = $db->query("SELECT * FROM Notizie ORDER BY Data DESC")){
		echo file_get_contents("../HTML/Template/InizioTabellaNotizie.txt");
		while ($New = $Notizie->fetch_array(MYSQLI_ASSOC)){
			$autoreNotizia;
			if($autoreArray = $db->query("SELECT Nome,Cognome FROM Redazione WHERE Email =".$New['Autore']))
			{
				$autore = $autoreArray->fetch_array(MYSQLI_ASSOC);
				$autoreNotizia = $autore['Nome']. " ". $autore['Cognome'];
				$autoreArray->free();
			}
			else
				$autoreNotizia = $New['Autore'];
			$searchNotizie=array("{{Id}}","{{Titolo}}","{{Data}}","{{Autore}}");
			$replaceNotizie=array($New['Id'],$New['Titolo'],$New['Data'],$autoreNotizia);
			echo str_replace($searchNotizie ,$replaceNotizie, file_get_contents("../HTML/Template/TabellaNotizie.txt"));

		}
		$Notizie->free();
	}
	echo "</tbody></table></div>";

	//Form inserimento notizia
	echo file_get_contents("../HTML/Template/FormInserimentoNotizia.txt");

	$db->close();
	echo "</div>";//Fine content

	echo file_get_contents("../HTML/Template/Footer.txt");

?>
