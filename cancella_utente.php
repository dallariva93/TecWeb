<?php

include('connect.php');

$nickname= $_POST['nickname'];

if ($nickname=="")
{echo "<br><h1>Inserire il nickname utente </h1>";}
else{
$delete = "DELETE FROM `utente` WHERE nicknamr='$nickname'";
} 
$result = mysqli_multi_query($db,$delete);
if($result){
	echo("<br><h1>Cancellazione avvenuta correttamente</h1>");
} else{
	echo("<br><h1>Cancellazione non eseguita</h1>");
}
?>
