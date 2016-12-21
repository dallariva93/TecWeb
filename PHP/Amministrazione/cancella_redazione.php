<?php

include('connect.php');

echo file_get_contents("cancella_redazione_inizio.txt");
$email= $_POST['email'];

if ($email=="")
{echo "<br><h1>Inserire l'email della redazione </h1>";}
else{
$delete = "DELETE FROM `redazione` WHERE email='$email''";
} 
$result = mysqli_multi_query($db,$delete);
if($result){
	echo("<br><h1>Cancellazione avvenuta correttamente</h1>");
} else{
	echo("<br><h1>Cancellazione non eseguita</h1>");
}
echo file_get_contents("cancella_redazione_fine.txt");
?>
