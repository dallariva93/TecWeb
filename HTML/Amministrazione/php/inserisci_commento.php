
<?php

include('connect.php');

echo file_get_contents("inserisci_commento_inizio.txt");
$codice= $_POST['id'];
$commento= $_POST['commento'];
$autore= $_POST['autore'];
$data= $_POST['data'];

if (($codice=="") or ($autore=="") or ($data=="") or ($commento=="")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else

{
if (!(mysqli_stmt_num_rows(mysqli_multi_query($db,"SELECT * FROM `recensione` WHERE id='$codice'"))))
{echo '<br><h1>Recensione non presente';}
else{
$insert="INSERT INTO `commento` VALUES ('$codice','$autore','$commento','$data',)";

} 
} 
$result = mysqli_multi_query($db,$insert);

if($result){
	echo("<br> <H1>Inserimento avvenuto correttamente</H1>");
} else{
	echo("<br><H1>Inserimento non eseguito</h1>");
} 
echo file_get_contents("inserisci_commento_fine.txt");
?>


