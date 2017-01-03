<?php

include('connect.php');

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

$codice= $_POST['codice'];
$titolo= $_POST['titolo'];
$autore= $_POST['autore'];
$testo= $_POST['testo'];
$data= $_POST['data'];

if (($codice=="") or ($titolo=="") or ($testo=="") or ($data=="") or ($autore=="")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else

{

$insert="INSERT INTO `Notizie` VALUES ('$codice','$titolo','$autore','$data','$testo')" ;


} 
$result = mysqli_multi_query($db,$insert);

if($result){
	echo("<br> <H1>Inserimento avvenuto correttamente</H1>");
} else{
	echo("<br><H1>Inserimento non eseguito</h1>");
} 
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");
?>


