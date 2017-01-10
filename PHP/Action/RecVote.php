<?php
session_start();
Require_once('../connect.php');
if(isset($_SESSION['type']) &&  $_SESSION['type'] == 'user'){
	$lib = $_POST['pageRec'];
	$rec = $_POST['rec'];
	$autore = $_SESSION['id'];
	$val = $_POST['valutazioneRec'];
	$clean ="DELETE FROM VotoRecensione WHERE Autore = '$autore' AND Recensione = '$rec';";
	$db->query($clean);
	$sql = "INSERT INTO VotoRecensione (Recensione,Autore,Valutazione) VALUES ('$rec','$autore','$val');";
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