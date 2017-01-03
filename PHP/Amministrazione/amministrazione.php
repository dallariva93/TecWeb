<?php

	Require_once('../connect.php');
	Require_once('../functions.php');

	echo file_get_contents("../../HTML/Template/HeadAdmin.txt");
			
			echo "<title>Amministrazione - SUCH WOW </title>","</head>";

			echo menuAdmin();

			echo 	"<div class='breadcrumb centrato'>
						<p class='path'>Ti trovi in: <span xml:lang='en'> <a href='../index.php'>Home</a></span>/Amministrazione</p>";
						echo file_get_contents("../../HTML/Template/SearchAdmin.txt");
			echo "</div>";
		echo "
		<div class='centrato content'>
			<a href='utenti.php' class='boxAdmin'>Utenti</a>
			<a href='scrittori.php' class='boxAdmin'>Scrittori</a>
			<a href='recensioni.php' class='boxAdmin'>Recensioni</a>
			<a href='redazione.php' class='boxAdmin'>Redazione</a>
			<a href='libri.php' class='boxAdmin'>Libri</a>
			<a href='notizie.php' class='boxAdmin'>Notizie</a>		
		</div>";
		echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?>

