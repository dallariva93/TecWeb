<?php
	if(!isset($_SESSION))
		session_start();
	if($_SESSION['type'] == "admin"){
		Require_once('connect.php');
		Require_once('functions.php');

		if(isset($_POST['delete'])){
			$delete = "DELETE FROM `Notizie` WHERE `Id` = '". $_POST['delete']. "'";
			$db->query($delete);
		}

		$errore = false;
		$titolo = (isset($_POST['titolo']))? campoNonVuoto($errore,$_POST['titolo']) : "" ;
		$testo = (isset($_POST['testo']))? campoNonVuoto($errore,$_POST['testo']) : "" ;

		$searchInForm=array("{{TitoloError}}","{{TestoError}}");
		$replaceInForm=array($titolo,$testo);

		if(!$errore && isset($_POST['titolo']) && isset($_POST['testo']))
		{
			$insert="INSERT INTO `Notizie` (Titolo, Autore,Testo)
			 	VALUES ('".$_POST['titolo']."','".$_SESSION['id']."','".
					$_POST['testo']."')";
			$db->query($insert);
		}

		$searchHead=array("{{title}}","{{description}}");
		$replaceHead=array("<title>Amministrazione Notizie - FaceOnTheBook </title>",
			"<meta name='description' content='Social network per topi di bibblioteca'/>");
		echo str_replace($searchHead ,$replaceHead,
			file_get_contents("../HTML/Template/Head.txt"));

		echo menu();

		$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
		$replaceBreadcrumb=array("","<span xml:lang='en'>
			<a href='index.php'>Home</a></span> >
			<span><a href ='amministrazione.php'>Amministrazione</a>
			</span> > Notizie");
		echo str_replace($searchBreadcrumb ,$replaceBreadcrumb,
			file_get_contents("../HTML/Template/Breadcrumb.txt")).

		"<div class='centrato content'>
		<a name = 'top'></a>
		<a href = '#insert' class = 'adminButton'>&#43;&nbsp;Nuova Notizia</a>";

		//Tabella con tutte le notizie
		if($Notizie = $db->query("SELECT * FROM Notizie ORDER BY Data DESC")){
			echo file_get_contents("../HTML/Template/InizioTabellaNotizie.txt");
			while ($New = $Notizie->fetch_array(MYSQLI_ASSOC)){
				$autoreNotizia;
				if($autoreArray = $db->query("SELECT Nome,Cognome FROM Redazione
					WHERE Email ='".$New['Autore']."'"))
				{
					$autore = $autoreArray->fetch_array(MYSQLI_ASSOC);
					$autoreNotizia = $autore['Nome']. " ". $autore['Cognome'];
					$autoreArray->free();
				}
				else
					$autoreNotizia = $New['Autore'];
				$searchNotizie=array("{{Id}}","{{Titolo}}","{{Data}}","{{Autore}}");
				$replaceNotizie=array($New['Id'],$New['Titolo'],
					longData($New['Data']),	$autoreNotizia);
				echo str_replace($searchNotizie ,$replaceNotizie,
				 	file_get_contents("../HTML/Template/TabellaNotizie.txt"));

			}
			$Notizie->free();
		}
		echo "</tbody></table></div>".

		file_get_contents("../HTML/Template/LinkAlMenu.txt").

		//Form inserimento notizia

		str_replace($searchInForm, $replaceInForm ,
		 	file_get_contents("../HTML/Template/FormInserimentoNotizia.txt")).


		"</div>".//Fine content
		file_get_contents("../HTML/Template/FileJs.txt").
		file_get_contents("../HTML/Template/Footer.txt");
		$db->close();
	}
	else{
		header("Location: page_not_found.php");
		exit();
	}
?>
