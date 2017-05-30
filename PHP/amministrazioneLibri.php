<?php
	if(!isset($_SESSION))
		session_start();
	if($_SESSION['type'] == "admin"){
		Require_once('connect.php');
		Require_once('functions.php');
		if(isset($_POST['delete'])){
			$delete = "DELETE FROM `Libro` WHERE `ISBN` = '". $_POST['delete']. "'";
			$db->query($delete);
		}

		$errore = false;
		$titolo = (isset($_POST['titolo']))? campoNonVuoto($errore,$_POST['titolo']) : "" ;
		$casa = (isset($_POST['casa']))? campoNonVuoto($errore,$_POST['casa']) : "";
		$trama = (isset($_POST['trama']))? campoNonVuoto($errore,$_POST['trama']) : "";

		$scrittore= "";
		if($TuttiScrittori = $db->query("Select Nome,Cognome,Id From Scrittore GROUP BY Id")){
			if($TuttiScrittori->num_rows > 0){
				while($Scrittore = $TuttiScrittori->fetch_array(MYSQLI_ASSOC)){
					$scrittore .= "<option value='". $Scrittore['Id']. "'>".
						$Scrittore['Cognome']. " ". $Scrittore['Nome']. "</option>";
				}
			}
			$TuttiScrittori->free();
		}

		$searchInForm=array("{{ISBNError}}","{{TitoloError}}","{{DataError}}",
							"{{CasaError}}", "{{TramaError}}","{{Scrittori}}");
		$replaceInForm=array(testISBN($errore),$titolo,testDate($errore), $casa,
						$trama,$scrittore);

		if(!$errore && isset($_POST['isbn']) && isset($_POST['titolo'])
			&& isset($_POST['data']) && isset($_POST['casa']) && isset($_POST['trama'])
			&& isset($_POST['genere']) && isset($_POST['autore']))
		{
			$insert="INSERT INTO `Libro` (ISBN, Titolo, Autore,Casa_Editrice,Anno_Pubblicazione
				, Genere, Trama) VALUES ('".$_POST['isbn']."','".$_POST['titolo']."','".$_POST['autore']."','"
				.$_POST['casa']."','". GetData($_POST['data']). "','". $_POST['genere']. "', '".$_POST['trama']."')";
			if($db->query($insert)){//Inserimento copertina
				if(isset($_POST['img']))
					echo $_POST['img'];

				if (file_exists($_FILES['img']['tmp_name']) &&
					is_uploaded_file($_FILES['img']['tmp_name'])){


							$erroreFile = false;
							$target_dir = "../img/cover/";
							$target_file = $target_dir . $_POST['isbn']. ".jpg" ;

							$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

							if($_FILES["img"]["size"] > 500000 && $imageFileType != "jpg"
								&& $imageFileType != "png" && $imageFileType != "jpeg"
								&& $imageFileType != "gif" ) {
								$erroreFile = true;
							}

			    			if(!$erroreFile){
								move_uploaded_file($_FILES["img"]["tmp_name"],
									$target_file);
							}

					}//fine if (file_exists($_FILES...


			}


		}

		$searchHead=array("{{title}}","{{description}}");
		$replaceHead=array("Amministrazione Libri - ",
			"Pagina per la gestione dei libri su FaceOnTheBook");
		echo str_replace($searchHead ,$replaceHead,
			file_get_contents("../HTML/Template/Head.txt"));

		echo menu();

		$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
		$replaceBreadcrumb=array("","<span xml:lang='en'>
			<a href='index.php'>Home</a></span> >
			<span><a href='amministrazione.php'>Amministrazione</a>
			</span> > Libri");
		echo str_replace($searchBreadcrumb ,$replaceBreadcrumb,
			file_get_contents("../HTML/Template/Breadcrumb.txt")).

		"<div class='centrato content'>
		<a name = 'top'></a>
		<a href = '#insert' class = 'adminButton'>&#43;&nbsp;Nuovo Libro</a>";
		//Stampa tutti i libri in una tabella
		if($Libri = $db->query("SELECT * FROM Libro ORDER BY Titolo")){
			echo file_get_contents("../HTML/Template/InizioTabellaLibri.txt");
			while ($Libro = $Libri->fetch_array(MYSQLI_ASSOC)){
				$autoreLibro = "";
				if($autoreArray = $db->query("SELECT Nome,Cognome FROM Scrittore
					WHERE Id =".$Libro['Autore']))
					{
						$autore = $autoreArray->fetch_array(MYSQLI_ASSOC);
						$autoreLibro = $autore['Nome']. " ". $autore['Cognome'];
						$autoreArray->free();
					}
				else //Caso in cui non trovo l'autore corrispondente
					$autoreLibro = $Libro['Autore'];


				$searchLibri=array("{{ISBN}}","{{Titolo}}","{{Data}}","{{Autore}}",
					"{{Casa}}","{{Genere}}");
				$replaceLibri=array($Libro['ISBN'],$Libro['Titolo'],
					Data($Libro['Anno_Pubblicazione']),$autoreLibro,
					$Libro['Casa_Editrice'],$Libro['Genere']);
				echo str_replace($searchLibri ,$replaceLibri,
					file_get_contents("../HTML/Template/TabellaLibri.txt"));
			}
			$Libri->free();
		}
		//Fine tabella
		echo "</tbody></table></div>".

		file_get_contents("../HTML/Template/LinkAlMenu.txt").

		//Form per inserire libro

		str_replace($searchInForm, $replaceInForm ,
			file_get_contents("../HTML/Template/FormInserimentoLibro.txt")).



		"</div>".//Fine content
		file_get_contents("../HTML/Template/FileJs.txt").
		file_get_contents("../HTML/Template/Footer.txt");
		$db->close();
	}
	else{
		header("Location: page_not_found.php");
		exit();
	}

?>
