
<?php
setcookie('admin', 'giorgiovanni63@gmail.com', time() + (86400 * 30), "/");
	Require_once('connect.php');
	if(isset($_REQUEST['libro']) && $datiLibro = $db->query("SELECT * FROM Libro WHERE ISBN = ". ($_REQUEST['libro']))) {
		Require_once('functions.php');

		$codice = $_REQUEST['libro'];
		$datiRecensione = $db->query("SELECT Id,Testo,Valutazione FROM Recensione WHERE Libro =". $codice);
		$datiRec = $datiRecensione->fetch_array(MYSQLI_ASSOC);
		$codiceRec = $datiRec['Id'];
		if($datiLibro->num_rows > 0) {

			$datiL = $datiLibro->fetch_array(MYSQLI_ASSOC);

			$autoreArray = $db->query("SELECT Nome,Cognome,Id FROM Scrittore WHERE Id = '". $datiL['Autore']. "'");
	
			$autore = $autoreArray->fetch_array(MYSQLI_ASSOC);
			
			
			echo file_get_contents("../HTML/Template/Head.txt");
			
			echo "<title>", $datiL['Titolo'], "- SUCH WOW </title>","</head>";

			echo menu();

			echo 	"<div class='breadcrumb centrato'>
						<p class='path'>Ti trovi in: <span xml:lang='en'> <a href='index.php'>Home</a></span>/". $datiL['Titolo']. "</p>";
						echo file_get_contents("../HTML/Template/Search.txt");
			echo "</div>";

			echo "	<div class='centrato presentazione content'>			

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
			if(isset($_COOKIE['user'])){

				//Voto al libro
				if($votoBook = $db->query("SELECT Valutazione FROM VotoLibro WHERE Libro ='". $codice. "' AND Autore ='". $_COOKIE['user']. "'")){
					if($votoBook->num_rows>0){
						$votoBookU = $votoBook->fetch_array(MYSQLI_ASSOC);
						echo "<p>Il tuo voto al libro: ". $votoBookU['Valutazione']. "/5</p>";
					}
					$votoBook->free();
				}

				//Voto alla recensione
				if($votoRecA = $db->query("SELECT Valutazione FROM VotoRecensione WHERE Recensione ='". $datiRec['Id']. "' AND Autore ='". $_COOKIE['user']. "'")){
					if($votoRecA->num_rows>0){
						$votoRecU = $votoRecA->fetch_array(MYSQLI_ASSOC);
						echo "<p>Il tuo voto alla recensione: ". $votoRecU['Valutazione']. "/5</p>";
					}
					$votoRecA->free();
				}
			} //Fine voti utente loggato
		

			 
			echo "
			<h2>Trama: </h2>";		
			echo $datiL['Trama'];
			echo "
			<h2>Recensione:</h2>";
			echo $datiRec['Testo'];
			

		} // FINE recensione

		$datiLibro->free();
		$autoreArray->free();
		$datiRecensione->free();


		// SEZIONE COMMENTI
	
		if ($datiCommenti = $db->query("SELECT * FROM Commenti WHERE Recensione = '". $codiceRec. "' ORDER BY Data_Pubblicazione DESC")) {
			if($datiCommenti->num_rows>0) {
				echo "<h2>Commenti</h2>";
				echo "<div class='comments'>";
				while ($Commento = $datiCommenti->fetch_array(MYSQLI_ASSOC)) {
					if($Utentecm = $db->query("SELECT Nickname FROM Utente WHERE Email = '". $Commento['Autore']. "'")){
						$Utente = $Utentecm->fetch_array(MYSQLI_ASSOC);
						$username = $Utente['Nickname'];
					}
					else {$username = "Utente sconosciuto";} //Caso in cui l'utente che ha commentato non sia nel database
					echo "<div class = 'comment'>
					<div class = 'commentTitle'>";

					//Form eliminazione commento
					//Gli unici che possono cancellare un commento solo l'autore del commento oppure un amministratore
					if((isset($_COOKIE['user']) && $Commento['Autore'] == $_COOKIE['user']) || isset($_COOKIE['admin'])) {
					echo "
						<form action='Action/deleteComment.php' method='post'>
							<div >
								<input type = 'hidden' name = 'user' value = '". $Commento['Autore']. "' />
								<input type = 'hidden' name = 'page' value = '". $codice. "' />
								<input type = 'hidden' name = 'rec' value = '". $Commento['Recensione']. "' />
								<input type ='hidden' name= 'data' value= '". $Commento['Data_Pubblicazione']. "' />
								<input type ='submit' value='&#x2718;' class='btnDelete' />
			   	    		</div>
						</form>


					";}
					echo "<div class='autoreCommento'>". $username."</div>";
					echo "</div>";//Fine class commentTitle
					echo $Commento['Commento']."</div>";//Fine class comment
				
				} //Fine ciclo

			echo "</div>";// Fine class comments
			}
		$datiCommenti->free();
		}
	
		//Form inserimento commenti (solo per un utente loggato)
	
		if(isset($_COOKIE['user'])){
			echo "
			<h3>Inserisci un commento</h3>
			<form action='Action/newComment.php' method='post'>
				<div >
					<input type = 'hidden' name = 'page' value = '". $codice. "' />
					<input type ='hidden' name= 'rec' value= '". $codiceRec. "' />
					<textarea id ='testo' name= 'text' rows='4' cols='20'></textarea>
					<input type ='submit' value='Invia!' class='btnShort' />
	    		</div>
			</form>";
		}

		echo "</div>"; // Fine class text
		
		//Voti dell' utente loggato al libro o alla recensione

		if(isset($_COOKIE['user'])){
			//Voto al libro
			echo "<div class='leftHalf'>";
				echo "<form action='Action/bookVote.php' method='post'>
					<fieldset>
					<legend>Vota il libro!</legend>
						<input type = 'hidden' name = 'pageB' value = '". $codice. "' />	
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
				
			echo "<div class='leftHalf'>";
			echo "<form action='Action/RecVote.php' method='post'>
				<fieldset>
				<legend>Vota la recensione!</legend>
					<input type = 'hidden' name = 'pageRec' value = '". $codice. "' />	
					<input type = 'hidden' name = 'rec' value = '". $codiceRec. "' />	
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
		
		echo "</div>"; //Fine classe content
		$db->close();	
		echo file_get_contents("../HTML/Template/Footer.txt");

	} // if(isset($_REQUEST['libro']) && !$datiLibro) 	
	else {
		header("Location: page_not_found.php");
	}
	exit;
?>