<?php
	if(!isset($_SESSION))
		session_start();
	if($_SESSION['type'] == "admin"){
		Require_once('connect.php');
		Require_once('functions.php');

		if(isset($_POST['delete'])){
			$delete = "DELETE FROM `Scrittore` WHERE `Id` = '". $_POST['delete']. "'";

			$searchImage = "SELECT Foto FROM FotoAutori WHERE Autore = '".
				$_POST['delete']."'";

			if ($Images = $db->query($searchImage))
				if($image = $Images->fetch_array(MYSQLI_ASSOC)){
					if (unlink($image['Foto']))
						$db->query($delete);
				}
		}

		$errore=false;
		//Vengono fatti controlli meno severi per permettere all'amministratore
		//di inserire anche tag HTML dove necessario
		$nazione = (isset($_POST['nazionalita']))?
			campoNonVuoto($errore,$_POST['nazionalita']) : "" ;
		$nome = (isset($_POST['nome']))?
			campoNonVuoto($errore,$_POST['nome']) : "" ;
		$cognome = (isset($_POST['cognome']))?
			campoNonVuoto($errore,$_POST['cognome']) : "" ;
		$testo = (isset($_POST['testo']))? campoNonVuoto($errore,$_POST['testo']) : "" ;

		$searchInForm=array("{{NomeError}}","{{CognomeError}}",
			"{{NazioneError}}","{{DataError}}","{{FileError}}","{{TestoError}}");
		$replaceInForm=array($nome, $cognome,$nazione,
						testDate($errore),testImage($errore),$testo);

		if(!$errore && isset($_POST['nome']) && isset($_POST['cognome'])
			&& isset($_POST['data']) && isset($_POST['nazionalita']) &&
			isset($_POST['testo']) && isset($_FILES['img']) &&
			file_exists($_FILES['img']['tmp_name']) &&
			is_uploaded_file($_FILES['img']['tmp_name']))
		{
			$insert="INSERT INTO `Scrittore`(Nome, Cognome,Data_Nascita
				,Nazionalita) VALUES ('".$_POST['nome']."','".$_POST['cognome'].
					"','".GetData($_POST['data'])."','".$_POST['nazionalita']."')";

			if($db->query($insert)){

				$queryCercaAutore = "SELECT Id FROM Scrittore WHERE Nome =
					'". $_POST['nome']. "' AND Cognome = '". $_POST['cognome'].
					"' AND Data_Nascita = '". GetData($_POST['data']). "' AND
					Nazionalita = '".$_POST['nazionalita']. "'";


				//Inserimento immagine

				$target_file = "../img/autori/" . basename($_FILES["img"]["name"]);
				$Id = $db->insert_id;
				$queryFile = "INSERT INTO `FotoAutori`(Autore,Foto)
					VALUES ('". $Id.  "','".$target_file."')";

    			if (move_uploaded_file($_FILES["img"]["tmp_name"],
					$target_file)) {
					$db->query($queryFile);
				}
				//Inserimento descrizione
				$descrizione = "INSERT INTO `DescrizioneAutore`
					(Autore,Testo) VALUES ('".$Id."','".
						$_POST['testo']."')";
				$db->query($descrizione);

			}//fine if($db->query($insert)){
		}// fine if(!$errore...

		$searchHead=array("{{title}}","{{description}}");
		$replaceHead=array("Amministrazione Scrittori - ",
			"Pagina per la gestione degli scrittori su FaceOnTheBook");
		echo str_replace($searchHead ,$replaceHead,
			file_get_contents("../HTML/Template/Head.txt"));

		echo menu();

		$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
		$replaceBreadcrumb=array("","<span xml:lang='en'>
			<a href='index.php'>Home</a></span> > <span>
			<a href='amministrazione.php'>Amministrazione</a></span> > Scrittori");
		echo str_replace($searchBreadcrumb ,$replaceBreadcrumb,
			file_get_contents("../HTML/Template/Breadcrumb.txt")).

		"<div class='centrato content'>
		<a name = 'top'></a>
		<a href = '#insert' class = 'adminButton'>&#43;&nbsp;Nuovo Scrittore</a>";
		if($Scrittori = $db->query("SELECT * FROM Scrittore ORDER BY Cognome")){
			echo file_get_contents("../HTML/Template/InizioTabellaScrittore.txt");
			while ($Scrittore = $Scrittori->fetch_array(MYSQLI_ASSOC)){
				$search=array("{{Cognome}}","{{Nome}}","{{Data}}","{{Nazionalita}}"
					,"{{Id}}");
				$replace=array($Scrittore['Cognome'],$Scrittore['Nome'],
					Data($Scrittore['Data_Nascita']),$Scrittore['Nazionalita'],
					$Scrittore['Id']);
				echo str_replace($search ,$replace,
					file_get_contents("../HTML/Template/TabellaScrittore.txt"));
			}
			$Scrittori->free();
		}
		echo "</tbody></table></div>".

		file_get_contents("../HTML/Template/LinkAlMenu.txt");

		//Form inserimento
		echo str_replace($searchInForm, $replaceInForm ,
			file_get_contents("../HTML/Template/FormInserimentoScrittore.txt"));

		$db->close();

		echo "</div>". //Fine content
		file_get_contents("../HTML/Template/FileJs.txt").
		file_get_contents("../HTML/Template/Footer.txt");
	}
	else{
		header("Location: page_not_found.php");
		exit();
	}
?>
