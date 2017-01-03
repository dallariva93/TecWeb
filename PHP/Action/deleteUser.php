<?php
Require_once('../connect.php');
if(isset($_COOKIE['admin'])){
		$user = $_POST['email'];
		$sql = "DELETE FROM Utente WHERE Email = '$user'";
		if(!$db->query($sql)){
			header("Location: ../page_not_found.php");
	}
	
}
header("Location: ../Amministrazione/utenti.php");
?>