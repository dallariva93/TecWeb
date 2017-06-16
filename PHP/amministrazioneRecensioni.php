<?php
	if(!isset($_SESSION))
		session_start();
	if($_SESSION['type'] == "admin"){
		Require_once('connect.php');
		Require_once('functions.php');

		if(isset($_POST['delete'])){
			$delete = "DELETE FROM `Recensione` WHERE `Id` = '". $_POST['delete']. "'";
			$db->query($delete);
		}

		$errore = false;
		$libri= "";
		if($TuttiLibri = $db->query("Select Titolo,ISBN From Libro WHERE ISBN
			NOT IN ( SELECT ISBN FROM Libro JOIN Recensione ON
			(Recensione.Libro = Libro.ISBN) ) GROUP BY ISBN")){
			if($TuttiLibri->num_rows > 0){
				while($Libro = $TuttiLibri->fetch_array(MYSQLI_ASSOC)){
					$libri .= "<option value='". $Libro['ISBN']. "'>".
						$Libro['Titolo']. "</option>";
				}
			}
			else
				$libri = "<option value='none'>Nessun libro da recensire</option>";
			$TuttiLibri->free();
		}
		$testo = (isset($_POST['testo']))? campoNonVuoto($errore,$_POST['testo']) : "" ;

		$searchInForm=array("{{Libri}}","{{TestoError}}");
		$replaceInForm=array($libri,$testo);

		if(!$errore && isset($_POST['testo']) &&
		 	isset($_POST['isbn']) && isset($_POST['valutazione']))
		{
			$insert="INSERT INTO `Recensione` (Libro, Autore,Testo,Valutazione)
				VALUES ('".$_POST['isbn']."','".$_SESSION['id']."','".
					$_POST['testo']. "','".$_POST['valutazione']. "')";
			$db->query($insert);
		}

		$searchHead=array("{{title}}","{{description}}");
		$replaceHead=array("Amministrazione Recensioni - ",
			"Pagina per la gestione delle recensioni su FaceOnTheBook");
		echo str_replace($searchHead ,$replaceHead,
			file_get_contents("../HTML/Template/Head.txt"));

		echo menu();

		$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
		$replaceBreadcrumb=array("","<span xml:lang='en'>
			<a href='index.php'>Home</a></span> > <span>
			<a href='amministrazione.php'>Amministrazione</a>
			</span> > Recensioni");
		echo str_replace($searchBreadcrumb ,$replaceBreadcrumb,
			file_get_contents("../HTML/Template/Breadcrumb.txt")).

		"<div class='centrato content'>
		<a name = 'top'></a>
		<a href = '#insert' class = 'adminButton'>&#43;&nbsp;Nuova Recensione</a>";

		if($Recensioni = $db->query("SELECT Redazione.Nome,Redazione.Cognome,
			Recensione.Id,Recensione.Libro,Recensione.Data_Pubblicazione,
			Recensione.Valutazione,Libro.Titolo FROM Redazione JOIN Recensione ON
			(Redazione.Email = Recensione.Autore) JOIN Libro ON
			(Recensione.Libro = Libro.ISBN)	ORDER BY Data_Pubblicazione DESC")){

			echo file_get_contents("../HTML/Template/InizioTabellaRecensioni.txt");
			while ($Rec = $Recensioni->fetch_array(MYSQLI_ASSOC)){
				$search=array("{{Data}}","{{Libro}}","{{Titolo}}","{{Voto}}",
					"{{Autore}}","{{Id}}");
				$replace=array(Data($Rec['Data_Pubblicazione'],true),$Rec['Libro'],
					$Rec['Titolo'],floor($Rec['Valutazione']),$Rec['Nome']." ".
					$Rec['Cognome'],$Rec['Id']);
				echo str_replace($search ,$replace,
					file_get_contents("../HTML/Template/TabellaRecensione.txt"));
			}

			$Recensioni->free();
		}
		echo "</tbody></table></div>".

		file_get_contents("../HTML/Template/LinkAlMenu.txt").

		//Form inserimento recensione
		str_replace($searchInForm, $replaceInForm ,
			file_get_contents("../HTML/Template/FormInserimentoRecensione.txt")).



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
