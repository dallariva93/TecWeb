<?php
	Require_once('connect.php');
	Require_once('functions.php');

	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("Recensioni - ",
		"Catalogo delle recensioni presenti su FaceOnTheBook");
	echo str_replace($searchHead ,$replaceHead,
		file_get_contents("../HTML/Template/Head.txt"));

	$genere = "";

	//Numero della pagina e del genere
	if(isset($_POST['page']))
		list($page, $genere) = explode("-", $_POST['page'], 2);
	else
		$page = 0;
	//Genere delle recensioni
	if(isset($_POST['genere'])){
		$genere = $_POST['genere'];
		$page = 0;
	}

	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("",
		"<span xml:lang='en'> <a href='index.php'>Home</a>
		</span> > Recensioni ". $genere);
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb,
		file_get_contents("../HTML/Template/Breadcrumb.txt"));

	//Colonna dei filtri
	echo file_get_contents("../HTML/Template/RecensioniInizioFiltri.txt");

	//Creo opzione per selezionare tutte le recensioni
	$check = ($genere == "")? "checked = 'checked'" : "";
	$searchGenere=array("{{GENERE}}","{{VALUE}}","{{CHECK}}");
	$replaceGenere=array("Tutti","", $check);
	echo str_replace($searchGenere ,$replaceGenere,
		file_get_contents("../HTML/Template/RecensioniFiltri.txt"));

	//Creo un opzione per ogni tipo di genere presente del database
	if($TuttiGeneri = $db->query("Select Genere From Libro GROUP BY Genere")){
		if($TuttiGeneri->num_rows > 0){
			while($Genere = $TuttiGeneri->fetch_array(MYSQLI_ASSOC)){
				$check = ($Genere['Genere'] == $genere)? "checked = 'checked'" : "";
				$searchGenere=array("{{GENERE}}","{{VALUE}}","{{CHECK}}");
				$replaceGenere=array($Genere['Genere'],$Genere['Genere'], $check);
				echo str_replace($searchGenere ,$replaceGenere,
					file_get_contents("../HTML/Template/RecensioniFiltri.txt"));
			}
		}
		$TuttiGeneri->free();
	}

	//Stampa finale filtri
	echo file_get_contents("../HTML/Template/RecensioniFineFiltri.txt").

	file_get_contents("../HTML/Template/LinkAlMenu.txt").
	"</div>";



	//Elenco di tutte le recensioni
	echo "<div class='elenco marginMobile' ><dl class='VrightBig'>
	<dt>Ultime Recensioni</dt>";

	//Stampa recensioni
	$sqlQuery = "SELECT Libro.ISBN, Libro.Titolo, Libro.Trama,Recensione.Testo,
	 Recensione.Data_Pubblicazione FROM Libro JOIN
	 Recensione ON(Recensione.Libro = Libro.ISBN)";

	 //Se è presente un genere rendo più specifica la query
	 if( $genere != "")
	 	$sqlQuery .= " WHERE Libro.Genere = '$genere'";

	if($UltimeRec = $db->query($sqlQuery .
		" ORDER BY Recensione.Data_Pubblicazione DESC LIMIT 5 OFFSET ".($page * 5))){
		if($UltimeRec->num_rows > 0){
			while($row = $UltimeRec->fetch_array(MYSQLI_ASSOC)){
				$searchLibro=array("{{ISBN}}","{{Titolo}}","{{Testo}}");
				$replaceLibro=array($row['ISBN'],$row['Titolo'],ReadMore($row['Testo']));
				echo str_replace($searchLibro ,$replaceLibro, file_get_contents("../HTML/Template/MiniaturaLibro.txt"));
			}
		}
		$UltimeRec->free();
	}
	//Fine stampa recensioni
	echo "</dl></div>".
	file_get_contents("../HTML/Template/LinkAlMenu.txt");
	//Stampa funzione per il paging
	$count = "SELECT COUNT(*) AS Totale FROM ($sqlQuery) AS Count";
	if($totNumber = ($db->query($count)->fetch_array(MYSQLI_ASSOC))){
		paging($page,$totNumber['Totale'],$genere);
	}

	//Fine content
	echo "</div>".
	file_get_contents("../HTML/Template/Footer.txt");
?>
