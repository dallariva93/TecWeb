
<?php

	Require_once('connect.php');
	if(isset($_REQUEST['autore'])){
		Require_once('functions.php');
		$codice = $_REQUEST['autore'];
		$datiArray = $db->query("SELECT * FROM Scrittore WHERE Id =". $codice);
		if($datiArray->num_rows > 0){
			$dati = $datiArray->fetch_array(MYSQLI_ASSOC);
			echo file_get_contents("../HTML/Template/Head.txt");
			
			echo "<title>", $dati['Cognome'], "- SUCH WOW </title>","</head>";

			echo file_get_contents("../HTML/Template/Menu.txt");

			echo 	"<div class='breadcrumb centrato'>
						<p class='path'>Ti trovi in: <span xml:lang='en'> <a href='../HTML/index.html'>Home</a></span>/Autore</p>";
						echo file_get_contents("../HTML/Template/Search.txt");
			echo "</div>";

			echo "	<div class='centrato presentazione content'>
					<img class='VleftSmall' src='../img/autori/". $dati['Id']. ".jpg' alt='Immagine di ". $dati['Cognome']. "'/>

					<div class='text'>";
						echo "<h1>". $dati['Nome']. " ". $dati['Cognome']. "</h1>";
						echo "<h2>Data di nascita: ". data($dati['Data_Nascita']). "</h2>";  
						echo "<h2>Nazionalita: ". $dati['Nazionalita']. "</h2>"; 
						$datiArray->free();
						if($AltriLibri = $db->query("SELECT Titolo,ISBN FROM Libro WHERE Autore =". $codice)){
							echo "<h2>Libri di ". $dati['Cognome']. " presenti nel sito: </h2>";
							echo "<ul>";
							while($row = $AltriLibri->fetch_array(MYSQLI_ASSOC)){
								echo "<li><a href='libro.php?libro=". $row['ISBN']. "'>".$row['Titolo'] . "</a></li>";
							}
						echo "</ul>";
						
						$AltriLibri->free();
						}
					
					$db->close();
					echo "</div>";
			echo "</div>";
			echo file_get_contents("../HTML/Template/Footer.txt");
		}
		else
			{
				header("Location: ../HTML/page_not_found.html");}
			}
	else {
		header("Location: ../HTML/page_not_found.html");
	}
	exit;
?>