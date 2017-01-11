<?php

	Require_once('../connect.php');
	Require_once('../functions.php');

	echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

	echo "<title>Libri - SUCH WOW </title>","</head>";

	echo menuAdmin();

	echo "<div class='breadcrumb centrato'>
		<p class='path'>Ti trovi in: <span xml:lang='en'> <a href='../index.php'>Home</a></span>/<span><a href='amministrazione.php'>Amministrazione</a></span>/Libri</p>";
	echo file_get_contents("../../HTML/Template/SearchAdmin.txt");
	echo "</div>";//Fine breadcrump
	echo "<div class='centrato content'>";

	echo "<a href='#insert' id = 'new'>&#43;&nbsp;Nuovo Libro</a>";
	//Stampa tutti i libri in una tabella
	if($Libri = $db->query("SELECT * FROM Libro ORDER BY Titolo")){
		echo "<div class='Table'>
		<table summary = 'Elenco di tutti i libri nel sito'>
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
		while ($Libro = $Libri->fetch_array(MYSQLI_ASSOC)){
			echo "<tr>
			<td scope='row'>".$Libro['ISBN']."</td>
			<td scope='row'>".$Libro['Titolo']."</td>";

			if($autoreArray = $db->query("SELECT Nome,Cognome FROM Scrittore WHERE Id =".$Libro['Autore']))
			{
				$autore = $autoreArray->fetch_array(MYSQLI_ASSOC);
				echo "<td>".$autore['Nome']. " ". $autore['Cognome']."</td>";
				$autoreArray->free();
			}
			else{echo "<td scope='row'>".$Libro['Autore']."</td>";} //Caso in cui non trovo l'autore corrispondente

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
		echo "</tbody></table></div>";//Fine class Table
	}
	//Fine tabella


	//Form per inserire libro
	echo "<a name = 'insert'></a>
	<div class='box'>
		<h1>Inserisci libro </h1>
		<form action='../Action/inserisci_libro.php' method='post' onsubmit='return check()'>
			<div>
				<label for='isbn'>ISBN</label>
				<label for='isbn' id='isbnErr' class='formError'></label>
				<input type='text' name='isbnIns' id='isbn'/>

				<label for='titolo'>Titolo</label>
				<label for='titolo' id='titoloErr' class='formError'></label>
				<input type='text' name='titoloIns' id='titolo'/>

				<label for='autore' >Codice Autore</label>
				<label for='autore' id='autoErr' class='formError'></label>
				<input type='text' name='autoreIns' id='autore'/>

				<label for='anno' >Data Pubblicazione</label>
				<label for='data' id='dataErr' class='formError'></label>
				<input type='text' name='dataIns' id='anno'/>

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

	$db->close();

	echo "</div>";//Fine content

echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?>
