<?php
session_start();
Require_once('../connect.php');
if(isset($_SESSION['type'])) {
	$lib = $_POST['page'];
	$autore = $_POST['user'];
	$ndata = $_POST['data'];
	$nrec = $_POST['rec'];
	$lib = $_POST['page'];
	$sql = "DELETE FROM `Commenti` WHERE `Commenti`.`Recensione` = '$nrec' AND `Commenti`.`Autore` = '$autore' AND `Commenti`.`Data_Pubblicazione` = '$ndata'";
	if(!$db->query($sql)){
		header("Location: ../page_not_found.php");
		exit();
	}
	header("Location: ../libro.php?libro=". $lib);
	exit();
}
else {
	header("Location: ../page_not_found.php");
	exit();
}
	
?>
