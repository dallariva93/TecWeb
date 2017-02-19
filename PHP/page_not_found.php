<?php
	Require_once('functions.php');

	$replaceHead=array("<title>Error 404 - FaceOnTheBook</title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
	$searchHead=array("{{title}}","{{description}}");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

	echo menu().

	"<div class='breadcrumb centrato'>
			<p class='path'>Ti trovi in: Errore 404, errore caricamento pagina</p>".
			file_get_contents("../HTML/Template/Search.txt").
	"</div>
	<div class='centrato'>
		<div class = 'error404'>
			<h1>Grande giove!!</h1>
			<p>Qualcosa è andato storto, usa il menù per tornare al sito</p>
		</div>
	</div>".
	file_get_contents("../HTML/Template/Footer.txt");
?>
