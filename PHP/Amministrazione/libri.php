<?php

	Require_once('../connect.php');
	Require_once('../functions.php');

	echo file_get_contents("../../HTML/Template/HeadAdmin.txt");
			
			echo "<title>Libri - SUCH WOW </title>","</head>";

			echo menuAdmin();

			echo 	"<div class='breadcrumb centrato'>
						<p class='path'>Ti trovi in: <span xml:lang='en'> <a href='../index.php'>Home</a></span>/<span><a href = 'amministrazione.php'>Amministrazione</a></span>/Libri</p>";
						echo file_get_contents("../../HTML/Template/SearchAdmin.txt");
			echo "</div>";
			echo "<div class='centrato content'>";
			echo "<a href='#insert' id = 'new'>&#43;&nbsp;Nuovo Libro</a>";
			if($Libri = $db->query("SELECT * FROM Libro ORDER BY Titolo")){
				echo "<div class='Table'><table summary = 'Elenco di tutti i libri nel sito'> 
				<thead>
					<tr>
						<th scope='col'>ISBN</th>
						<th scope='col'>Titolo</th>
						<th scope='col'>Autore</th>
						<th scope='col'>Anno di Pubblicazione</th>
						<th scope='col'>Casa Editrice</th>
						<th scope='col'>Genere</th>
					</tr>
				</thead>
				<tbody>
				";
				while ($Libro = $Libri->fetch_array(MYSQL_ASSOC)){
					echo "
					<tr>
						<td scope='row'>".$Libro['ISBN']."</td>
						<td scope='row'>".$Libro['Titolo']."</td>";

						if($autoreArray = $db->query("SELECT Nome,Cognome FROM Scrittore WHERE Id =".$Libro['Autore']))
						{
							$autore = $autoreArray->fetch_array(MYSQL_ASSOC);
							echo "<td>".$autore['Nome']. " ". $autore['Cognome']."</td>";
						$autoreArray->free();}
						else{echo "<td scope='row'>".$Libro['Autore']."</td>";}
						echo "<td scope='row'>".Data($Libro['Anno_Pubblicazione'])."</td>
						<td scope='row'>".$Libro['Casa_Editrice']."</td>
						<td scope='row'>".$Libro['Genere']."</td>
						<td>
							<form action='../Action/deleteBook.php' method='post' onclick='return confirm(\"Confermi di eliminare?\")'>
								<div >
									<input type = 'hidden' name = 'id' value = '". $Libro['ISBN']. "' />
									<input type ='submit' value='&#x2718;' class='btnDelete' />
				   	    		</div>
							</form>
						</td>
					</tr>";

				}

				$Libri->free();
			
			}
			echo "</tbody></table></div>";
			

			echo "<a name = 'insert'></a>
			<div class='box'>
				<h1>Inserisci libro </h1>
				<form action='inserisci_libro.php' method='post'>
					<div>
						<label for='isbn'>ISBN</label>
						<input type='text' name='isbn' id='isbn'/>
						<label for='titolo'>Titolo</label>
						<input type='text' name='titolo' id='titolo'/>
						<label for='autore' >Codice Autore</label>
						<input type='text' name='autore' id='autore'/>
						<label for='anno' >Data Pubblicazione</label>
						<input type='text' name='anno' id='anno'/>
			        	<label for='casa'>Casa editrice</label>
						<input type='text' name='casa' id='casa'/>
						<label for='trama' >Trama</label> 
						<textarea name='trama' id='trama' rows='4' cols='50'/></textarea>
						<label for='genere'>Genere 
							<select name='genere' id='genere'>
								<option>Commedia</option>
								<option>Thriller</option>
								<option>Horror</option>
								<option>Fantasy</option>
								<option>Narrativa</option>
								<option>Saggistica</option>
								<option>Classico</option>
								<option>Fantascienza</option>
							</select>
						</label>
						<input type='submit' value='Inserisci' class='btnLong'/>
					</div>
				</form>
			</div>";



			echo "</div>";

		echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?>