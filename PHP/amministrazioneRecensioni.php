<?php

	Require_once('connect.php');
	Require_once('functions.php');	
	
	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("<title>Amministrazione Recensioni - FaceOnTheBook </title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("","<span xml:lang='en'> <a href='index.php'>Home</a></span>/<span><a href='amministrazione.php'>Amministrazione</a></span>/Recensioni");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb, file_get_contents("../HTML/Template/Breadcrumb.txt"));

	echo "<div class='centrato content'>";
	echo "<a href='#insert' id = 'new'>&#43;&nbsp;Nuova Recensione</a>";

	if($Recensioni = $db->query("SELECT * FROM Recensione ORDER BY Data_Pubblicazione DESC")){
		echo file_get_contents("../HTML/Template/InizioTabellaRecensioni.txt");
		while ($Rec = $Recensioni->fetch_array(MYSQLI_ASSOC)){
			//Controllo il libro sia nel database
			$LibroRec = "";
			$LibroTitolo;
			if($libro = $db->query("SELECT Titolo,ISBN FROM Libro WHERE ISBN =".$Rec['Libro']))
			{
				$lib = $libro->fetch_array(MYSQLI_ASSOC);

				$LibroRec = $Rec['Libro'];
				$LibroTitolo = $lib['Titolo'];
				$libro->free();
			}
			else{
				$LibroTitolo = $Rec['Libro'];
			}
			//Controllo l'autore della recensione sia nel database
			$Autore;
			if($autoreArray = $db->query("SELECT Nome,Cognome FROM Redazione WHERE Email =".$Rec['Autore']))
			{
				$autore = $autoreArray->fetch_array(MYSQLI_ASSOC);
				$Autore = $autore['Nome']. " ". $autore['Cognome'];
				$autoreArray->free();
			}
			else{
				$Autore = $Rec['Autore'];
			}
			
			$search=array("{{Data}}","{{Libro}}","{{Titolo}}","{{Id}}","{{Voto}}","{{Autore}}");
			$replace=array($Rec['Data_Pubblicazione'],$LibroRec,$LibroTitolo,$Rec['Id'],$Rec['Valutazione'],$Autore);
			echo str_replace($search ,$replace, file_get_contents("../HTML/Template/TabellaRecensione.txt"));
		}

		$Recensioni->free();
	}
	echo "</tbody></table></div>";

	//Form inserimento recensione
	echo file_get_contents("../HTML/Template/FormInserimentoRencensione.txt");

	$db->close();

	echo "</div>";//Fine content

	echo file_get_contents("../HTML/Template/FooterAdmin.txt");

?>
