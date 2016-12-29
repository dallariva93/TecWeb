
<?php

	Require_once('connect.php');
	if(isset($_REQUEST['libro'])){
		Require_once('functions.php');


		$codice = $_REQUEST['libro'];
		$datiLibro = $db->query("SELECT * FROM Libro WHERE ISBN = ". $codice);

		if($datiLibro->num_rows > 0){

			$datiL = $datiLibro->fetch_array(MYSQLI_ASSOC);

			$datiRecensione = $db->query("SELECT Testo,Valutazione FROM Recensione WHERE Libro = ". $codice);
			$votoRecArray = $db->query("SELECT AVG(Valutazione) AS Media FROM VotoRecensione GROUP BY (Recensione) HAVING Recensione =". $codice);
			$votoLibArray = $db->query("SELECT AVG(Valutazione) AS Media FROM VotoLibro GROUP BY (Libro) HAVING Libro =".$codice);
			$autoreArray = $db->query("SELECT Nome,Cognome,Id FROM Scrittore WHERE Id =". $datiL['Autore']);

			
			$datiRec = $datiRecensione->fetch_array(MYSQLI_ASSOC);
			$autore = $autoreArray->fetch_array(MYSQLI_ASSOC);
			$votoRec = $votoRecArray->fetch_array(MYSQLI_ASSOC);
			$votoLib = $votoLibArray->fetch_array(MYSQLI_ASSOC);

			echo file_get_contents("../HTML/Template/Head.txt");
			
			echo "<title>", $datiL['Titolo'], "- SUCH WOW </title>","</head>";

			echo file_get_contents("../HTML/Template/Menu.txt");

			echo 	"<div class='breadcrumb centrato'>
						<p class='path'>Ti trovi in: <span xml:lang='en'> <a href='../HTML/index.html'>Home</a></span>/". $datiL['Titolo']. "</p>";
						echo file_get_contents("../HTML/Template/Search.txt");
			echo "</div>";

			echo "	<div class='centrato presentazione content'>
						<img class='VleftSmall' src='../img/cover/". $datiL['ISBN'].  ".jpg' alt=''/>

						<div class='text'>
							<p><h1>". $datiL['Titolo']. "</h1></p>
							<p><h2><a href='autore.php?autore=".$autore['Id']."'>". $autore['Nome']. " ". $autore['Cognome'].  "</a></h2></p>

							";
							if($datiRec)
								echo "<p>Valutazione dalla redazione: <span>". $datiRec['Valutazione']. "/5 </span></p>";
								if($votoRec)
								echo "<p>Voto alla recensione: <span>". $votoRec['Media']. "/5 <span></p>";
								if($votoLib)
								echo "<p>Voto degli utenti: <span>". $votoLib['Media']. "/5 <span></p>"; 
							echo "
							<h2>Trama: </h2>";
							
								echo $datiL['Trama'];
							if($datiRec){
							echo "
							<h2>Recensione:</h2>";
								echo $datiRec['Testo'];
						}
						echo "</div>


					</div>

					</div>"; // Fine Libro
					$datiLibro->free();
					$datiRecensione->free();
					$autoreArray->free();




			$db->close();
			echo file_get_contents("../HTML/Template/Footer.txt");
		}
		else
			{
				header("Location: page_not_found.php");}
			}
	else {
		header("Location: page_not_found.php");
	}
	exit;
?>