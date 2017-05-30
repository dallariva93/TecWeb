<?php
	Require_once('connect.php');
	if(isset($_REQUEST['news']) && $datiNews = $db->query("SELECT * FROM Notizie WHERE id = '". ($_REQUEST['news'])."'")) {
		Require_once('functions.php');

		$codice = $_REQUEST['news'];
		$errore ="";

		if(!isset($_SESSION))
        	session_start();

		
		/*
		
		//Azioni form
		if(isset($_SESSION['id'])){
			//Inserimento commento
			if(isset($_POST['text']) && !$_POST['text']==""){
				$autore = $_SESSION['id'];
				$ntesto ="<p>". strip_tags(htmlentities($_POST['text'])). "</p>";
				$sql = "INSERT INTO Commenti (Recensione,Autore,Commento)
						VALUES ('$codiceRec','$autore','$ntesto');";
				if(!$db->query($sql)){
					$errore = "<p>Problema inserimento commento</p>";
				}
			}
			//Eliminazione Commento
			else if(isset($_POST['deleteUser'])) {
				$deleteautore = $_POST['deleteUser'];
				$ndata = $_POST['deleteData'];
				$sql = "DELETE FROM `Commenti` WHERE `Commenti`.`Recensione` = '$codiceRec'
						AND `Commenti`.`Autore` = '$deleteautore'
						AND `Commenti`.`Data_Pubblicazione` = '$ndata'";

				if(!$db->query($sql)){
					$errore = "<p>Problema eliminazione commento</p>";
				}
			}
		}//Fine azioni form

		*/
		
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
			$replaceHead=array("<title>". $datiN['Titolo']. " - FaceOnTheBook </title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
			echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));
			
			echo menu();

			$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
			$replaceBreadcrumb=array("","<span xml:lang='en'> <a href='index.php'>Home</a></span>/". $datiN['Titolo']);
			echo str_replace($searchBreadcrumb ,$replaceBreadcrumb, file_get_contents("../HTML/Template/Breadcrumb.txt"));

			$searchHeader=array("{{errore}}","{{IdNews}}","{{Titolo}}","{{IdAutore}}","{{Cognome}}","{{Nome}}");
			$replaceHeader=array($errore,$datiN['Id'],$datiN['Titolo'],$datiN['Autore'],$autoreNome,$autoreCognome);
			echo str_replace($searchHeader ,$replaceHeader, file_get_contents("../HTML/Template/IntestazioneNews.txt"));

		}
		if($datiNews) { //Stampa testo della Notizia
			echo $datiN['Testo'];

		} // fine stampa della notizia

		$datiNews->free();
		$autoreArray->free();


		// SEZIONE COMMENTI

		if ($datiCommenti = $db->query("SELECT * FROM Commenti WHERE Recensione = '". $codiceRec. "'
										ORDER BY Data_Pubblicazione DESC")) {
			if($datiCommenti->num_rows>0) {
				echo "<h2>Commenti</h2>";
				echo "<div class='comments'>";
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
						$searchDeleteCommento=array("{{codice}}","{{Autore}}", "{{Data}}");
						$replaceDeleteCommento=array($codice,$Commento['Autore'], $Commento['Data_Pubblicazione']);
						echo str_replace($searchDeleteCommento ,$replaceDeleteCommento, file_get_contents("../HTML/Template/DeleteLibro.txt"));
					}
					echo "<div class='autoreCommento'>". $username."</div>";
					echo "</div>";//Fine class commentTitle
					echo $Commento['Commento']."</div>";//Fine class comment

				} //Fine ciclo

			echo "</div>";// Fine class comments
			}
		$datiCommenti->free();
		}

		//Form inserimento commenti (solo per un utente loggato)

		if(isset($_SESSION['type']) &&  $_SESSION['type'] == 'user'){
			$searchNuovoCommento=array("{{codice}}");
			$replaceNuovoCommento=array($codice);
			echo str_replace($searchNuovoCommento ,$replaceNuovoCommento, file_get_contents("../HTML/Template/AddCommento.txt"));
		}

		echo "</div>"; // Fine class text

		
		$db->close();
		echo "</div>". //Fine classe content
		file_get_contents("../HTML/Template/Footer.txt");

	} //end if(isset($_REQUEST['news']) && !$datiNews)
	else {
		header("Location: page_not_found.php");
		exit();
	}
	exit;
?>