<?php
session_start();
Require_once('../connect.php');
if(isset($_SESSION['type']) &&  $_SESSION['type'] == 'user'){
	$lib = $_POST['page'];
	if(!$_POST['text'] == ""){
		$autore = $_SESSION['id'];
		$ntesto ="<p>". strip_tags(htmlentities($_POST['text'])). "</p>";
		$nrec = $_POST['rec'];
		$sql = "INSERT INTO Commenti (Recensione,Autore,Commento) VALUES ('$nrec','$autore','$ntesto');";
		if(!$db->query($sql)){
			header("Location: ../page_not_found.php");
			exit();
		}
	}
	header("Location: ../libro.php?libro=". $lib);
	exit();
}
else {
	header("Location: ../page_not_found.php");
	exit();
}
?>