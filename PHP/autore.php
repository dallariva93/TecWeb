
<?php

	Require_once('connect.php');
	if(isset($_REQUEST['autore']) && ($datiArray = $db->query("SELECT * FROM Scrittore WHERE Id =". $_REQUEST['autore']))) {

		Require_once('functions.php');
		if($datiArray->num_rows > 0){
			$dati = $datiArray->fetch_array(MYSQLI_ASSOC);

			$replaceHead=array("<title>". $dati['Cognome']. " - FaceOnTheBook </title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
			$searchHead=array("{{title}}","{{description}}");
			echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));


			echo menu().

			"<div class='breadcrumb centrato'>
					<p class='path'>Ti trovi in: <span xml:lang='en'> <a href='index.php'>Home</a></span>/Autore</p>".
					file_get_contents("../HTML/Template/Search.txt").
			"</div>".

			//Stampo le informazioni dell' autore

			"<div class='centrato presentazione content'>

			<div class='text'>
			<img class='VleftSmall' src='../img/autori/". $dati['Id']. ".jpg' alt='Immagine di ". $dati['Cognome']. "'/>
			<div class='info'>
			<h1>". $dati['Nome']. " ". $dati['Cognome']. "</h1>

			<h2>Data di nascita: ". data($dati['Data_Nascita']). "</h2>

			<h2>Nazionalita: ". $dati['Nazionalita']. "</h2>

			</div>"; //fine classe info


			//Ricerca di tutti i libri dell' autore nel sito
			if($AltriLibri = $db->query("SELECT Titolo,ISBN,Anno_Pubblicazione FROM Libro WHERE Autore ='". $_REQUEST['autore']. "' ORDER BY Anno_Pubblicazione")) {
				echo "<div class='info'>
				<h2>Libri di ". $dati['Cognome']. " presenti nel sito: </h2>
				<ul>";

				while($row = $AltriLibri->fetch_array(MYSQLI_ASSOC)){
					echo "<li><a href='libro.php?libro=". $row['ISBN']. "'>".$row['Titolo'] . "</a></li>";
				}
			echo "</ul>
			</div>";//fine classe info

			$AltriLibri->free();
			}


			echo "</div>".//fine class text
					"</div>".//fine class content

			file_get_contents("../HTML/Template/Footer.txt");
		}
	$datiArray->free();
	$db->close();
	}
	else {
		header("Location: page_not_found.php");
	}
	exit;
?>
