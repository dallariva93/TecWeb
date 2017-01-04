<?php
Require_once('../connect.php');
if(isset($_COOKIE['user'])){
	$lib = $_POST['pageRec'];
	$rec = $_POST['rec'];
	$autore = $_COOKIE['user'];
	$val = $_POST['valutazioneRec'];
	$clean ="DELETE FROM VotoRecensione WHERE Autore = '$autore' AND Recensione = '$rec';";
	$db->query($clean);
	$sql = "INSERT INTO VotoRecensione (Recensione,Autore,Valutazione) VALUES ('$rec','$autore','$val');";
	if(!$db->query($sql)){
		header("Location: ../page_not_found.php");
	}
	header("Location: ../libro.php?libro=". $lib);
}
?>