
<?php

include('connect.php');

echo file_get_contents("inserisci_recensione_inizio.txt");
$codice= $_POST['codice'];
$libro= $_POST['libro'];
$autore= $_POST['autore'];
$testo= $_POST['testo'];
$data= $_POST['data'];
$valutazione= $_POST['valutazione'];

if (($codice=="") or ($libro=="") or ($autore=="") or ($data=="") or ($testo="") or ($valutazione="")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else

{
if (!(mysqli_stmt_num_rows(mysqli_multi_query($db,"SELECT * FROM `libro` WHERE isbn='$libro'"))))
{echo '<br><h1>Libro non presente';}
else{
$insert="INSERT INTO `recensione` VALUES ('$id','$libro','$autore','$data','$testo', '$valutazione')";

} 
} 
$result = mysqli_multi_query($db,$insert);

if($result){
	echo("<br> <H1>Inserimento avvenuto correttamente</H1>");
} else{
	echo("<br><H1>Inserimento non eseguito</h1>");
} 
echo file_get_contents("inserisci_recensione_fine.txt");
?>


