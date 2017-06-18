<?php
	Require_once('connect.php');
	if(isset($_REQUEST['news']) && $datiNews = $db->query("SELECT * FROM Notizie JOIN FotoNotizie ON (Notizie.Id = FotoNotizie.Notizia) WHERE id = '". ($_REQUEST['news'])."'")) {
		Require_once('functions.php');

		
		$codice = $_REQUEST['news'];
		$errore ="";

		if(!isset($_SESSION))
        	session_start();

		
		
		//Azioni form
		if(isset($_SESSION['id'])){
			//Inserimento commento
			if(isset($_POST['text']) && !$_POST['text']==""){
				$autore = $_SESSION['id'];
				$ntesto ="<p>". strip_tags(htmlentities($_POST['text'])). "</p>";
				$sql = "INSERT INTO CommentiNews (News,Autore,Commento)
						VALUES ('$codice','$autore','$ntesto');";
				if(!$db->query($sql)){
					$errore = "<p>Problema inserimento commento</p>";
				}
			}
			//Eliminazione Commento
			else if(isset($_POST['deleteUser'])) {
				$deleteautore = $_POST['deleteUser'];
				$ndata = $_POST['deleteData'];
				$sql = "DELETE FROM `CommentiNews` WHERE `CommentiNews`.`News` = '$codice'
						AND `CommentiNews`.`Autore` = '$deleteautore'
						AND `CommentiNews`.`Data_Pubblicazione` = '$ndata'";

				if(!$db->query($sql)){
					$errore = "<p>Problema eliminazione commento</p>";
				}
			}
		}//Fine azioni form

		
		if($datiNews->num_rows > 0) {
			$datiN = $datiNews->fetch_array(MYSQLI_ASSOC);
			$autoreNome = "";
			$autoreCognome = "";
			
			//DATI AUTORE della NEWS
			if($autoreArray = $db->query("SELECT Nome,Cognome,Email FROM Redazione WHERE Email = '". $datiN['Autore']. "'")){
				if($autoreArray->num_rows > 0) {
					$autore = $autoreArray->fetch_array(MYSQLI_ASSOC);
					$autoreNome = $autore['Nome'];
					$autoreCognome = $autore['Cognome'];
				}
			}
			
			$searchHead=array("{{title}}","{{description}}");
			$replaceHead=array(strip_tags($datiN['Titolo']). " - ","Social network per topi di bibblioteca/>");
			echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));
			
			echo menu();

			$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
			$replaceBreadcrumb=array("","<span xml:lang='en'> <a href='index.php'>Home</a></span> > <span xml:lang='en'><a href='news.php'>News</a></span> > ". strip_tags($datiN['Titolo']));
			echo str_replace($searchBreadcrumb ,$replaceBreadcrumb, file_get_contents("../HTML/Template/Breadcrumb.txt"));

			$searchHeader=array("{{errore}}","{{Path}}","{{Titolo}}","{{IdAutore}}","{{Testo}}","{{Cognome}}","{{Nome}}");
			$replaceHeader=array($errore,$datiN['Foto'],strip_tags($datiN['Titolo']),$datiN['Autore'],$datiN['Testo'],$autoreNome,$autoreCognome);
			echo str_replace($searchHeader ,$replaceHeader, file_get_contents("../HTML/Template/IntestazioneNews.txt"));

		}
		
		
		$datiNews->free();
		$autoreArray->free();

		// SEZIONE COMMENTI

		if ($datiCommenti = $db->query("SELECT * FROM CommentiNews WHERE News = '". $codice. "' ORDER BY Data_Pubblicazione DESC")) {
			if($datiCommenti->num_rows>0) {
				echo "<h2>Commenti</h2>";
				echo "<div class='comments'>";
				$id = 0;
				while ($Commento = $datiCommenti->fetch_array(MYSQLI_ASSOC)) {
					if($Utentecm = $db->query("SELECT Nickname FROM Utente WHERE Email = '". $Commento['Autore']. "'")){
						$Utente = $Utentecm->fetch_array(MYSQLI_ASSOC);
						$username = $Utente['Nickname'];
						$Utentecm->free();
					}
					//Caso in cui l'utente che ha commentato non sia nel database
					else {$username = "Utente sconosciuto";}
					echo "<div class = 'comment'> <div class = 'commentTitle'>";

					//Form eliminazione commento
					//Gli unici che possono cancellare un commento solo l'autore del commento oppure un amministratore
					if(isset($_SESSION['type']) && ($Commento['Autore'] == $_SESSION['id'] || $_SESSION['type'] == 'admin' )) {
						$searchDeleteCommento=array("{{codice}}","{{Autore}}", "{{Data}}", "{{IdCommento}}");
						$replaceDeleteCommento=array($codice,$Commento['Autore'], $Commento['Data_Pubblicazione'], $id);
						echo str_replace($searchDeleteCommento ,$replaceDeleteCommento, file_get_contents("../HTML/Template/DeleteNews.txt"));
					}
					
					$searchCommento=array("{{Username}}", "{{Data}}", "{{Testo}}");
					$replaceCommento=array($username, Data($Commento['Data_Pubblicazione'], true), $Commento['Commento']);
					echo str_replace($searchCommento, $replaceCommento, file_get_contents("../HTML/Template/CommentoNotizia.txt"));
					$id += 1;
				} //Fine ciclo

			echo "</div>";// Fine class comments
			}
		$datiCommenti->free();
		}
		
		//Form inserimento commenti (solo per un utente loggato)

		if(isset($_SESSION['type']) &&  $_SESSION['type'] == 'user'){
			$searchNuovoCommento=array("{{codice}}");
			$replaceNuovoCommento=array($codice);
			echo str_replace($searchNuovoCommento ,$replaceNuovoCommento, file_get_contents("../HTML/Template/AddCommentoNews.txt"));
		}

		echo "</div>"; // Fine class text

		
		$db->close();
		echo "</div>"; //Fine classe content
		echo file_get_contents("../HTML/Template/Footer.txt");

	} //end if(isset($_REQUEST['news']) && !$datiNews)
	else {
		header("Location: page_not_found.php");
		exit();
	}
	exit;
?>
