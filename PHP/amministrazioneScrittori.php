<?php
	if(!isset($_SESSION))
		session_start();
	if($_SESSION['type'] == "admin"){
		Require_once('connect.php');
		Require_once('functions.php');

		if(isset($_POST['delete'])){
			$delete = "DELETE FROM `Scrittore` WHERE `Id` = '". $_POST['delete']. "'";
			$db->query($delete);
		}

		$errore=false;
		$nazione = (isset($_POST['nazionalita']))?
			campoNonVuoto($errore,$_POST['nazionalita']) : "" ;
		$searchInForm=array("{{NomeError}}","{{CognomeError}}",
			"{{NazioneError}}","{{DataError}}");
		$replaceInForm=array(testNome($errore), testCognome($errore),$nazione,
						testDate($errore));

		if(!$errore && isset($_POST['nome']) && isset($_POST['cognome'])
			&& isset($_POST['data']) && isset($_POST['nazionalita']))
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
				if (file_exists($_FILES['img']['tmp_name']) &&
					is_uploaded_file($_FILES['img']['tmp_name'])){

					if ($Scrittori = $db->query($queryCercaAutore))
						if($Scrittore = $Scrittori->fetch_array(MYSQLI_ASSOC)){

							$autore = $Scrittore['Id'];
							$erroreFile = false;
							$target_dir = "../img/autori/";
							$target_file = $target_dir . basename($_FILES["img"]["name"]);

							$query = "INSERT INTO `FotoAutori`(Autore,Foto)
								VALUES ('". $autore.  "','".$target_file."')";

							$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

							if($_FILES["img"]["size"] > 500000 && $imageFileType != "jpg"
								&& $imageFileType != "png" && $imageFileType != "jpeg"
								&& $imageFileType != "gif" ) {
								$erroreFile = true;
							}

			    			if (!$erroreFile &&
								move_uploaded_file($_FILES["img"]["tmp_name"],
								$target_file)) {
								$db->query($query);
							}
						}
					}//fine if (file_exists($_FILES...
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
