
<?php

echo file_get_contents("voto_recensione_inizio.txt");

include('connect.php');

$codice= $_POST['codice'];
$autore= $_POST['autore'];
$valutazione= $_POST['valutazione'];

if (($codice=="") or ($autore=="") or ($valutazione="")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else

{
if (!(mysqli_stmt_num_rows(mysqli_multi_query($db,"SELECT * FROM `revensione` WHERE id='$codice'"))))
{echo '<br><h1>Libro non presente';}
else{
$insert="INSERT INTO `VotoRecensione` VALUES ('$id','$autore',''$valutazione')";

} 
} 
$result = mysqli_multi_query($db,$insert);

if($result){
	echo("<br> <H1>Inserimento avvenuto correttamente</H1>");
} else{
	echo("<br><H1>Inserimento non eseguito</h1>");
} 
echo file_get_contents("voto_recensione_fine.txt");

?>


