<?php
Require_once('../connect.php');
if(isset($_COOKIE['user'])){
	$lib = $_POST['pageB'];
	$autore = $_COOKIE['user'];
	$val = $_POST['valutazioneB'];
	$clean ="DELETE FROM VotoLibro WHERE Autore = '$autore' AND Libro = '$lib';";
	$db->query($clean);
	$sql = "INSERT INTO VotoLibro (Libro,Autore,Valutazione) VALUES ('$lib','$autore','$val');";
	if(!$db->query($sql)){
		header("Location: ../page_not_found.php");
	}
	
	header("Location: ../libro.php?libro=". $lib);
}
?>