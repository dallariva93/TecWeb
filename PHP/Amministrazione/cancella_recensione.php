
<?php

include('connect.php');

echo file_get_contents("cancella_recensione_inizio.txt");

$codice= $_POST['codice'];

if ($codice=="")
{echo "<br><h1>Inserire il codice</h1>";}
else{
if (!(mysqli_stmt_num_rows(mysqli_multi_query($db,"SELECT * FROM `recensione` WHERE id='$codice'"))))
{echo '<br><h1>Recensione non presente';}
else{
$delete = "DELETE FROM `recensione` WHERE id='$codice' ''";
} 
}
$result = mysqli_multi_query($db,$delete);
if($result){
	echo("<br><h1>Cancellazione avvenuta correttamente</h1>");
} else{
	echo("<br><h1>Cancellazione non eseguita</h1>");
}
echo file_get_contents("cancella_recensione_fine.txt");
?>
