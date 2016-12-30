<?php
	echo file_get_contents("../HTML/Template/Head.txt");
	echo "<title>404 - SUCH WOW </title></head>";
			Require_once('functions.php');
			echo menu();

			echo 	"<div class='breadcrumb centrato'>
						<p class='path'>Ti trovi in: Errore 404, errore caricamento pagina</p>";
						echo file_get_contents("../HTML/Template/Search.txt");
			echo "</div>";
		echo "<div class='centrato'>
			<div class = 'error'>
				<h1>Grande giove!!</h1>
				<p>Qualcosa è andato storto, usa il menù per tornare al sito</p>
			</div>
		</div>";
	echo file_get_contents("../HTML/Template/Footer.txt");
?>