<?php

	Require_once('../connect.php');
	Require_once('../functions.php');

	echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

	echo "<title>Recensioni - SUCH WOW </title>","</head>";

	echo menuAdmin();

	echo "<div class='breadcrumb centrato'>
	<p class='path'>Ti trovi in: <span xml:lang='en'> <a href='../index.php'>Home</a></span>/<span><a href = 'amministrazione.php'>Amministrazione</a></span>/Scrittori</p>";
	echo file_get_contents("../../HTML/Template/SearchAdmin.txt");
	echo "</div>";

	echo "<div class='centrato content'>";
	echo "<a href='#insert' id = 'new'>&#43;&nbsp;Nuova Recensione</a>";

	if($Recensioni = $db->query("SELECT * FROM Recensione ORDER BY Data_Pubblicazione DESC")){
		echo "<div class='Table'><table summary = 'Elenco di tutte le recensioni presenti nel sito'>
		<thead>
			<tr>
				<th scope='col'>Data Pubblicazione</th>
				<th scope='col'>Libro</th>
				<th scope='col'>Autore</th>
				<th scope='col'>Id</th>
				<th scope='col'>Valutazione</th>
			</tr>
		</thead>
		<tbody>
		";
		while ($Rec = $Recensioni->fetch_array(MYSQLI_ASSOC)){
			echo "<tr>
			<td scope='row'>".$Rec['Data_Pubblicazione']."</td>";

			//Controllo il libro sia nel database
			if($libro = $db->query("SELECT Titolo,ISBN FROM Libro WHERE ISBN =".$Rec['Libro']))
			{
				$lib = $libro->fetch_array(MYSQLI_ASSOC);
				echo "<td>
				<a href="."'.."."/libro.php?libro=".$Rec['Libro']."'>".$lib['Titolo']."</a>
				</td>";
				$libro->free();
			}
			else{
				echo "<td>".$Rec['Libro']."</td>";
			}
			//Controllo l'autore della recensione sia nel database
			if($autoreArray = $db->query("SELECT Nome,Cognome FROM Redazione WHERE Email =".$Rec['Autore']))
			{
				$autore = $autoreArray->fetch_array(MYSQLI_ASSOC);
				echo "<td>".$autore['Nome']. " ". $autore['Cognome']."</td>";
				$autoreArray->free();
			}
			else{
				echo "<td>".$Rec['Autore']."</td>";
			}
			echo "
			<td>".$Rec['Id']."</td>
			<td>".$Rec['Valutazione']."/5</td>

			<td>
				<form action='../Action/deleteRec.php' method='post' onclick='return confirm(\"Confermi di eliminare?\")' >
					<div >
						<input type = 'hidden' name = 'id' value = '". $Rec['Id']. "' />
						<input type ='submit' value='&#x2718;' class='btnDelete' />
	   	    		</div>
				</form>
			</td>
			</tr>";

		}

		$Recensioni->free();
		echo "</tbody></table></div>";

	}


	//Form inserimento recensione
	echo "<a name = 'insert'></a>
	<div class='box'>
	<h1>Inserisci Recensione</h1>
	<form action='../Action/inserisci_recensione.php' method='post' onsubmit='return check()'>
		<div>
			<label for='id'>Codice recensione</label>
			<label for='id' id='codeErr' class='formError'></label>
			<input type='text' name='idIns' id='id'/>

			<label for='libro'>ISBN Libro</label>
			<label for='isbn' id='isbnErr' class='formError'></label>
			<input type='text' name='isbnIns' id='libro'/>

			<input type='hidden' name='autore' value=''/>

			<label for='testo'>Inserisci qui il tuo testo: </label>
			<textarea name='testo' id='testo' rows='4' cols='50'></textarea>

			<label for='valutazione'>valutazione
				<select name='valutazione' id='valutazione' class='input'>
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
    		<input type='submit' value='Aggiungi' class='btnLong'/>

			</div>
		</form>
	</div>";

	$db->close();

	echo "</div>";//Fine content

	echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?>
