<?php
Require_once('../connect.php');
if(isset($_COOKIE['user'])){
	$lib = $_POST['page'];
	if(!$_POST['text'] == ""){
		$autore = $_COOKIE['user'];
		$ntesto ="<p>". strip_tags(htmlentities($_POST['text'])). "</p>";
		$nrec = $_POST['rec'];
		$sql = "INSERT INTO Commenti (Recensione,Autore,Commento) VALUES ('$nrec','$autore','$ntesto');";
		if(!$db->query($sql)){
			header("Location: ../page_not_found.php");
		}
	}
	header("Location: ../libro.php?libro=". $lib);
}
?>