<?php
	Require_once('connect.php');
	Require_once('functions.php');

	$replaceHead=array("<title>FaceOnTheBook</title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
	$searchHead=array("{{title}}","{{description}}");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

	echo menu().

	"<div class='header centrato'>
		<h1>FACE ON THE BOOK</h1>
		<p>Tieniti informato sui tuoi libri preferiti!</p>
	</div>".

	"<div class='attacca breadcrumb centrato'>
			<p class='path'>Ti trovi in: <span xml:lang='en'>Home</span></p>".
			file_get_contents("../HTML/Template/Search.txt").
	"</div>".

	"<div class='centrato content'>
	<div class='elenco'>".

	//ULTIME RECENSIONI

	"<dl class='leftBig'>
	<dt>Ultime Recensioni</dt>
	";
	if($UltimeRec = $db->query("SELECT Libro.ISBN, Libro.Titolo, Libro.Trama,Recensione.Testo, Recensione.Data_Pubblicazione FROM Libro JOIN Recensione ON(Recensione.Libro = Libro.ISBN) ORDER BY Recensione.Data_Pubblicazione LIMIT 5")){
		if($UltimeRec->num_rows > 0){
			while($row = $UltimeRec->fetch_array(MYSQLI_ASSOC)){
				echo
					"<dd>
						<a href='libro.php?libro=". $row['ISBN']. "'>
						<img src='../img/cover/". $row['ISBN']. ".jpg' alt=''/>
						<object>
							<h1>". $row['Titolo']. "</h1>".
							$row['Testo'].
						"</object>
						</a>
					</dd>
				";
			}
		}
		$UltimeRec->free();
	}
	echo "</dl>". //Fine ultime recensioni

	//ULTIMI LIBRI USCITI

	"<div class='rightSmall'>

	<h1>Ultime uscite</h1>";

	if($UltimeExt = $db->query("SELECT ISBN, Titolo, Trama FROM Libro ORDER BY Anno_Pubblicazione DESC LIMIT 11")){
		if($UltimeExt->num_rows > 0){
			echo "<ul>";
			while($rowE = $UltimeExt->fetch_array(MYSQLI_ASSOC)){
				echo "<li><a href='libro.php?libro=". $rowE['ISBN']. "'>". $rowE['Titolo']. "</a></li>
				";
			}
			echo "</ul>";
		}
		$UltimeExt->free();
	}

	echo "</div>".// Fine ultime uscite

	//ULTIME NOTIZIE

	"<div class='rightSmall'>

	<h1>News</h1>";

	if ($UltimeNews = $db->query("SELECT * FROM Notizie ORDER BY Data DESC LIMIT 4")) {
		if($UltimeNews->num_rows>0) {
			echo "<ul>";
			while ($rowNews = $UltimeNews->fetch_array(MYSQLI_ASSOC)) {
				echo "<li><a href='new.php?id=",$rowNews['Id'], "'>", $rowNews['Titolo'], "</a></li>
				";
			}
			echo "</ul>";
		}
		$UltimeNews->free();
	}

	$db->close();

	echo "</div>". //Fine Ultime news
			"</div> ". //Fine classe elenco
			"</div>". //Fine classe content
	file_get_contents("../HTML/Template/Footer.txt");
?>
