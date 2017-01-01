
<?php

include('connect.php');

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

$codice= $_POST['codice'];
$autore= $_POST['autore'];
$data= $_POST['data'];

if (($codice=="") or ($autore=="") or ($data=="")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else
{
$delete = "DELETE FROM `Commento` WHERE Recensione='$codice' AND Autore='$autore' AND Data_Pubblicazione='$data'  " ;
}
$result = mysqli_multi_query($db,$delete);
if($result){
	echo("<br><h1>Cancellazione avvenuta correttamente</h1>");
} else{
	echo("<br><h1>Cancellazione non eseguita</h1>");
}
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");
?>