
<?php

	Require_once('connect.php');
	if(isset($_REQUEST['libro'])){
		Require_once('functions.php');


		$codice = $_REQUEST['libro'];
		$datiLibro = $db->query("SELECT * FROM Libro WHERE ISBN = ". $codice);
		$datiRecensione = $db->query("SELECT * FROM Recensione WHERE Libro = ". $codice);

		if($datiLibro->num_rows > 0){
			$datiL = $datiLibro->fetch_array(MYSQLI_ASSOC);
			$datiRec = $datiRecensione->fetch_array(MYSQLI_ASSOC);
			$autoreArray = $db->query("SELECT Nome,Cognome FROM Scrittore WHERE Id =". $datiL['Autore']);
			$autore = $autoreArray->fetch_array(MYSQLI_ASSOC);
			
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
							<p><h2>". $autore['Nome']. " ". $autore['Cognome'].  "</h2></p>

							";
							if($datiRec)
								echo "<p>Valutazione: <span>". $datiRec['Valutazione']. "/5 </span></p>";
							echo "
							<h2>Trama: </h2>
							<p>";
								echo $datiL['Trama'];
							echo "</p>
							<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet.
							</p>";
							if($datiRec){
							echo "
							<h2>Recensione:</h2>
							<p>";
								echo $datiRec['Recensione'];
							echo "</p>	
							<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet.
							</p>";
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