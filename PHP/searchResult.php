<?php

	$match =strip_tags(htmlentities($_GET['search']));
	Require_once('connect.php');
	Require_once('functions.php');
			echo file_get_contents("../HTML/Template/Head.txt");
			
			echo "<title>SUCH WOW</title>","</head>";

			
			echo menu();


			echo 	"<div class='breadcrumb centrato'>
						<p class='path'>Ti trovi in: <span>Risultati ricerca:</span> ". $match. "</p>";
						echo file_get_contents("../HTML/Template/Search.txt");
			echo "</div>";
			echo "<div class='centrato content'>";
			echo "<a href='#book' class ='button'>Libri</a>";
			echo "<a href='#writer' class ='button'>Autori</a>";
			echo "<a href='#news' class ='button'>Notizie</a>";
			echo "<a name = 'book'></a>";
			if($risultatiLibri = $db->query("SELECT * FROM Libro WHERE Titolo LIKE '%". $match. "%'")){
				if($risultatiLibri->num_rows > 0){
					echo "<div class='elenco'>
					<dl class='leftHalf' id='leftTb'>
						<dt>Libri:</dt>";
					while($libro = $risultatiLibri->fetch_array(MYSQLI_ASSOC)){
						echo
						"<dd>
							<a href='libro.php?libro=". $libro['ISBN']. "'>
									<img src='../img/cover/". $libro['ISBN']. ".jpg' alt=''/>
									<object>
										<h1>". $libro['Titolo']. "</h1>";					
										echo $libro['Trama'];	
								echo "</object>
								
							</a>
						</dd>";
					}
				echo "</dl>
					</div>";
				}
					
			}

			
			if($risultatiScrittori = $db->query("SELECT * FROM Scrittore WHERE Nome LIKE '%". $match. "%' OR Cognome LIKE '%". $match. "%'")){
				if($risultatiScrittori->num_rows > 0){
					echo "<div class='elenco'>
					<dl class='leftHalf' id='leftTb'>
					<a name = 'writer'></a>
						<dt>Autori:</dt>";
						
					while($persona = $risultatiScrittori->fetch_array(MYSQLI_ASSOC)){
						echo
						"<dd>
							<a href='autore.php?autore=". $persona['Id']. "'>
									<img src='../img/autori/". $persona['Id']. ".jpg' alt=''/>
									<object>
										<h1>". $persona['Nome']. " ". $persona['Cognome']. "</h1>";						
								echo "</object>
								
							</a>
						</dd>";
					}
				echo "</dl></div>";
				}
					
			}

			if($risultatiNotizie = $db->query("SELECT * FROM Notizie WHERE Titolo LIKE '%". $match. "%'")){
				if($risultatiNotizie->num_rows > 0){
					echo "<div class='elenco'>
					<dl class='leftHalf' id='leftTb'>
					<a name = 'news'></a>
						<dt>Notizie:</dt>";
						
					while($new = $risultatiNotizie->fetch_array(MYSQLI_ASSOC)){
						echo
						"<dd>
							<a href='news.php?id=". $new['Id']. "'>
									<object>
										<h1>". $new['Titolo']. "</h1>";	
										echo $new['Testo'];					
								echo "</object>
							</a>
						</dd>";
					}
				echo "</dl></div>";
				}
					
			}


			echo "</div>";
			echo file_get_contents("../HTML/Template/Footer.txt");
?>