<?php
	echo file_get_contents("../HTML/Template/Head.txt");
	echo "<title>404 - SUCH WOW </title></head>";

			echo file_get_contents("../HTML/Template/Menu.txt");

			echo 	"<div class='breadcrumb centrato'>
						<p class='path'>Ti trovi in: Errore 404, errore caricamento pagina</p>";
						echo file_get_contents("../HTML/Template/Search.txt");
			echo "</div>";
		echo "<div class='centrato content'>
			<h1>Grande giove!!</h1>
			<p>Qualcosa è andato storto, usa il menù per tornare al sito</p>


		</div>";
	echo file_get_contents("../HTML/Template/Footer.txt");
?>