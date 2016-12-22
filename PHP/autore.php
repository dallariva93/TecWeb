
<?php

	Require_once('connect.php');
	if(isset($_REQUEST['autore'])){
		Require_once('functions.php');
		$codice = $_REQUEST['autore'];
		$datiArray = $db->query("SELECT * FROM Scrittore WHERE Id =". $codice);
		if($datiArray->num_rows > 0){
			$dati = $datiArray->fetch_array(MYSQLI_ASSOC);
			echo file_get_contents("../HTML/Template/Head.txt");
			
			print "<title>". $dati['Cognome']. "- SUCH WOW </title>";
			print "</head>";

			
			echo file_get_contents("../HTML/Template/Menu.txt");

			print 	"<div class='breadcrumb centrato'>
						<p class='path'>Ti trovi in: <span xml:lang='en'> <a href='../HTML/index.html'>Home</a></span>/Autore</p>";
						echo file_get_contents("../HTML/Template/Search.txt");
			print "</div>";

			print "	<div class='centrato presentazione content'>
					<img class='VleftSmall' src='../img/autori/". $dati['Cognome']. ".jpg' alt='Immagine di ". $dati['Cognome']. "'/>

					<div class='text'>";
						print "<h1>". $dati['Nome']. " ". $dati['Cognome']. "</h1>";
						print "<h2>Data di nascita: ". data($dati['Data_Nascita']). "</h2>";  
						print "<h2>Nazionalita: ". $dati['Nazionalita']. "</h2>"; 

						if($AltriLibri = $db->query("SELECT Titolo FROM Libro WHERE Autore =". $codice)){
							if($AltriLibri->num_rows > 0){
								print "<h2>Libri di ". $dati['Cognome']. " presenti nel sito: </h2>";
								print "<ul>";
								while($row = $AltriLibri->fetch_array(MYSQLI_ASSOC)){
								print "<li><a href=''>".$row['Titolo'] . "</a></li>";
								}
							}
							$AltriLibri->free();
						}
					$datiArray->free();
					$db->close();
					print "</div>";
			print "</div>";
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