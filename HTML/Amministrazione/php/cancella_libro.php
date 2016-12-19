
<?php

include('connect.php');

echo file_get_contents("cancella_libro_inizio.txt");
$isbn= $_POST['isbn'];

if ($isbn=="")
{echo "<br><h1>Inserire ISBN </h1>";}
else{
$delete = "DELETE FROM `libro` WHERE isbn='$isbn''";
} 
$result = mysqli_multi_query($db,$delete);
if($result){
	echo("<br><h1>Cancellazione avvenuta correttamente</h1>");
} else{
	echo("<br><h1>Cancellazione non eseguita</h1>");
}
echo file_get_contents("cancella_libro_fine.txt");
?>
