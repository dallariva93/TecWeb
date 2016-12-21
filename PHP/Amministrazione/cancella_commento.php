
<?php

include('connect.php');

echo file_get_contents("cancella_commento_inizio.txt");

$codice= $_POST['id'];
$autore= $_POST['autore'];
$data= $_POST['data'];

if (($codice=="") or ($autore=="") or ($data=="") or ($commento=="")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else
{
if (!(mysqli_stmt_num_rows(mysqli_multi_query($db,"SELECT * FROM `recensione` WHERE id='$codice'"))))
{echo '<br><h1>Commento non presente';}
else{
$delete = "DELETE FROM `commento` WHERE recensione='$codice' AND autore='$autore' AND Data_Pubblicazione='$data' ''";
} 
}
$result = mysqli_multi_query($db,$delete);
if($result){
	echo("<br><h1>Cancellazione avvenuta correttamente</h1>");
} else{
	echo("<br><h1>Cancellazione non eseguita</h1>");
}
echo file_get_contents("cancella_commento_fine.txt");
?>