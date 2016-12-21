
<?php

	Require_once('connect.php');
	if(isset($_GET['autore'])){
		$codice = $_GET ['autore'];
		$nome = mysql_query("SELECT Nome FROM db WHERE ID=$codice");
		$cognome = mysql_query("SELECT Cognome FROM db WHERE ID=$codice");
		$DataNascita = mysql_query("SELECT Data_Nascita FROM db WHERE ID=$codice");
		$Nazionalita = mysql_query("SELECT Nazionalita FROM db WHERE ID=$codice");
		
		echo file_get_contents("../HTML/Template/Head.txt");
		print "<title>". $cognome. "- SUCH WOW </title>";
		print "</head>";
		
		echo file_get_contents("../HTML/Template/Menu.txt");

		print 	"<div class='breadcrumb centrato'>
					<p class='path'>Ti trovi in: <span xml:lang='en'> <a href='../HTML/index.html'>Home </a> </span>/Autore</p>";
					echo file_get_contents("../HTML/Template/Search.txt");
		print "</div>";

		print "	<div class='centrato presentazione content'>
				<img class='VleftSmall' src='../img/cover/IlSignoreDegliAnelli.jpg' alt='Immagine dell' autore'/>

				<div class='text'>";
					print "<h1>". $nome. " ". $cognome. "</h1>";
					print "<p>Data di nascita: ". $DataNascita. "</p>";  
					print "<p>Nazionalita: ". $Nazionalita. "</p>"; 

					if($AltriLibri = $db->query("SELECT ISBN FROM Libro WHERE Autore = $codice")){
						if($AltriLibri->num_rows > 0){
							print "<h2>Altri libri dell' autore: </h2>";
							print "<ul>";
							while($row = $AltriLibri->fetch_array(MYSQLI_ASSOC)){
							print "<li><a href=''>". $row['Titolo']. "</a></li>";
							}
						}
						$AltriLibri->free();
					}
				$db->close();
				print "</div>";
		print "</div>";


		echo file_get_contents("../HTML/Template/Footer.txt");
	}
	else {
		header("Location: ../HTML/page_not_found.html");
   		exit;
	}
?>