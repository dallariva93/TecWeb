<?php
	Require_once('connect.php');
	Require_once('functions.php');

	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("Classifica - ",
		"Classifica dei libri presenti su FaceOnTheBook");
	echo str_replace($searchHead ,$replaceHead,
		file_get_contents("../HTML/Template/Head.txt"));

	$strClassifica = "";
	$numVoti = "";
	$sqlQuery = "";
	$sqlGenere = "";
	$sqlOrdine = "";
	$tipoCl = "";
	$ordine = "";
	$genere = "";
	$replaceTipo = "";
	$replaceOrdine = "";
	
	//Numero della pagina,tipo di classifica, ordine di visualizzazione e filtro dei generi
	if(isset($_POST['page']))
		list($page, $tipoCl, $ordine, $genere) = explode("-", $_POST['page'], 4);
	else
		$page = 0;
	
	//Tipo classifica (Utenti o Redazione)
	if(isset($_POST['voti']))
		$tipoCl = $_POST['voti'];
	
	//Ordine di visualizzazione
	if(isset($_POST['ordine']))
		$ordine = $_POST['ordine'];
	
	//Genere delle recensioni
	if(isset($_POST['genere'])){
		$genere = $_POST['genere'];
		$page = 0;
	}
	
	
	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("",
		"<span xml:lang='en'> <a href='index.php'>Home</a>
		</span> > Classifica ". $genere);
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb,
		file_get_contents("../HTML/Template/Breadcrumb.txt"));

	//Colonna dei filtri
	echo file_get_contents("../HTML/Template/ClassificaInizioFiltri.txt");
	
	
	//variabili check
	$checkTUser = "";
	$checkTRed = "";
	$checkOrCres = "";
	$checkOrDesc = "";
	
	//Classifica Utente o Redazione
	echo "<h1>Classifica</h1>";
	if($tipoCl == 'redazione'){
		$checkTRed = "checked = 'checked'";
		$strClassifica = "<span class = 'note'>Voto della redazione: ";
	}
	else{
		$checkTUser = "checked = 'checked'";
		$strClassifica = "<span class = 'note'>Voto degli utenti: ";
	}
	$searchGenere=array("{{NAME}}","{{TESTO}}","{{VALUE}}","{{CHECK}}","{{ID}}");
	$replaceGenere=array("voti","Classifica voti degli Utenti","utenti", $checkTUser,"utenti");
	echo str_replace($searchGenere ,$replaceGenere,file_get_contents("../HTML/Template/ClassificaFiltri.txt"));
	$replaceGenere=array("voti","Classifica voti della Redazione","redazione", $checkTRed,"redazione");
	echo str_replace($searchGenere ,$replaceGenere,file_get_contents("../HTML/Template/ClassificaFiltri.txt"));
	
	//Ordine ascendente o discendente dei risultati
	echo "<h1>Ordine</h1>";
	if($ordine == 'cresc')
		$checkOrCres = "checked = 'checked'";
	else{
		$checkOrDesc = "checked = 'checked'";
		$sqlOrdine = " DESC ";
	}
	$searchGenere=array("{{NAME}}","{{TESTO}}","{{VALUE}}","{{CHECK}}","{{ID}}");
	$replaceGenere=array("ordine","Decrescente","desc", $checkOrDesc,"desc");
	echo str_replace($searchGenere ,$replaceGenere,file_get_contents("../HTML/Template/ClassificaFiltri.txt"));
	$replaceGenere=array("ordine","Crescente","cresc", $checkOrCres,"cresc");
	echo str_replace($searchGenere ,$replaceGenere,file_get_contents("../HTML/Template/ClassificaFiltri.txt"));
	
	//Filtri per Genere
	echo "<h1>Genere</h1>";
	//Creo opzione per selezionare tutte le recensioni
	$check = ($genere == "")? "checked = 'checked'" : "";
	$searchGenere=array("{{NAME}}","{{TESTO}}","{{VALUE}}","{{CHECK}}","{{ID}}");
	$replaceGenere=array("genere","Tutti","", $check,"Tutti");
	echo str_replace($searchGenere ,$replaceGenere,
		file_get_contents("../HTML/Template/ClassificaFiltri.txt"));

	//Creo un opzione per ogni tipo di genere presente del database
	if($TuttiGeneri = $db->query("Select Genere From Libro GROUP BY Genere")){
		if($TuttiGeneri->num_rows > 0){
			while($Genere = $TuttiGeneri->fetch_array(MYSQLI_ASSOC)){
				$check = ($Genere['Genere'] == $genere)? "checked = 'checked'" : "";
				$searchGenere=array("{{NAME}}","{{TESTO}}","{{VALUE}}","{{CHECK}}","{{ID}}");
				$replaceGenere=array("genere",$Genere['Genere'],htmlentities($Genere['Genere']),
					$check,strip_tags($Genere['Genere']));
				echo str_replace($searchGenere ,$replaceGenere,
					file_get_contents("../HTML/Template/ClassificaFiltri.txt"));
			}
		}
		$TuttiGeneri->free();
	}

	//Stampa finale filtri
	echo file_get_contents("../HTML/Template/ClassificaFineFiltri.txt").

	file_get_contents("../HTML/Template/LinkAlMenu.txt").
	"</div>";



	//Elenco di tutte le recensioni
	echo "<div class='classifica marginMobile' ><dl class='VrightBig'>
	<dt>Classifica Libri</dt>";

	
	//Se è presente un genere rendo più specifica la query
	 if( $genere != "")
	 	$sqlGenere.= " WHERE Libro.Genere = \"$genere\"";
	
	//query per ottenere le recensioni
	if($tipoCl == 'redazione'){
		$sqlQuery = "SELECT Libro.ISBN, Libro.Titolo, Scrittore.Nome, Scrittore.Cognome, recensione.Valutazione FROM (Libro JOIN
				recensione ON (recensione.Libro = Libro.ISBN)) JOIN Scrittore ON (Libro.Autore = Scrittore.Id) ".$sqlGenere." ORDER BY recensione.Valutazione".$sqlOrdine.",Libro.Titolo";
	}
	else{
		$sqlQuery = "SELECT Libro.ISBN, Libro.Titolo, Scrittore.Nome, Scrittore.Cognome, ROUND(AVG(votolibro.Valutazione),1) AS Valutazione, COUNT(votolibro.Valutazione) AS nVoti FROM (Libro JOIN
				votolibro ON (votolibro.Libro = Libro.ISBN)) JOIN Scrittore ON (Libro.Autore = Scrittore.Id) ".$sqlGenere." GROUP BY Libro.ISBN ORDER BY Valutazione".$sqlOrdine.",Libro.Titolo";
	}

	if($ClassificaLib = $db->query($sqlQuery." LIMIT 10 OFFSET ".($page * 10))){
		if($ClassificaLib->num_rows > 0){
			$i = 1 + 10*$page;
			while($row = $ClassificaLib->fetch_array(MYSQLI_ASSOC)){
				if(isset($row['nVoti']))
					$numVoti = " (".$row['nVoti']."-voti)";
				$searchLibro=array("{{Indice}}","{{ISBN}}","{{Titolo}}","{{Autore}}","{{Valutazione}}","{{Star}}","{{Nvoti}}");
				$replaceLibro=array($i,$row['ISBN'],$row['Titolo'],$row['Nome']." ". $row['Cognome'],$strClassifica.$row['Valutazione']." - ","<div class='classStar'>".printStar($row['Valutazione']),$numVoti."</div></span>");
				echo str_replace($searchLibro,$replaceLibro,file_get_contents("../HTML/Template/MiniaturaLibroClassifica.txt"));
				$i += 1;
			}
		}
		// 
		$ClassificaLib->free();
	}
	//Fine stampa classifica
	echo "</dl></div>".
	file_get_contents("../HTML/Template/LinkAlMenu.txt");
	//Stampa funzione per il paging
	$count = "SELECT COUNT(*) AS Totale FROM ($sqlQuery) AS Count";

	if($Number = ($db->query($count)))
		if($totNumber = $Number->fetch_array(MYSQLI_ASSOC)){
		pagingClassifica($page,$totNumber['Totale'],$tipoCl,$ordine,$genere);
	}

	//Fine content
	echo "</div>".file_get_contents("../HTML/Template/Footer.txt");
?>
