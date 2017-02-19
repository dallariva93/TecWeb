
<?php
	Require_once('connect.php');
	if(isset($_REQUEST['libro']) && $datiLibro = $db->query("SELECT * FROM Libro WHERE ISBN = ". ($_REQUEST['libro']))) {
		Require_once('functions.php');

		$codice = $_REQUEST['libro'];
		$datiRecensione = $db->query("SELECT Id,Testo,Valutazione FROM Recensione WHERE Libro =". $codice);
		$datiRec = $datiRecensione->fetch_array(MYSQLI_ASSOC);
		$codiceRec = $datiRec['Id'];
		$errore ="";

		//Azioni form
		if(isset($_SESSION['type'])){
			//Inserimento commento
			if(isset($_POST['text']) && !$_POST['text']==""){
				$autore = $_SESSION['id'];
				$ntesto ="<p>". strip_tags(htmlentities($_POST['text'])). "</p>";
				$sql = "INSERT INTO Commenti (Recensione,Autore,Commento) VALUES ('$codiceRec','$autore','$ntesto');";
				if(!$db->query($sql)){
					$errore = "<p>Problema inserimento commento</p>";
				}
			}
			//Eliminazione Commento
			if(isset($_POST['deleteUser'])) {
				$deleteautore = $_POST['deleteUser'];
				$ndata = $_POST['deleteData'];
				$sql = "DELETE FROM `Commenti` WHERE `Commenti`.`Recensione` = '$codiceRec' AND `Commenti`.`Autore` = '$deleteautore' AND `Commenti`.`Data_Pubblicazione` = '$ndata'";
				if(!$db->query($sql)){
					$errore = "<p>Problema cancellamento commento</p>";
				}
			}
			//Voto libro
			if(isset($_POST['valutazioneB'])){
				$val = $_POST['valutazioneB'];
				$autoreB = $_SESSION['id'];
				$clean ="DELETE FROM VotoLibro WHERE Autore = '$autoreB' AND Libro = '$codice';";
				$db->query($clean);
				$sql = "INSERT INTO VotoLibro (Libro,Autore,Valutazione) VALUES ('$codice','$autoreB','$val');";
				if(!$db->query($sql)){
					$errore = "<p>Problema inserimento voto</p>";
				}
			}
			//Voto recensione
			if(isset($_POST['valutazioneRec'])){
				$autore = $_SESSION['id'];
				$val = $_POST['valutazioneRec'];
				$clean ="DELETE FROM VotoRecensione WHERE Autore = '$autore' AND Recensione = '$codiceRec';";
				$db->query($clean);
				$sql = "INSERT INTO VotoRecensione (Recensione,Autore,Valutazione) VALUES ('$codiceRec','$autore','$val');";
				if(!$db->query($sql)){
					$errore = "<p>Problema inserimento voto</p>";
				}
			}
		}//Fine azioni form

		if($datiLibro->num_rows > 0) {

			$datiL = $datiLibro->fetch_array(MYSQLI_ASSOC);

			$autoreArray = $db->query("SELECT Nome,Cognome,Id FROM Scrittore WHERE Id = '". $datiL['Autore']. "'");

			$autore = $autoreArray->fetch_array(MYSQLI_ASSOC);

			$replaceHead=array("<title>". $datiL['Titolo']. " - FaceOnTheBook </title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
			$searchHead=array("{{title}}","{{description}}");
			echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

			echo menu().

			"<div class='breadcrumb centrato'>
			<p class='path'>Ti trovi in: <span xml:lang='en'> <a href='index.php'>Home</a></span>/". $datiL['Titolo']. "</p>".
			file_get_contents("../HTML/Template/Search.txt").
			"</div>".

			"<div class='centrato presentazione content'>".
			$errore.
			"
			<div class='text'>
			<img class='VleftSmall' src='../img/cover/". $datiL['ISBN'].  ".jpg' alt=''/>
			<h1>". $datiL['Titolo']. "</h1>
			<h2><a href='autore.php?autore=".$autore['Id']."'>". $autore['Nome']. " ". $autore['Cognome'].  "</a></h2>
			";
		}
		if($datiRec) { //Stampa della recensione e dei suoi dati

			//Voto al libro dato dalla redazione
			echo "<p>Valutazione dalla redazione: ". $datiRec['Valutazione']. "/5</p>";

			//Voto al libro dato dalla media dei voti al libro degli utenti
			if($votoLibArray = $db->query("SELECT ROUND(AVG(Valutazione),1) AS Media FROM VotoLibro GROUP BY (Libro) HAVING Libro ='$codice'")){
				if($votoLibArray->num_rows>0){
					$votoLib = $votoLibArray->fetch_array(MYSQLI_ASSOC);
					echo "<p>Voto degli utenti: ". $votoLib['Media']. "/5</p>";
				}
				$votoLibArray->free();
			}

			//Voto alla recensione dato dalla media dei voti alla recensione degli utenti
			if($votoRecArray = $db->query("SELECT ROUND(AVG(Valutazione),1) AS Media FROM VotoRecensione GROUP BY (Recensione) HAVING Recensione ='".$datiRec['Id']."'")){
				if($votoRecArray->num_rows>0){
					$votoRec = $votoRecArray->fetch_array(MYSQLI_ASSOC);
					echo "<p>Voto alla recensione: ". $votoRec['Media']. "/5</p>";
				}
				$votoRecArray->free();
			}

			//Voti dell' utente loggato
			if(isset($_SESSION['type'])){

				//Voto al libro
				if($votoBook = $db->query("SELECT Valutazione FROM VotoLibro WHERE Libro ='". $codice. "' AND Autore ='". $_SESSION['id']. "'")){
					if($votoBook->num_rows>0){
						$votoBookU = $votoBook->fetch_array(MYSQLI_ASSOC);
						echo "<p>Il tuo voto al libro: ". $votoBookU['Valutazione']. "/5</p>";
					}
					$votoBook->free();
				}

				//Voto alla recensione
				if($votoRecA = $db->query("SELECT Valutazione FROM VotoRecensione WHERE Recensione ='". $datiRec['Id']. "' AND Autore ='". $_SESSION['id']. "'")){
					if($votoRecA->num_rows>0){
						$votoRecU = $votoRecA->fetch_array(MYSQLI_ASSOC);
						echo "<p>Il tuo voto alla recensione: ". $votoRecU['Valutazione']. "/5</p>";
					}
					$votoRecA->free();
				}
			} //Fine voti utente loggato



			echo "
			<h2>Trama: </h2>".
			$datiL['Trama']. "
			<h2>Recensione:</h2>".
			$datiRec['Testo'];


		} // FINE recensione

		$datiLibro->free();
		$autoreArray->free();
		$datiRecensione->free();


		// SEZIONE COMMENTI

		if ($datiCommenti = $db->query("SELECT * FROM Commenti WHERE Recensione = '". $codiceRec. "' ORDER BY Data_Pubblicazione DESC")) {
			if($datiCommenti->num_rows>0) {
				echo "<h2>Commenti</h2>
							<div class='comments'>";
				while ($Commento = $datiCommenti->fetch_array(MYSQLI_ASSOC)) {
					if($Utentecm = $db->query("SELECT Nickname FROM Utente WHERE Email = '". $Commento['Autore']. "'")){
						$Utente = $Utentecm->fetch_array(MYSQLI_ASSOC);
						$username = $Utente['Nickname'];
						$Utentecm->free();
					}
					else {$username = "Utente sconosciuto";} //Caso in cui l'utente che ha commentato non sia nel database
					echo "<div class = 'comment'>
					<div class = 'commentTitle'>";

					//Form eliminazione commento
					//Gli unici che possono cancellare un commento solo l'autore del commento oppure un amministratore
					if(isset($_SESSION['type']) && ($Commento['Autore'] == $_SESSION['id'] || $_SESSION['type'] == 'admin' )) {
					echo "
						<form action='libro.php?libro=". $codice."' method='post'>
							<div >
								<input type = 'hidden' name = 'deleteUser' value = '". $Commento['Autore']. "' />
								<input type ='hidden' name= 'deleteData' value= '". $Commento['Data_Pubblicazione']. "' />
								<input type ='submit' value='&#x2718;' class='btnDelete' />
			   	    		</div>
						</form>";
					}
					echo "<div class='autoreCommento'>". $username."</div>".
					"</div>".//Fine class commentTitle
					$Commento['Commento']."</div>";//Fine class comment

				} //Fine ciclo

			echo "</div>";// Fine class comments
			}
		$datiCommenti->free();
		}

		//Form inserimento commenti (solo per un utente loggato)

		if(isset($_SESSION['type']) &&  $_SESSION['type'] == 'user'){
			echo "
			<h3>Inserisci un commento</h3>
			<form action='libro.php?libro=". $codice. "' method='post'>
				<div >
					<textarea id ='testo' name= 'text' rows='4' cols='20'></textarea>
					<input type ='submit' value='Invia!' class='btnShort' />
	    		</div>
			</form>";
		}

		echo "</div>"; // Fine class text

		//Voti dell' utente loggato al libro o alla recensione

		if(isset($_SESSION['type']) &&  $_SESSION['type'] == 'user'){
			//Voto al libro
			echo "<div class='leftHalf'>
				<form action='libro.php?libro=".$codice."' method='post'>
					<fieldset>
					<legend>Vota il libro!</legend>
						<label for='valutazioneB'>valutazione
							<select name='valutazioneB' id='valutazioneB'>
								<option>1</option>
								<option>1.5</option>
								<option>2</option>
								<option>2.5</option>
								<option>3</option>
								<option>3.5</option>
								<option>4</option>
								<option>4.5</option>
								<option>5</option>
							</select>
						</label>
	            		<input type='submit' value='Aggiungi' class='btnShort'/>
					</fieldset>
				</form>
				</div>
			";

			//Voto alla recensione

			echo "<div class='leftHalf'>
			<form action='libro.php?libro=".$codice."' method='post'>
				<fieldset>
				<legend>Vota la recensione!</legend>
					<label for='valutazioneRec'>valutazione
						<select name='valutazioneRec' id='valutazioneRec'>
							<option>1</option>
							<option>1.5</option>
							<option>2</option>
							<option>2.5</option>
							<option>3</option>
							<option>3.5</option>
							<option>4</option>
							<option>4.5</option>
							<option>5</option>
						</select>
					</label>
	        		<input type='submit' value='Aggiungi' class='btnShort'/>
				</fieldset>
			</form>
			</div>

			";
		} //Fine voti libro/recensione
		$db->close();
		echo "</div>". //Fine classe content
		file_get_contents("../HTML/Template/Footer.txt");

	} // if(isset($_REQUEST['libro']) && !$datiLibro)
	else {
		header("Location: page_not_found.php");
		exit();
	}
	exit;
?>
