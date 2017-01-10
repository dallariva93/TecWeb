<?php
session_start();
Require_once('../connect.php');
if(isset($_SESSION['type']) &&  $_SESSION['type'] == 'user'){
	$lib = $_POST['pageB'];
	$autore = $_SESSION['id'];
	$val = $_POST['valutazioneB'];
	$clean ="DELETE FROM VotoLibro WHERE Autore = '$autore' AND Libro = '$lib';";
	$db->query($clean);
	$sql = "INSERT INTO VotoLibro (Libro,Autore,Valutazione) VALUES ('$lib','$autore','$val');";
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