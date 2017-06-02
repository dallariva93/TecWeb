
<?php
	Require_once('connect.php');
	Require_once('functions.php');

	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("News - ","<meta name='description' content='Social network per topi di bibblioteca'/>");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

	
	//Numero della pagina
	if(isset($_POST['page']))
		$page = $_POST['page'];
	else
		$page = 0;	
	
	
	echo menu().

	file_get_contents("../HTML/Template/IndexHeader.txt");

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("attacca"," <span xml:lang='en'>Home</span>");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb, file_get_contents("../HTML/Template/Breadcrumb.txt"));

	//apro i div per le news e le colonne laterali se presenti
	
	echo "<div class='centrato content'>
	<div class='elenco'>";
	
	echo " <dl class='centrato'>
	<dt>Ultime News</dt>";
	
	$sqlQuery = "SELECT * FROM Notizie ";
	
	//prelevo le news dal db e le stampo in ordine
	//se il numero di news e maggiore di 8, in caso devo attivare i pulsanti in basso per caricare notizie piu vecchie
	if ($UltimeNews = $db->query( $sqlQuery ."ORDER BY Data DESC LIMIT 5 OFFSET ".($page * 5))) {
		if($UltimeNews->num_rows>0) {
			while($rowNews = $UltimeNews->fetch_array(MYSQLI_ASSOC)){
				$searchNews=array("{{Id}}","{{Titolo}}","{{Testo}}");
				$replaceNews=array($rowNews['Id'],$rowNews['Titolo'],ReadMore($rowNews['Testo']));
				echo str_replace($searchNews ,$replaceNews, file_get_contents("../HTML/Template/MiniaturaNews.txt"));
			}
		}
		$UltimeNews->free();
	}
	echo "</dl>"; //Fine ultime news
	
	//chiudo i tag div delle news
	echo "</div>";
	
	//Stampa funzione per il paging
	$count = "SELECT COUNT(*) AS Totale FROM ($sqlQuery) AS Count";
	if($totNumber = ($db->query($count)->fetch_array(MYSQLI_ASSOC))){
		pagingNews($page,$totNumber['Totale']);
	}
	
	
	//fine content
	echo "</div>";
	
	//chiudo il db
	$db->close();

	// chiudo i div che ho aperto

	file_get_contents("../HTML/Template/Footer.txt");
?>
	
