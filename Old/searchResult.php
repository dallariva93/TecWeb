<?php
	if(isset($_GET['search'])){
	$match =strip_tags(htmlentities($_GET['search']));
	Require_once('connect.php');
	Require_once('functions.php');

	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("<title>Risultati ricerca - FaceOnTheBook</title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("","<span xml:lang='en'><a href='index.php'>Home</a>/<span>Risultati ricerca:</span>");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb, file_get_contents("../HTML/Template/Breadcrumb.txt"));

	echo "<div class='centrato content'>".
	//Link per muoversi più velocemente tra le categorie
	file_get_contents("../HTML/Template/SearchLinks.txt");

	//Cerco match tra i titoli dei libri

	if($risultatiLibri = $db->query("SELECT * FROM Libro WHERE Titolo LIKE '%". $match. "%'")){
		if($risultatiLibri->num_rows > 0){
			echo "<div class='elenco'>
			<dl class='leftHalf'>
				<dt>Libri:<a name = 'book'></a></dt>";
			while($libro = $risultatiLibri->fetch_array(MYSQLI_ASSOC)){
				$searchLibro=array("{{ISBN}}","{{Titolo}}","{{Testo}}");
				$replaceLibro=array($libro['ISBN'],$libro['Titolo'],$libro['Trama']);
				echo str_replace($searchLibro ,$replaceLibro, file_get_contents("../HTML/Template/MiniaturaLibro.txt"));
			}
		echo "</dl>
			</div>";//Fine classe elenco
		}
	$risultatiLibri->free();
	}

	//Cerco match tra i nomi degli scrittori

	if($risultatiScrittori = $db->query("SELECT * FROM Scrittore WHERE Nome LIKE '%". $match. "%' OR Cognome LIKE '%". $match. "%'")){
		if($risultatiScrittori->num_rows > 0){
			echo "<div class='elenco'>
			<dl class='leftHalf'>
				<dt>Autori:<a name = 'writer'></a></dt>";
			while($persona = $risultatiScrittori->fetch_array(MYSQLI_ASSOC)){
				$searchAutore=array("{{Id}}","{{Nome}}","{{Cognome}}");
				$replaceAutore=array($persona['Id'],$persona['Nome'],$persona['Cognome']);
				echo str_replace($searchAutore ,$replaceAutore, file_get_contents("../HTML/Template/MiniaturaAutore.txt"));
			}
		echo "</dl>
		</div>";//Fine classe elenco
		}
	$risultatiScrittori->free();
	}

	// Cerco match tra i titoli delle notizie

	if($risultatiNotizie = $db->query("SELECT * FROM Notizie WHERE Titolo LIKE '%". $match. "%'")){
		if($risultatiNotizie->num_rows > 0){
			echo "<div class='elenco'>
			<dl class='leftHalf'>

				<dt>Notizie:<a name = 'news'></a></dt>";

			while($new = $risultatiNotizie->fetch_array(MYSQLI_ASSOC)){
				$searchNews=array("{{Id}}","{{Titolo}}");
				$replaceNews=array($new['Id'],$new['Titolo']);
				echo str_replace($searchNews ,$replaceNews, file_get_contents("../HTML/Template/MiniaturaNew.txt"));
			}
		echo "</dl>
		</div>"; //Fine classe elenco
		}
	$risultatiNotizie->free();
	}

	$db->close();

	echo "</div>". //Fine classe content
	file_get_contents("../HTML/Template/Footer.txt");
	}
	else {
		header("Location: page_not_found.php");
		exit();
	}
?>
