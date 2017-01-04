
<?php
setcookie('user', 'giorgiovanni63@gmail.com', time() + (86400 * 30), "/");
	Require_once('connect.php');
	if(isset($_REQUEST['libro'])){
		Require_once('functions.php');


		$codice = $_REQUEST['libro'];
		$datiLibro = $db->query("SELECT * FROM Libro WHERE ISBN = ". $codice);

		if($datiLibro->num_rows > 0){

			$datiL = $datiLibro->fetch_array(MYSQLI_ASSOC);

			$datiRecensione = $db->query("SELECT Id,Testo,Valutazione FROM Recensione WHERE Libro =". $codice);
			
			$autoreArray = $db->query("SELECT Nome,Cognome,Id FROM Scrittore WHERE Id = '". $datiL['Autore']. "'");

			$datiRec = $datiRecensione->fetch_array(MYSQLI_ASSOC);
				
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
							if($datiRec)
								echo "<p>Valutazione dalla redazione: <span>". $datiRec['Valutazione']. "/5 </span></p>";
								
								if($votoLibArray = $db->query("SELECT ROUND(AVG(Valutazione),1) AS Media FROM VotoLibro GROUP BY (Libro) HAVING Libro ='$codice'")){
									if($votoLibArray->num_rows>0){
										$votoLib = $votoLibArray->fetch_array(MYSQLI_ASSOC);
										echo "<p>Voto degli utenti: <span>". $votoLib['Media']. "/5 <span></p>";
									}
									$votoLibArray->free();
								}
								
								if($votoRecArray = $db->query("SELECT ROUND(AVG(Valutazione),1) AS Media FROM VotoRecensione GROUP BY (Recensione) HAVING Recensione ='".$datiRec['Id']."'")){
									if($votoRecArray->num_rows>0){
										$votoRec = $votoRecArray->fetch_array(MYSQLI_ASSOC);
										echo "<p>Voto alla recensione: <span>". $votoRec['Media']. "/5 <span></p>";
									}	
									$votoRecArray->free();
								}
								 
							echo "
							<h2>Trama: </h2>";
							
								echo $datiL['Trama'];
							if($datiRec){
							echo "
							<h2>Recensione:</h2>";
								echo $datiRec['Testo'];
						}
						
						echo "<h2>Commenti</h2>";
						


			
						if ($datiCommenti = $db->query("SELECT * FROM Commenti WHERE Recensione = '". $datiRec['Id']. "' ORDER BY Data_Pubblicazione DESC")) {
										if($datiCommenti->num_rows>0) {
											echo "<div class='comments'>";
											while ($Commento = $datiCommenti->fetch_array(MYSQLI_ASSOC)) {
												if($Utentecm = $db->query("SELECT Nickname FROM Utente WHERE Email = '". $Commento['Autore']. "'")){
													$Utente = $Utentecm->fetch_array(MYSQLI_ASSOC);
													$username = $Utente['Nickname'];
												}
												else {$username = "Utente sconosciuto";}
												echo "<div class = 'comment'>
												<div class = 'commentTitle'>";
												if((isset($_COOKIE['user']) && $Commento['Autore'] == $_COOKIE['user']) || isset($_COOKIE['admin'])) {
												echo "
													<form action='Action/deleteComment.php' method='post'>
														<div >
															<input type = 'hidden' name = 'page' value = '". $codice. "' />
															<input type = 'hidden' name = 'rec' value = '". $Commento['Recensione']. "' />
															<input type ='hidden' name= 'data' value= '". $Commento['Data_Pubblicazione']. "' />
															<input type ='submit' value='&#x2718;' class='btnDelete' />
										   	    		</div>
													</form>


												";}
												echo "<div class='autoreCommento'>". $Utente['Nickname']."</div>";
												echo "</div>";//commentTitle
												echo $Commento['Commento']."</div>";//comment
											}

										echo "</div>";//comments
										}
									}
						
						if(isset($_COOKIE['user'])){
						echo "
						<h3>Inserisci un commento</h3>
						<form action='Action/newComment.php' method='post'>
							<div >
								<input type = 'hidden' name = 'page' value = '". $codice. "' />
								<input type ='hidden' name= 'rec' value= '". $datiRec['Id']. "' />
								<textarea id ='testo' name= 'text' rows='4' cols='20'></textarea>
								<input type ='submit' value='Invia!' class='btnShort' />
			   	    		</div>
						</form>";


						echo "<div class='box leftHalf'>
						<h3>Vota il libro!</h3>";
						if($votoBook = $db->query("SELECT Valutazione FROM VotoLibro WHERE Libro ='". $codice. "' AND Autore ='". $_COOKIE['user']. "'")){
							if($votoBook->num_rows>0){
								$votoBookU = $votoBook->fetch_array(MYSQLI_ASSOC);
								echo "Voto dato: ". $votoBookU['Valutazione']. "/5";
							}
							$votoBook->free();
						}
							echo "<form action='Action/bookVote.php' method='post'>
								<div>
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
								</div>
							</form>
							</div>

						";


						echo "<div class='box leftHalf'>
							<h3>Vota la recensione!</h3>";
							if($votoRecA = $db->query("SELECT Valutazione FROM VotoRecensione WHERE Recensione ='". $datiRec['Id']. "' AND Autore ='". $_COOKIE['user']. "'")){
								if($votoRecA->num_rows>0){
									$votoRecU = $votoRecA->fetch_array(MYSQLI_ASSOC);
									echo "Voto dato: ". $votoRecU['Valutazione']. "/5";
								}
								$votoRecA->free();
							}

							echo "<form action='Action/RecVote.php' method='post'>
								<div>
									<input type = 'hidden' name = 'pageRec' value = '". $codice. "' />	
									<input type = 'hidden' name = 'rec' value = '". $datiRec['Id']. "' />	
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
								</div>
							</form>
							</div>

						";
				}
				echo "</div>";



				echo "</div>"; // Fine Libro
				




			
			echo file_get_contents("../HTML/Template/Footer.txt");
			



			$datiLibro->free();
			$autoreArray->free();
			$datiRecensione->free();
			$datiCommenti->free();

			$db->close();
		}
		else
			{
				header("Location: page_not_found.php");}
			}
	else {
		header("Location: page_not_found.php");
	}
	exit;
?>