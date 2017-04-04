<?php
Require_once('../connect.php');
if(isset($_COOKIE['admin'])){
		$user = $_POST['id'];
		$sql = "DELETE FROM Libro WHERE ISBN = '$user'";
		if(!$db->query($sql)){
			header("Location: ../page_not_found.php");
	}
}
header("Location: ../Amministrazione/libri.php");
?>
