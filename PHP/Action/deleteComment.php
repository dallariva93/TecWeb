<?php
Require_once('../connect.php');
if(isset($_COOKIE['user'])){
	$lib = $_POST['page'];
		$autore = $_COOKIE['user'];
		$ndata = $_POST['data'];
		$nrec = $_POST['rec'];
		$lib = $_POST['page'];
		$sql = "DELETE FROM `Commenti` WHERE `Commenti`.`Recensione` = '$nrec' AND `Commenti`.`Autore` = '$autore' AND `Commenti`.`Data_Pubblicazione` = '$ndata'";
		if(!$db->query($sql)){
			header("Location: ../page_not_found.php");
		
	}
	header("Location: ../libro.php?libro=". $lib);
}
?>
