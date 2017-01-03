<?php
Require_once('../connect.php');
if(isset($_COOKIE['admin'])){
		$user = $_POST['id'];
		$sql = "DELETE FROM Scrittore WHERE Id = '$user'";
		if(!$db->query($sql)){
			header("Location: ../page_not_found.php");
	}
}
header("Location: ../Amministrazione/scrittori.php");
?>