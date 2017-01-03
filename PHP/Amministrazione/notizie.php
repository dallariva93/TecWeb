<?php

	Require_once('../connect.php');
	Require_once('../functions.php');

	echo file_get_contents("../../HTML/Template/HeadAdmin.txt");
			
			echo "<title>Notizie - SUCH WOW </title>","</head>";

			echo menuAdmin();

			echo 	"<div class='breadcrumb centrato'>
						<p class='path'>Ti trovi in: <span xml:lang='en'> <a href='../index.php'>Home</a></span>/<span><a href = 'amministrazione.php'>Amministrazione</a></span>/Notizie</p>";
						echo file_get_contents("../../HTML/Template/SearchAdmin.txt");
			echo "</div>";
			echo "<div class='centrato content'>";
			echo "<a href='#insert' id = 'new'>&#43;&nbsp;Nuova Notizia</a>";
			if($Notizie = $db->query("SELECT * FROM Notizie ORDER BY Data DESC")){
				echo "<div class='Table'><table summary = 'Elenco di tutte le notizie presenti nel sito'> 
				<thead>
					<tr>
						<th scope='col'>Id</th>
						<th scope='col'>Titolo</th>
						<th scope='col'>Autore</th>
						<th scope='col'>Data</th>
					</tr>
				</thead>
				<tbody>
				";
				while ($New = $Notizie->fetch_array(MYSQL_ASSOC)){
					echo "
					<tr>
						<td>".$New['Id']."</td>
						<td scope='row'><a href="."'.."."/new.php?id=".$New['Id']."'>".$New['Titolo']."</a></td>";

						if($autoreArray = $db->query("SELECT Nome,Cognome FROM Redazione WHERE Email =".$New['Autore']))
						{
							$autore = $autoreArray->fetch_array(MYSQL_ASSOC);
							echo "<td>".$autore['Nome']. " ". $autore['Cognome']."</td>";
							$autoreArray->free();
						}
						else {
							echo "<td>".$New['Autore']."</td>";
						}
						echo "<td>".$New['Data']."</td>
						
						<td>
							<form action='../Action/deleteNew.php' method='post' onclick='return confirm(\"Confermi di eliminare?\")'>
								<div >
									<input type = 'hidden' name = 'id' value = '". $New['Id']. "' />
									<input type ='submit' value='&#x2718;' class='btnDelete' />
				   	    		</div>
							</form>
						</td>
					</tr>";

				}
				$Notizie->free();
			}
			echo "</tbody></table></div>";

			echo "<a name = 'insert'></a>
			<div class='box'>
				<h1>Inserisci Notizia</h1>
				<form action='inserisci_notizia.php' method='post'>
					<div>
						<label for='id'>Codice Notizia</label>
						<input type='text' name='idnotizia' id='id'/>
						<label for='title'>Titolo Notizia</label>
						<input type='text' name='Titolo' id='title'/>
						<input type='hidden' name='autore' value=''/>
						<label for='testo'>Inserisci qui il tuo testo: </label>
						<textarea name='testo' id='testo' rows='4' cols='50'></textarea>	
	            		<input type='submit' value='Aggiungi' class='btnLong'/>
					</div>
				</form>
			</div>";
			echo "</div>";

		echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?>