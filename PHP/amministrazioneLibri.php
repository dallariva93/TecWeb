<?php

	Require_once('connect.php');
	Require_once('functions.php');
	
	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("<title>Amministrazione Libri - FaceOnTheBook </title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("","<span xml:lang='en'> <a href='index.php'>Home</a></span>/<span> <a href='amministrazione.php'>Amministrazione</a></span>/Libri");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb, file_get_contents("../HTML/Template/Breadcrumb.txt"));
	
	echo "<div class='centrato content'>".
	"<a href='#insert' id = 'new'>&#43;&nbsp;Nuovo Libro</a>";
	//Stampa tutti i libri in una tabella
	if($Libri = $db->query("SELECT * FROM Libro ORDER BY Titolo")){
		echo file_get_contents("../HTML/Template/InizioTabellaLibri.txt");
		while ($Libro = $Libri->fetch_array(MYSQLI_ASSOC)){	
			$autoreLibro = "";
			if($autoreArray = $db->query("SELECT Nome,Cognome FROM Scrittore WHERE Id =".$Libro['Autore']))
				{
					$autore = $autoreArray->fetch_array(MYSQLI_ASSOC);
					$autoreLibro = $autore['Nome']. " ". $autore['Cognome'];
					$autoreArray->free();
				}
			else 
				$autoreLibro = $Libro['Autore']; //Caso in cui non trovo l'autore corrispondente
		
		
			$searchLibri=array("{{ISBN}}","{{Titolo}}","{{Data}}","{{Autore}}","{{Casa}}","{{Genere}}");
			$replaceLibri=array($Libro['ISBN'],$Libro['Titolo'],Data($Libro['Anno_Pubblicazione']),$autoreLibro,$Libro['Casa_Editrice'],$Libro['Genere']);
			echo str_replace($searchLibri ,$replaceLibri, file_get_contents("../HTML/Template/TabellaLibri.txt"));
		}
		$Libri->free();
	}
	//Fine tabella
	echo "</tbody></table></div>";


	//Form per inserire libro
	echo file_get_contents("../HTML/Template/FormInserimentoLibro.txt");

	$db->close();

	echo "</div>";//Fine content

echo file_get_contents("../HTML/Template/FooterAdmin.txt");

?>
